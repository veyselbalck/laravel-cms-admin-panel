<?php

namespace App\Http\Controllers\backend;

use App\Helpers\Actions;
use App\Helpers\Datatable;
use App\Models\Panel\Languages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class LanguagesController extends ActionController
{
    protected $model = Languages::class;
    protected $dir_name = "languages";
    protected $list_title = "Diller";
    protected $create_title = "Dil";

    public function __construct()
    {
        $this->model = new Languages();
        parent::__construct();
    }

    public function index()
    {
        try {
            return $this->getList();
        } catch (\BadMethodCallException $e) {
            echo 'Hata: ', $e->getMessage();
        }
    }

    protected function getList($id = null){
        $datatable = new Datatable();

        /* FIELDS */
        $datatable->addField('name', 'Dil', true, function ($row){
            return '<td><a href="'.route('languages.edit', $row->id).'">'.$row->name.'</a></td>';
        });

        $datatable->addField('code', 'Code', true, function ($row){
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
        $datatable->div_column('col-xl-8 col-lg-10 col-xs-12');
        $datatable->deleted();
        if (auth()->user()->email != "mehmet@designneuro.com")
            $datatable->created(false);

        if(_user_role('super')) {
            $datatable->deleted(true);
        }
        $datatable->primarykey();
        $datatable->addSearch('title');
        $datatable->setLimit(25);

        // get all the users
        $query = $this->model::orderBy('name','asc');

        $datatable->setModel($query);
        return $datatable->Render();
    }

    protected function localization(){
        $this->data['localization'] = array();
        $this->data['translations'] = array();

        $allFiles = collect(File::allFiles(base_path( 'lang/'.$this->_lang_code )))
            ->filter(function ($file) {
                return in_array($file->getExtension(), ['php']) && !in_array($file->getFilenameWithoutExtension(), ['auth', 'pagination', 'passwords', 'validation', 'users']);
            })
            ->sortBy(function ($file) {
                return $file->getCTime();
            })
            ->map(function ($file) {
                return $file->getFilenameWithoutExtension();
            });


        foreach($allFiles as $locale_file){
            $this->data['localization'][$locale_file] = array_flat(__($locale_file));
            if($this->data['model'] && is_array(__($locale_file, [], $this->data['model']->code))){
                $this->data['translations'][$locale_file] = array_flat(__($locale_file,[], $this->data['model']->code));
            }
            else{
                $this->data['translations'][$locale_file] = $this->data['localization'][$locale_file];
            }
        }
    }

    protected function getCreateForm()
    {
        $this->data['model']        = $this->model::find(null);
        $this->data['title']        = 'Yeni ' . $this->create_title;
        $this->data['card_title']   = $this->list_title . " - Yeni " . $this->create_title;
        $this->localization();

        return view('panel.' . $this->dir_name . '.create', $this->data);
    }

    protected function getEditForm($id)
    {
        $this->data['model']        = $this->model::find($id);
        $this->data['title']        = $this->create_title . ' Düzenle';
        $this->data['card_title']   = $this->list_title . " - " . $this->create_title . ' Düzenle';
        $this->localization();

        return view('panel.' . $this->dir_name . '.edit', $this->data);
    }


    protected function actions(Request $request, $id)
    {
        $this->validator($request, $id);

        try{
            if (!File::exists(base_path( 'lang/'.$request->input('code') ))){
                File::copyDirectory(base_path( 'lang/'.$this->_lang_code ), base_path( 'lang/'.$request->input('code') ));
            }
            foreach ($request->input('localization') as $groups_key => $groups) {
                $contents = var_export($groups, true);
                File::put(base_path( 'lang/'.$request->input('code').'/'.$groups_key.'.php' ), "<?php" . PHP_EOL . 'return '  . $contents . ';');
            }
        }catch (\Exception $ex){
            return redirect()->back()->withInput()->withErrors($ex->getMessage());
        }

        $fields = array(
            "name"          => $request->get('name'),
            "code"          => mb_strtolower($request->get('code')),
            "sort_order"    => $request->get('sort_order'),
            "status"        => $request->get('status') == null ? 0 : 1,
        );
        return Actions::Save($request, $this->model, $fields, $id);
    }

    protected function validator(Request $request, $id=null)
    {
        $rules = array(
            'name' => 'required|min:3',
            'code' => ['required', 'max:5', Rule::unique('languages')->ignore($id)]
        );

        $attributes = array(
            'name' => 'Dil Adı',
            'code' => 'Dil Kodu',
        );

        if(config('app.locale') == $request->get('code')){
            if((int)$request->get('status') != 1){
                throw ValidationException::withMessages([
                    'status' => 'Varsayılan dilin durumunu değiştiremezsiniz.'
                ]);
            }
        }

        $request->validate($rules, [], $attributes);
    }
}
