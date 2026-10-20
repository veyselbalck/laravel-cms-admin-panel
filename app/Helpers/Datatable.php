<?php


namespace App\Helpers;


use Illuminate\Support\Facades\DB;

class Datatable
{

    public $data = array(
        'fields' => array(),
        'limited' => true,
        'sortable' => false,
        'created' => true,
        'created_link' => '',
        'deleted' => false,
        'edited' => true,
        'limit' => 10,
        'search' => array(),
        'filters' => array(),
    );

    public function addField($key, $title, $sort = false, $cb = null){
        $this->data['fields'][$key] = array('title' => $title);
        if($sort){
            $this->data['fields'][$key]['sort'] = true;
        }

        if(isset($cb)){
            $this->data['fields'][$key]['cb'] = $cb;
        }
    }

    public function removeField($key){
        unset($this->data['fields'][$key]);
    }

    public function addSubField($key, $title, $cb = null){
        $this->data['sub_fields'][$key] = array('title' => $title);
        if(isset($cb)){
            $this->data['sub_fields'][$key]['cb'] = $cb;
        }
    }

    public function setTitle($title){
        $this->data['title'] = $title;
    }

    public function setCardTitle($title){
        $this->data['card_title'] = $title;
    }

    public function setLimit($limit = 10){
        $this->data['limit'] = $limit;
    }
    public function setFilters($field, $title, $search, $filter, $active = '', $type = 'filters'){
        $this->data['filters'][$field] = array(
            'title' => $title,
            'search' => $search,
            'values' => $filter,
            'active' => $active,
            'type' => $type
        );
    }
    public function addSearch($field){
        $this->data['search'][] = $field;
    }

    public function sortable(){
        $this->data['sortable'] = true;
    }

    public function disableLimited(){
        $this->data['limited'] = false;
    }

    public function createdLink($link = ''){
        $this->data['created_link'] = $link;
    }

    public function created($create = true){
        $this->data['created'] = $create;
    }

    public function deleted($delete = false){
        $this->data['deleted'] = $delete;
    }

    public function edited($edit = true){
        $this->data['edited'] = $edit;
    }

    public function primarykey($primarykey = "id"){
        $this->data['primarykey'] = $primarykey;
    }

    public function div_column($column = "col-xl-9 col-lg-9 col-md-12 col-sm-12 cl-xs-12"){
        $this->data['div_column'] = $column;
    }

    public function category_filters($category_filters = false){
        $this->data['category_filters'] = $category_filters;
    }


    public function setModel($model){

        //$model = $model->withTrashed();
        if($this->data['search']){
            if(!empty(request()->get('q'))){
                $model = $model->where(\DB::raw('concat('.implode('," ",', $this->data['search']).')') , 'LIKE' , '%'.trim(request()->get('q')).'%');
            }
        }
        if(request()->has('limit')){
            $this->data['limit'] = (int) request()->get('limit');
        }

        if(request()->has('filters')){
            foreach (request('filters') as $filter_filed => $filter_value){
                if($filter_value != '')
                    $model = $model->where($filter_filed, trim($filter_value));
            }

        }

        if(request()->has('sort')){
            $model->getQuery()->orders = null;
            $model = $model->orderBy(request()->get('sort'),request()->get('order'));
        }
        $this->data['data'] = $model->paginate(request()->get('limit', $this->data['limit']))->appends(request()->all());
    }

    public function setData($data){
        $this->data['data'] = $data;
    }
    public function setTopHtml($data){
        $this->data['top_html'] = $data;
    }

    public function Render(){
        return view()->make('panel.component.datatable', $this->data);
    }
    public function RenderToHtml(){
        return view('panel.component.datatable-content-html', $this->data)->render();
    }
    public function RenderData() {
        return $this->data;
    }
}
