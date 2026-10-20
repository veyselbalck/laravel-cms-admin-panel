<?php

namespace App\Http\Controllers\backend;

use App\Helpers\Actions;
use App\Helpers\Datatable;
use App\Models\Panel\SeoRedirect;
use Illuminate\Http\Request;

class SeoRedirectController extends ActionController
{
    protected $model = "";
    protected $dir_name = "seo_redirect";
    protected $list_title = "SEO URL Yönlendirme";
    protected $create_title = "SEO URL";

    public function __construct()
    {
        $this->model = new SeoRedirect();
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
            "title"         => $request->get('title'),
            "address"       => $request->get('address'),
            "redirect"      => $request->get('redirect'),
            "http_status"   => $request->get('http_status'),
        );

        return Actions::Save($request, $this->model, $fields, $id);
    }


    protected function validator(Request $request, $id = null)
    {

        $rules = array(
            'title' => 'required',
            'address' => 'required',
            'redirect' => 'required',
            'http_status' => 'required|max:5',
        );
        $attributes = array(
            'title' => 'Başlık',
            'address' => 'Geçerli Adres',
            'redirect' => 'Yönlendirilen Adres',
            'http_status' => 'HTTP Status',
        );

        $request->validate($rules, [], $attributes);
    }

    protected function getList($id = null){
        $datatable = new Datatable();

        /* FIELDS */
        $datatable->addField('title', 'Başlık', true, function ($row){
            return '<td><a href="'.route('seo_redirect.edit', $row->id).'">'.$row->title.'</a></td>';
        });

        $datatable->addField('address', 'Geçerli Adres', true, function ($row){
            return '<td>'.$row->address.'</td>';
        });

        $datatable->addField('redirect', 'Yönlendirilen Adres', true, function ($row){
            return '<td>'.$row->redirect.'</td>';
        });


        $datatable->addField('http_status', 'HTTP Status', true, function ($row){
            return '<td>'.$row->http_status.'</td>';
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
        $datatable->deleted(true);
        $datatable->primarykey();
        $datatable->addSearch('title');
        $datatable->setLimit(25);

        // get all the users
        $query = $this->model::orderBy('title','asc');

        $datatable->setModel($query);
        return $datatable->Render();
    }
}
