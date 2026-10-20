<?php

namespace App\Http\Controllers\backend;

use App\Helpers\Actions;
use App\Http\Controllers\Controller;
use App\Http\Traits\PanelBreadcrumbsTraits;
use App\Http\Traits\PanelInputTraits;
use App\Http\Traits\PanelModelTraits;
use App\Http\Traits\PanelRouteTraits;
use App\Models\Panel\Languages;
use App\Models\Panel\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ActionController extends Controller
{
    use PanelRouteTraits, PanelBreadcrumbsTraits, PanelModelTraits, PanelInputTraits;
    protected $model;
    protected $id_name      = '';

    public function __construct()
    {
        if(Schema::hasTable("settings")){
            foreach (Settings::all()->pluck('value', 'code') as $code => $value) {
                foreach ($value as $key => $item) {
                    if(is_array($item)){
                        foreach ($item as $k => $v) {
                            config()->set($key . '.' . $k, $v);
                        }
                    }else{
                        config()->set($key, $item);
                    }
                }
            }
        }


        date_default_timezone_set(config('app.timezone'));

        $lang = Languages::where('code', config('app.locale'))->first();

        if ($lang){
            $this->_lang_id = $lang->id;
            $this->_lang_code = $lang->code;
            $this->_lang_name = $lang->name;
            $this->data["_lang_name"] = $lang->name;
            app()->setLocale($lang->code);
        }
    }

    public function create()
    {
        try {
            return $this->getCreateForm();
        } catch (\BadMethodCallException $e){
            echo 'Hata: ',  $e->getMessage();
        }

    }

    public function edit($id)
    {
        try {
            return $this->getEditForm($id);
        } catch (\BadMethodCallException $e){
            echo 'Hata: ',  $e->getMessage();
        }

    }

    public function store(Request $request)
    {
        if(request()->method() == 'POST'){
            try {
                if($request->get('action') == 'sortable'){
                    return Actions::sort_order($request, $this->model, $this->primary_key, $this->id_name);
                } else {
                    return $this->actions($request, null);
                }

            } catch (\BadMethodCallException $e){
                echo 'Hata: ',  $e->getMessage();
            }
        }
    }

    public function update(Request $request, $id)
    {
        try {
            if((request()->method() == 'PATCH' || request()->method() == 'PUT')){
                if($request->get('action') == 'status_update'){
                    return Actions::StatusSave($request, $this->model, $this->primary_key);
                }
                return $this->actions($request, $id);
            }
        } catch (\BadMethodCallException $e){
            echo 'Hata: ',  $e->getMessage();
        }
    }

    public function destroy($id, Request $request)
    {
        if(request()->method() == 'DELETE'){
            if(\request()->get('action') == 'remove_back' ){
                return Actions::RemoveBack($this->model, $this->primary_key);
            } elseif(\request()->get('action') == 'remove' ){
                if($id != null) {
                    $request["id"] = $id;
                }
                return Actions::Remove($this->model, $this->primary_key);
            } else {
                return Actions::destroy($this->model, $this->primary_key);
            }
        }
    }
}
