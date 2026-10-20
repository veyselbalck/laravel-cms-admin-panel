<?php

namespace App\Http\Controllers\backend;

use App\Helpers\Actions;
use App\Helpers\Datatable;
use App\Models\Panel\Country;
use Illuminate\Http\Request;

class CountryController extends ActionController
{
    protected $model = "";
    protected $dir_name = "country";
    protected $list_title = "Ülkeler";
    protected $create_title = "Ülke";

    public function __construct()
    {
        $this->model = new Country();
    }

    public function index()
    {
        try {
            return $this->getList();
        } catch (\BadMethodCallException $e) {
            echo 'Hata: ', $e->getMessage();
        }
    }

    protected function getCreateForm()
    {
        $this->data['title']        = 'Yeni ' . $this->create_title;
        $this->data['card_title']   = $this->list_title . " - Yeni " . $this->create_title;

        return view('panel.' . $this->dir_name . '.create', $this->data);
    }

    protected function getEditForm($id)
    {
        $this->data['model']        = $this->model::find($id);
        $this->data['title']        = $this->create_title . ' Düzenle';
        $this->data['card_title']   = $this->list_title . " - " . $this->create_title . ' Düzenle';

        return view('panel.' . $this->dir_name . '.edit', $this->data);
    }


    protected function actions(Request $request, $id)
    {
        $this->validator($request);

        $fields = array(
            "name" => $request->get('name'),
            "iso_code_2" => $request->get('iso_code_2'),
            "iso_code_3" => $request->get('iso_code_3'),
            "address_format" => $request->get('address_format'),
            "postcode_required" => $request->get('postcode_required') == null ? 0 : 1,
            "status" => $request->get('status') == null ? 0 : 1,
        );

        return Actions::Save($request, $this->model, $fields, $id);
    }


    protected function validator(Request $request, $id = null)
    {
        $attributes = [
            'name'  => 'Ülke Adı',
            'iso_code_2'  => 'ISO Kodu (2)',
            'iso_code_3'  => 'ISO Kodu (3)',
        ];

        $request->validate([
            'name' => ['required', 'min:4'],
            'iso_code_2' => ['required'],
            'iso_code_3' => ['required'],
        ], [], $attributes);
    }

    protected function getList($id = null){
        $datatable = new Datatable();

        /* FIELDS */
        $datatable->addField('name', 'Ülke Adı', true, function ($row){
            return '<td><a href="'.route('country.edit', $row->id).'">'.$row->name.'</a></td>';
        });

        $datatable->addField('iso_code_2', 'ISO Kodu (2)', true, function ($row){
            return '<td>'.$row->iso_code_2.'</td>';
        });

        $datatable->addField('iso_code_3', 'ISO Kodu (3)', true, function ($row){
            return '<td>'.$row->iso_code_3.'</td>';
        });

        $datatable->addField('postcode_required', 'Posta Kodu',false, function ($row){
            return status($row->postcode_required, 1, $row->id);
        });

        $datatable->addField('status', 'Durumu',false, function ($row){
            return status($row->status, 1, $row->id);
        });

        /* SUB FIELDS */
        $datatable->addSubField('created_by', 'Ekleyen', function($row){
            return isset($row->creator->name) ? $row->creator->name : '-';
        });
        $datatable->addSubField('created_at', 'Ekleme Tarihi', function ($row){
            return date_tr('d M Y l H:i', $row->created_at);
        });
        $datatable->addSubField('updated_by', 'Güncelleyen', function($row){
            return isset($row->last_modifier->name) ? $row->last_modifier->name : '-';
        });
        $datatable->addSubField('updated_at', 'Güncelleme Tarihi', function ($row){
            return isset($row->updated_at) ? date_tr('', $row->updated_at) : '';
        });

        /* SETTINGS */
        $datatable->setTitle($this->list_title);
        $datatable->setCardTitle($this->list_title.' - Liste');
        $datatable->div_column('col-xl-12 col-lg-12 col-xs-12');
        $datatable->deleted();
        if(_user_role('super'))
            $datatable->deleted(true);

        $datatable->primarykey();
        $datatable->addSearch('name');
        $datatable->setLimit(25);

        // get all the users
        $query = $this->model::orderBy('name','asc');

        $datatable->setModel($query);
        return $datatable->Render();
    }
}
