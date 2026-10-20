<?php


namespace App\Library\Elements;


use Illuminate\Database\Eloquent\Model;

class Status extends Select
{

    public function __construct($type, $name, $title=null, array $options=[])
    {
        parent::__construct($type, $name, $title, $options);
        $this->width(1);
        $this->center();
        $this->selected(1);
    }

    public function getTableTdValue(Model $model){

        if ($this->_callback){
            return call_user_func($this->_callback, $model);
        }
        $value = $model->getAttribute($this->_name) ? $model->getAttribute($this->_name) : 0;

        $html = "";

        switch ($value){
            case -1:
                $html = '<span class="badge badge-danger">'.trans('Denied').'</span>';
                break;
            case 0:
                $html = '<span class="badge badge-warning">'.trans('Close').'</span>';
                break;
            case 1:
                $html = '<span class="badge badge-success">'.trans('Open').'</span>';
                break;
            case 2:
                $html = '<span class="badge badge-primary">'.trans('Waiting').'</span>';
                break;
        }

        return $this->toHtmlString($html);
    }


}
