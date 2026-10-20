<?php

namespace App\Http\Controllers\backend;

use App\Models\Panel\Settings;
use Illuminate\Http\Request;

class SettingController extends ActionController
{
    protected $model = "";
    protected $dir_name = "settings";
    protected $list_title = "Ayarlar";
    protected $create_title = "Ayar";

    public function __construct()
    {
        $this->model = new Settings();
    }

    public function index()
    {
        $this->data['title']        = $this->list_title;
        $this->data['card_title']   = "Yönetim Paneli - " . $this->list_title;
        $this->data["model"]        = $this->model->where('code', 'config')->first();
        $this->data["values"]       =  [];

        if (!empty($this->data["model"]->value))
            $this->data["values"]   = json_decode(json_encode($this->data["model"]->value));

        return view('panel.'.$this->dir_name, $this->data);
    }

    protected function getCreateForm()
    {
        abort(404);
        $this->data['title']        = 'Yeni ' . $this->create_title;
        $this->data['card_title']   = $this->list_title . " - Yeni " . $this->create_title;

        return view('panel.' . $this->dir_name . '.create', $this->data);
    }

    protected function getEditForm($id)
    {
        abort(404);
        $this->data['model']        = $this->model::find($id);
        $this->data['title']        = $this->create_title . ' Düzenle';
        $this->data['card_title']   = $this->list_title . " - " . $this->create_title . ' Düzenle';

        return view('panel.' . $this->dir_name . '.edit', $this->data);
    }

    protected function actions(Request $request, $id)
    {
        $values = $request->get("value");

        if (isset($values["app"]["logo"]))
            $values["app"]["logo"] = str_replace(config("app.url"), "", $values["app"]["logo"]);

        if (isset($values["app"]["footer_logo"]))
            $values["app"]["footer_logo"] = str_replace(config("app.url"), "", $values["app"]["footer_logo"]);

        $fields = array(
            "value" => $values,
        );

        $fields['created_by'] = 1;
        $fields['updated_by'] = auth()->id();

        try {
            $this->model::updateOrCreate(array("id" => $id), $fields);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        } finally {
            log_add('Ayarlar güncellendi.');
            return redirect()->back()->with('success', 'Başarılı: Kayıt başarıyla güncellendi!');
        }
    }

}
