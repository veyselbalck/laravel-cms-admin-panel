<?php

namespace App\Http\Controllers\backend;

use App\Models\Panel\City;
use App\Models\Panel\Contents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JsonController extends ActionController
{
    public function show(Request $request, $method){
        if(method_exists($this, $method)){
            return $this->$method();
        }
    }

    public function city(){
        return response()->json(City::where('country_id', \request()->get('country_id'))->pluck('name', 'id'));
    }

    public function content_sort_order(){

        $attributes = [
            'id' => 'ID',
//            'parent_id' => 'Üst Kategori',
            'sort_order' => 'Sıralama',
        ];

        $rules = [
            'id'            => 'present',
//            'parent_id'     => 'present',
            'sort_order'    => 'present'
        ];
        $validator = Validator::make(\request()->all(),$rules, [], $attributes);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if(\request()->get("sort_order")){
            $encode = json_encode(\request()['sort_order']);
            $decode = str_replace('_', "", $encode);
            $decode = json_decode($decode, 1);
            \request()['sort_order'] = $decode;
        }

        if(\request()->get("parent_id")){
            $encode = json_encode(\request()['parent_id']);
            $decode = str_replace('_', "", $encode);
            $decode = json_decode($decode, 1);
            \request()['parent_id'] = $decode;
        }


        $id = \request()->input('id');
        $parent_id = \request()->input('parent_id');
        $sort_order = \request()->input('sort_order');

        $contents = Contents::find($id);

        $contents->update(['parent_id' => $parent_id]);

        $updates = array();
        foreach ($sort_order as $index => $item) {
            $updates[] = "UPDATE `contents` SET `sort_order` = '".$index."' WHERE `contents`.`id` = ".$item;
        }

        DB::unprepared(implode('; ', $updates));

        return response()->json(['success' => $contents->name. " adlı içerik sırası güncellendi."]);

    }

    public function contents(){

        $json = array();
        $filter_name            = \request()->get('filter_name');
        $filter_limit           = \request()->has('limit') ? \request()->get('limit') : 20;
        $filter_language_id     = \request()->has('language_id') ? \request()->get('language_id') : config('app.language_id');
        $results = Contents::leftJoin('contents_description', 'contents.id', '=', 'contents_description.contents_id')
            ->where('contents_description.name', 'LIKE', '%' . $filter_name . '%')
            ->where('contents_description.language_id', $filter_language_id)
            ->limit($filter_limit)
            ->get();
        foreach ($results as $result) {
            $json[] = array(
                'label'     => $result->category ? $result->category->ParentName . ' > ' . $result->name : $result->name,
                'value'     => $result->meta_title,
                'href'     => getContentSlug($result, $filter_language_id, false),
            );
        }
        return $json;

    }
}
