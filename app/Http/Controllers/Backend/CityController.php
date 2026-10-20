<?php

namespace App\Http\Controllers\backend;

use App\Helpers\Actions;
use App\Helpers\Datatable;
use App\Models\Panel\City;
use Illuminate\Http\Request;

class CityController extends ActionController
{
    protected $model = "";
    protected $dir_name = "city";
    protected $list_title = "Şehirler";
    protected $create_title = "Şehir";

    public function __construct()
    {
        $this->model = new City();
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
            "code" => $request->get('code'),
            "country_id" => $request->get('country_id'),
            "status" => $request->get('status') == null ? 0 : 1,
        );

        return Actions::Save($request, $this->model, $fields, $id);
    }


    protected function validator(Request $request, $id = null)
    {
        $attributes = [
            'name'  => 'Şehir Adı',
            'code'  => 'Şehir Kodu',
            'country_id'  => 'Ülke',
        ];

        $request->validate([
            'name'          => ['required', 'min:4'],
            'code'          => ['required'],
            'country_id'    => ['required'],
        ], [], $attributes);
    }

    protected function getList($id = null){
        $datatable = new Datatable();

        /* FIELDS */
        $datatable->addField('name', 'Şehir Adı', true, function ($row){
            return '<td><a href="'.route('city.edit', $row->id).'">'.$row->name.'</a></td>';
        });

        $datatable->addField('ülke', 'Ülke', true, function ($row){
            $country = isset($row->country->name) ? $row->country->name : '-';
            return '<td>'.$country.'</td>';
        });

        $datatable->addField('code', 'Şehir Kodu', true, function ($row){
            return '<td>'.$row->code.'</td>';
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
