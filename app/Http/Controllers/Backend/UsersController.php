<?php

namespace App\Http\Controllers\backend;

use App\Helpers\Actions;
use App\Helpers\Datatable;
use App\Http\Controllers\Controller;
use App\Models\Panel\User;
use App\Rules\UserGroupRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UsersController extends Controller
{
    protected $model = User::class;
    protected $dir_name = "users";
    protected $list_title = "Kullanıcılar";
    protected $create_title = "Kullanıcı";
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return $this->getList();
        } catch (\BadMethodCallException $e){
            echo 'Hata: ',  $e->getMessage();
        }
    }

    public function show($id)
    {
        try {
            $this->data['model'] = $this->model::find($id);
            $this->data['title'] = "Kullanıcı Profili";
            if(auth()->user()->id == $id){
                $this->data['card_title'] = $this->data['model']->name . " - Profilim";
            }else{
                $this->data['card_title'] = $this->data['model']->name . " - Profili";
            }

        }catch (\Exception $e) {
            return redirect()->to(url(\request()->segment(1)))->with('message', 'Aradığınız kayıt bulunamadı.');
        }
        return view('panel.users.show', $this->data)->with(\request()->all());
    }

    public function create()
    {
        $this->data['title']        = 'Yeni ' . $this->create_title;
        $this->data['card_title']   = $this->list_title . " - Yeni " . $this->create_title;

        return view('panel.' . $this->dir_name . '.create', $this->data);
    }

    public function edit($id)
    {
        $this->data['title']        = $this->create_title . ' Düzenle';
        $this->data['card_title']   = $this->list_title . " - " . $this->create_title . ' Düzenle';

        try {
            $this->data['model'] = $this->model::find($id);
        } catch (\Exception $e) {
            return redirect()->to(url(\request()->segment(1)))->with('message', 'Aradığınız kayıt bulunamadı.');
        }
        return view('panel.' . $this->dir_name . '.edit', $this->data)->with(\request()->all());
    }

    public function store(Request $request)
    {
        $this->validator($request, null);

        try {
            $fields = array(
                'name'          => request()->get('name'),
                'email'         => request()->get('email'),
                'user_group_id' => request()->get('user_group_id'),
                'password'      => \Hash::make(\request()->get('password')),
                'created_by'    => auth()->user()->id,
                'role'          => "admin",
                'status'        => $request->get('status') == null ? 0 : 1,
            );

            if ($request->get("image"))
                $fields["image"] = str_replace(config("app.url"), "", $request->get("image"));


            $this->model::create($fields);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        } finally {
            log_add(request()->get('name') . ' adında yeni kullanıcı kaydı eklendi.');
            return redirect()->to(_route('index'))->with('success', 'Başarılı: Kayıt başarıyla eklendi!');
        }
    }

    public function destroy($id, Request $request)
    {
        if(request()->method() == 'DELETE'){
            if(\request()->get('action') == 'remove_back' ){
                return Actions::RemoveBack($this->model, "id");
            } elseif(\request()->get('action') == 'remove' ){
                if($id != null) {
                    $request["id"] = $id;
                }
                return Actions::Remove($this->model, "id");
            } else {
                return Actions::destroy($this->model, "id");
            }

        }
    }

    public function update(Request $request, $id)
    {
        $this->validator($request, $id);

        try {
            $except = array('password_confirmation');
            if($request->input('password')){
                $request['password'] = Hash::make($request->input('password'));
            } else {
                $except = ['password', 'password_confirmation'];
            }

            $except = array_merge($except, array('_token', '_method'));
            $model = $this->model::find($id);

            if ($model) {
                if ($request->get("image"))
                    $request["image"] = str_replace(config("app.url"), "", $request->get("image"));


                $request['updated_by'] = \auth()->user()->id;

                $model->fill(request()->except($except));
                $model->save();
            }

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        } finally{
            log_add($id . '\'li kullanıcı kayıt güncellendi.');

            return redirect()->to(_route('index'))->with(['success' => "Başarılı: Kayıt başarıyla güncellendi!"]);
        }
    }

    protected function validator(Request $request, $id = null)
    {
        $attributes = [
            'name'                  => "Ad Soyad",
            'email'                 => "E-Posta",
            'password'              => "Şifre",
            'password_confirmation' => "Şifre Tekrar",
        ];

        $rules = [
            'name'          => 'required|min:3|max:255',
            'email'         => ['required', 'email', Rule::unique('users')->ignore($id)],
            'user_group_id' => [new UserGroupRule($id)],
        ];

        if($request->input('password') || $request->getMethod() == 'POST'){
            $rules['password'] = ['required', 'confirmed', Password::min(8)];
        }

        $request->validate($rules, [], $attributes);
    }

    protected function getList($id = null){
        $datatable = new Datatable();

        /* FIELDS */
        $datatable->addField('name', 'Kullanıcı Adı', true, function ($row){
            $name_add = "";
            if($row->role == 'customer') $name_add = '<span class="badge rounded-pill bg-primary ms-1 float-end">Müşteri</span>';
            else $name_add = '<span class="badge rounded-pill bg-danger ms-1 float-end">Admin</span>';

            return '<td><a href="'.route('users.edit', $row->id).'">'.$row->name.'</a>'.$name_add.'</td>';
        });

        $datatable->addField('email', 'Email', true, function ($row){
            return '<td>'.$row->email.'</td>';
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
        $datatable->setTitle('Kullanıcılar');
        $datatable->setCardTitle('Kullanıcılar - Liste');
        $datatable->div_column('col-xl-12 col-xs-12');
        $datatable->deleted();
        if(_user_role('super'))
            $datatable->deleted(true);

        $datatable->primarykey();
        $datatable->addSearch('name');
        $datatable->addSearch('email');
        $datatable->setLimit(25);

        // get all the users
        $query = $this->model::orderBy('name','asc');

        $datatable->setModel($query);
        return $datatable->Render();
    }
}
