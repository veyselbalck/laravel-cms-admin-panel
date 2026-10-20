<?php

namespace App\Http\Controllers\backend;

use App\Helpers\Actions;
use App\Helpers\Datatable;
use App\Models\Panel\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TestimonialController extends ActionController
{
    protected $model = "";
    protected $dir_name = "testimonial";
    protected $list_title = "Görüşler";
    protected $create_title = "Görüş";

    public function __construct()
    {
        $this->model = new Testimonial();
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
            "name"      => $request->get('name'),
//            "title"     => $request->get('title'),
            "message"   => $request->get('message'),
            "datas"     => $request->get('datas'),
            "status"    => $request->get('status') == null ? 0 : 1,
        );

        if ($request->hasFile('image')) {
            $file_name = Str::random(3) . '-' . str_replace(['_', ' '], '-', $request->image->getClientOriginalName());
            $request->image->move(public_path(config('app.testimonial_dir')), $file_name);
            $path = config('app.testimonial_dir'). '/' . $file_name;
            if ($request->get('old_image')) {
                File::delete($request->get('old_image'));
            }
            $fields["profile"] = $path;
        }

        return Actions::Save($request, $this->model, $fields, $id);
    }


    protected function validator(Request $request, $id = null)
    {
        $attributes = [
            'name'  => 'Ad Soyad',
//            'title'  => 'Ünvan',
            'datas.translation.*.message'  => 'Mesaj',
        ];

        $request->validate([
            'name'      => ['required'],
//            'title'     => ['required'],
            'datas.translation.*.message'   => ['required'],
        ], [], $attributes);
    }

    protected function getList($id = null){
        $datatable = new Datatable();

        /* FIELDS */
        $datatable->addField('name', 'Ad Soyad', true, function ($row){
            return '<td><a href="'.route('testimonial.edit', $row->id).'">'.$row->name.'</a></td>';
        });

        $datatable->addField('message', 'Mesaj', true, function ($row){
            $message = !empty($row["datas"]["translation"][getLanguageId()]["message"]) ? $row["datas"]["translation"][getLanguageId()]["message"] : '';
            return '<td>'.limit($message, 100).'</td>';
        });

        $datatable->addField('status', 'Durumu',false, function ($row){
            return status($row->status, 1, $row->id);
        });

        /* SUB FIELDS */
        $datatable->addSubField('created_by', 'Ekleyen', function($row){
            return isset($row->creator->name) ? $row->creator->name : $row->name;
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
        $datatable->addSearch('name');
        $datatable->addSearch('title');
        $datatable->addSearch('message');
        $datatable->setLimit(25);

        $query = $this->model::orderBy('created_at','desc');

        $datatable->setModel($query);
        return $datatable->Render();
    }
}
