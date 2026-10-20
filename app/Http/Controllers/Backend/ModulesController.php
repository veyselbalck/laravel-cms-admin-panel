<?php

namespace App\Http\Controllers\backend;

use App\Helpers\Actions;
use App\Models\Panel\Modules;
use Illuminate\Http\Request;

class ModulesController extends ActionController
{
    protected $model = Modules::class;
    protected $dir_name = "modules";
    protected $list_title = "Modüller";
    protected $create_title = "Modül";
    protected $modules = [];

    public function __construct()
    {
        $this->model = new Modules();

        foreach (ModuleCategories() as $k => $v) {
            if($v["create"]) {
                $this->modules[$k] = $v["name"];
            }
        }
    }

    public function index(Request $request)
    {
        try {
            return $this->getList($request);
        } catch (\BadMethodCallException $e) {
            echo 'Hata: ', $e->getMessage();
        }
    }

    protected function getList($request) {
        $code = "carousel";
        if($request->get("code") && array_key_exists(\request()->get("code"), $this->modules))
            $code = $request->get("code");

        $title = ModuleCategories()[$code]["name"];
        $this->data['title']        = $this->list_title;
        $this->data['card_title']   = $this->list_title . " - " . $title . "-Liste";

        $modules = $this->model::where("code", $code)->get();

        $this->data["model"] = $modules;
        $this->data["code"] = $code;

        return view('panel.' . $this->dir_name . '.list', $this->data);
    }

    protected function getCreateForm()
    {
        if(\request()->get("code") && array_key_exists(\request()->get("code"), $this->modules)) {
            $code = \request()->get("code");
            $title = ModuleCategories()[$code]["name"];

            $this->data['title'] = 'Yeni ' . $title;
            $this->data['card_title'] = $this->list_title . " - Yeni " . $title;

            $this->data["code"] = $code;

            return view('panel.' . $this->dir_name . '.common.' . $code, $this->data);
        } else
            return redirect()->back()->with("error", "Modül kodu bulunamadı.");
    }

    protected function getEditForm($id)
    {
        if(\request()->get("code") && array_key_exists(\request()->get("code"), $this->modules)) {
            $code = \request()->get("code");
            $title = ModuleCategories()[$code]["name"];

            $model                      = $this->model::find($id);
            $this->data['model']        = $model;
            $this->data['title']        = $title . ' Düzenle';
            $this->data['card_title']   = $this->list_title . " - " . $title . ' - Düzenle';

            $items = [];
            if (!empty($model->settings["items"])) {
                $items = $model->settings["items"];
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

            $this->data["items"] = $items;
            $this->data["code"] = $code;
            $this->data["form"] = 'edit';

            return view('panel.' . $this->dir_name . '.common.' . $code, $this->data);
        } else
            return redirect()->back()->with("error", "Modül kodu bulunamadı.");
    }

    protected function actions(Request $request, $id)
    {
        if(\request()->get("code") && array_key_exists(\request()->get("code"), $this->modules)) {
            $code = \request()->get("code");

            $this->validator($request, $id);

            if($request->get("settings")){
                $encode = json_encode($request['settings']);
                $decode = str_replace(str_replace("/", "\/", config("app.url")), "", $encode);
                $decode = json_decode($decode, 1);
                $request['settings'] = $decode;
            }

            $fields = array(
                "name"          => $request->get('name'),
                "code"          => $code,
                "template"      => $request->get('template') ? $request->get('template') : 'default',
                "settings"      => $request->get('settings'),
                "status"        => $request->get('status') == null ? 0 : intval($request->get('status')),
            );

            return Actions::Save($request, $this->model, $fields, $id);

        } else {
            return redirect()->back()->with("error", "Modül kodu bulunamadı.");
        }
    }

    protected function validator(Request $request, $id = null)
    {
        $attributes = [
            'name'  => 'Modül Adı',
        ];

        $request->validate([
            'name' => ['required', 'min:3'],
        ], [], $attributes);
    }


    public function copy(Request $request, $id){
        $content = $this->model::find($id);
        $fields = array(
            "name"      => $content->name." Copy",
            "code"      => $content->code,
            "template"  => $content->template,
            "settings"  => $content->settings,
            "status"    => $content->status,
        );
        return Actions::Save($request, $this->model, $fields);
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
