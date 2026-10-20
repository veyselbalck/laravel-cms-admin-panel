<?php


namespace App\Library\Elements;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Image extends BaseElement
{

    protected $_default = "img/placeholder.png";

    protected $_thumb_width = '100';

    public function __construct($type, $name, $title=null)
    {
        parent::__construct($type, $name, $title);

        $this->width(1);
        $this->center();
    }

    /**
     * @param $query
     * @param $value
     * @return Model
     */
    public function filter_query($query, $value){
        return $query->where($this->_name, $value);
    }

    public function default($image){
        $this->_default = $image;
        return $this;
    }

    public function thumbWidth($width){
        $this->_thumb_width = $width;
        return $this;
    }

    public function getInput($options = [], $isLabel = true){

        $name       = isset($options['name']) ? $options['name'] : $this->_name;
        $id         = $this->getIdAttribute($name, $options);
        $value      = panel()->getInputValue($name);
        $thumb      = $value;


        if($thumb == null)
            $thumb = $this->_default;

        $img = '<img src="'.asset($thumb).'" alt="" title="" data-placeholder="'.asset($this->_default).'" width="'.$this->_thumb_width.'" />';
        $input = '<input type="hidden" name="'.$name.'" value="'.$value.'" id="input-'.$id.'" />';

        $label = '';
        if($isLabel)
            $label = $this->getLabel(['name' => $name]) . '<br>';

        return $this->toHtmlString($label . '<a href="javascript:;" data-toggle="image" class="btn btn-light btn-float p-1">'.$img . $input.'</a>');
    }

    public function getTableTdValue(Model $model)
    {
        if ($this->_callback){
            return call_user_func($this->_callback, $model);
        }

        $value = $model->getAttribute($this->_name) ? asset($model->getAttribute($this->_name)) : asset($this->_default);
        return '<img width="50" src="'.$value.'" />';
    }

}
