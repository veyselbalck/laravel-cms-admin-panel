<?php

namespace App\Http\Controllers\backend;

use App\Helpers\Actions;
use App\Models\Panel\Contents;
use App\Models\Panel\ContentsDescription;
use App\Models\Panel\Modules;
use Illuminate\Http\Request;

class ProductsController extends ActionController
{
    protected $model = Contents::class;
    protected $dir_name = "products";
    protected $list_title = "Ürünler";
    protected $create_title = "Ürün";

    protected $order = 'desc';

    public function __construct()
    {
        $this->model = new Contents();
    }

    public function index()
    {
        try {
            return $this->getList();
        } catch (\BadMethodCallException $e) {
            echo 'Hata: ', $e->getMessage();
        }
    }

    protected function getList() {
        $this->data['title']        = $this->list_title;
        $this->data['card_title']   = $this->list_title . " - Liste ";

        $contents = Contents::with(['children' => function ($q){
            $q->where("content_type", "product");
        }])
            ->where("content_type", "product")
            ->orderBy('sort_order', 'asc')
            ->get();


        foreach ($contents as $content) {
            $content->edit      = \route('products.edit', $content->id);
            $content->destroy   = \route('products.destroy', $content->id);
            $content->copy      = '<a href=\"'.\route('products.copy', $content->id).'\" class=\"btn btn-xs btn-primary\" ><i class=\"bx bx-copy\"></i></a>';
            $content->module    = '<a href=\"'.\route('products.show', $content->id).'\" class=\"btn btn-xs btn-dark\" ><i class=\"bx bx-show\"></i></a>';
            $content->template  = templates("product")[$content->template];
//            $content->parent    = $content->parent->title;
            $content->parent = $content->parent ? $content->parent->title : 'Bağlı Yok';
        }
        $this->data['contents'] = getTreePost($contents, 0, ['id', 'parent_id', 'title', 'subdomain', 'status', 'edit', 'destroy', 'copy', 'href', 'parent', 'module', 'template', 'sort_order']);
//        dd($this->data['contents']);
        return view('panel.' . $this->dir_name . '.list', $this->data);
    }

    protected function getCreateForm()
    {
        $this->data['title']        = 'Yeni ' . $this->create_title;
        $this->data['modules']      = Modules();
        $this->data['card_title']   = $this->list_title . " - Yeni " . $this->create_title;


        return view('panel.' . $this->dir_name . '.create', $this->data);
    }

    protected function getEditForm($id)
    {
        $model = $this->model::with('descriptions')->where("content_type", "=","product")->find($id);
        if($model) {

            $descriptions = [];
            foreach ($model->descriptions as $item) {
                $descriptions[$item->language_id] = [
                    'slug' => $item->slug,
                    'description' => $item->description,
                    'name' => $item->name,
                    'meta_title' => $item->meta_title,
                    'meta_description' => $item->meta_description,
                    'meta_keyword' => $item->meta_keyword,
                ];
            }

            $items = [];
            if (!empty($model->content_datas["items"])) {
                $items = $model->content_datas["items"];
                foreach(getLanguagesByCodeId() as $lang_code => $lang) {
                    if(!empty($items[$lang])) {
                        $array = [];
                        foreach ($items[$lang] as $item) {
                            $array[] = $item;
                        }
                        $array2 = [];
                        $index = 19857525;
                        foreach ($this->bubble_Sort($array) as $item) {
                            $array2[$index] = $item;
                            $index++;
                        }
                        $items[$lang] = $array2;
                    }
                }
            }

            $this->data['items'] = $items;
            $this->data['model'] = $model;
            $this->data['descriptions'] = $descriptions;
            $this->data['modules'] = Modules();
            $this->data['title'] = $this->create_title . ' Düzenle';
            $this->data['card_title'] = $this->list_title . " - " . $this->create_title . ' Düzenle';

            return view('panel.' . $this->dir_name . '.edit', $this->data);
        } else
            return redirect()->to(_route("index"))->with('warning', "Aradığınız ürün bulunamadı.");
    }

