<?php

namespace App\Http\Controllers\backend;

use App\Helpers\Actions;
use App\Helpers\Datatable;
use App\Models\Panel\UserGroup;
use App\View\Components\Panel\Menu;
use Illuminate\Http\Request;

class RolesController extends ActionController
{
    protected $model = "";
    protected $dir_name = "roles";
    protected $list_title = "Kullanıcı Grupları";
    protected $create_title = "Kullanıcı Grubu";

    public function __construct()
    {
        $this->model = new UserGroup();
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

        $menus = new Menu();
        $this->data["permissionList"]  = json_decode(json_encode($menus->list()));

        return view('panel.' . $this->dir_name . '.create', $this->data);
    }

    protected function getEditForm($id)
    {
        $this->data['model']        = $this->model::find($id);
        $this->data['title']        = $this->create_title . ' Düzenle';
        $this->data['card_title']   = $this->list_title . " - " . $this->create_title . ' Düzenle';

        $menus = new Menu();
        $this->data["permissionList"]  = json_decode(json_encode($menus->list()));

        return view('panel.' . $this->dir_name . '.edit', $this->data);
    }

    protected function actions(Request $request, $id)
    {
        $this->validator($request, $id);

        $fields = array(
            "name"          => $request->get('name'),
            "permission"    => $request->get('permission'),
            "status"        => $request->get('status') == null ? 0 : 1,
        );

        return Actions::Save($request, $this->model, $fields, $id);
    }

    protected function validator(Request $request, $id = null)
    {
        $attributes = [
            'name'  => 'Grup Adı',
        ];

        $request->validate([
            'name' => ['required', 'min:4'],
        ], [], $attributes);
    }

    protected function getList($id = null){
        $datatable = new Datatable();

        /* FIELDS */
        $datatable->addField('name', 'Grup Adı', true, function ($row){
            return '<td><a href="'.route('roles.edit', $row->id).'">'.$row->name.'</a></td>';
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
        $datatable->div_column('col-xl-10 col-lg-12 col-xs-12');
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