    protected function actions(Request $request, $id)
    {
        $this->validator($request, $id);

        if($request->get("descriptions")){
            $encode = json_encode($request['descriptions']);
            $decode = str_replace(str_replace("/", "\/", config("app.url")), "", $encode);
            $decode = json_decode($decode, 1);
            $request['descriptions'] = $decode;
        }

        if($request->get("datas")){
            $encode = json_encode($request['datas']);
            $decode = str_replace(str_replace("/", "\/", config("app.url")), "", $encode);
            $decode = json_decode($decode, 1);
            $request['datas'] = $decode;
        }

        if ($request->get("image"))
            $request["image"] = str_replace(config("app.url"), "", $request->get("image"));

        $fields = array(
            "title"         => $request->get('name'),
            "sort_order"    => $request->get('sort_order'),
            "parent_id"     => $request->get('parent_id'),
            "image"         => $request->get('image'),
            "template"      => $request->get('template') ? $request->get('template') : 'default',
            "content_type"  => $request->get('content_type'),
            "content_datas" => $request->get('datas'),
            "modules"       => $request->get('modules'),
            "status"        => $request->get('status') == null ? 0 : intval($request->get('status')),
        );

        $action = Actions::Save($request, $this->model, $fields, $id);

        if(session()->has('success')) {
            if($id) {
                $contentModel = $this->model::find($id);
            } else {
                $contentModel = $this->model::all()->last();
            }

            if ($request->get("descriptions")) {
                foreach ($request->get("descriptions") as $lang_id => $item) {
                    if (!empty($item["name"])) {
                        $descriptionFields = [
                            'contents_id' => $contentModel->id,
                            'language_id' => $lang_id,
                            'slug' => !empty($item["slug"]) ? $item["slug"] : "",
                            'description' => !empty($item["description"]) ? $item["description"] : "",
                            'name' => $item["name"],
                            'meta_title' => !empty($item["meta_title"]) ? $item["meta_title"] : "",
                            'meta_description' => !empty($item["meta_description"]) ? $item["meta_description"] : "",
                            'meta_keyword' => !empty($item["meta_keyword"]) ? $item["meta_keyword"] : "",
                            'created_by' => auth()->user()->id,
                            "datas" => !empty($item["datas"]) ? $item["datas"] : [],
                        ];
                        ContentsDescription::where('contents_id', $contentModel->id)->where('language_id', $lang_id)->delete();
                        ContentsDescription::create($descriptionFields);
//                        ContentsDescription::updateOrCreate(array('contents_id' => $contentModel->id, 'language_id' => $lang_id), $descriptionFields);
                    }
                }
            }
        }

        return $action;
    }

    protected function validator(Request $request, $id = null)
    {
        $attributes = [
            'name'          => 'Ürün Adı',
            'template'      => 'Şablon Tipi',
            'content_type'  => 'İçerik Tipi',
        ];

        $request->validate([
            'name' => ['required', 'min:3'],
        ], [], $attributes);
    }

    public function copy(Request $request, $id){
        $content = $this->model::find($id);
        $description = ContentsDescription::where("contents_id", $id)->get();
        $fields = array(
            "title"         => $content->title." Copy",
            "sort_order"    => $content->sort_order,
            "parent_id"     => $content->parent_id,
            "image"         => $content->image,
            "template"      => $content->template,
            "content_type"  => $content->content_type,
            "content_datas" => $content->datas,
            "modules"       => $content->modules,
            "status"        => $content->status,
        );
        $action = Actions::Save($request, $this->model, $fields);
        if(session()->has('success')) {
            $contentModel = $this->model::all()->last();
            foreach ($description as $item) {
                $descriptionFields = [
                    'contents_id'       => $contentModel->id,
                    'language_id'       => $item->language_id,
                    'slug'              => $item->slug."-copy",
                    'description'       => $item->description,
                    'name'              => $item->name." Copy",
                    'meta_title'        => $item->meta_title,
                    'meta_description'  => $item->meta_description,
                    'meta_keyword'      => $item->meta_keyword,
                    'created_by'        => $item->created_by,
                    "datas"             => $item->datas,
                ];
                ContentsDescription::updateOrCreate(array('contents_id' => $contentModel->contents_id, 'language_id' => $item->language_id), $descriptionFields);
            }
        }

        return $action;
    }

    protected function bubble_Sort($array)
    {
        $sort_error = 0;
        $old_array = $array;
        do
        {
            $swapped = false;
            for( $i = 0, $c = count($array) - 1; $i < $c; $i++ )
            {
                if(!empty($array[$i]["sort_order"])) {
                    if ($array[$i]["sort_order"] > $array[$i + 1]["sort_order"]) {
                        list($array[$i + 1], $array[$i]) = array($array[$i], $array[$i + 1]);
                        $swapped = true;
                    }
                } else
                    $sort_error++;
            }
        }
        while( $swapped );

        if($sort_error)
            return $old_array;

        return $array;
    }
}
