<?php
/**
 * Created by PhpStorm.
 * User: XENAN
 * Date: 25.10.2021
 * Time: 12:39
 */

namespace App\Http\Traits;


use Illuminate\Database\Eloquent\Model;

trait ElementRenderingTraits
{
    /**
     * @param Model $model
     * @return mixed|string
     */
    public function getTableTdValue(Model $model){

        if ($this->_callback){
            return call_user_func($this->_callback, $model);
        }

        $value = $model->getAttribute($this->_name) ? $model->getAttribute($this->_name) : '-';
        return $value;
    }

    /**
     * @param array $options
     * @return HtmlString
     */
    public function getLabel($options = []){
        $name       = isset($options['name']) ? $options['name'] : $this->_name;

        $options['for'] = $this->getIdAttribute($name, $options);

        $title = $this->_title;
        if(isset($this->_attributes['required'])){
            $title .= " *";
            $options['class'][] = "text-danger";
        }


        $info = "";
        if($this->_info){
            $options['data-popup'] = 'tooltip';
            $options['data-html'] = 'true';
            $options['data-placement'] = 'right';
            $options['title'] = $this->_info;
            $info = '<i class="icon-info22 ml-2 text-primary"></i>';
        }

        unset($options['id']);
        unset($options['name']);


        return $this->toHtmlString('<label '.$this->getAttributes($options).'>'.$title. $info .'</label>');
    }


    /**
     * @param array $options
     * @param bool $isLabel
     * @return HtmlString
     */
    public function getInput($options = [], $isLabel = true){

        $type       = $this->_type;
        $name       = isset($options['name']) ? $options['name'] : $this->_name;
        $id         = $this->getIdAttribute($name, $options);
        $value      = panel()->getInputValue($name);
        $autocomplete = $name;
        $merge      = compact('type', 'name', 'id', 'value', 'autocomplete');
        $options    = array_merge($options, $merge);

        foreach ($this->_attributes as $attribute_key => $attribute) {
            $options[$attribute_key] = $attribute;
        }

        $options['class'][] = 'form-control';


        $error_feedback = $this->getInputError($name);
        if($error_feedback){
            $options['class'][] = 'is-invalid';
        }

        $label = '';
        if($isLabel)
            $label = $this->getLabel(['name' => $name]);

        return $this->toHtmlString($label . '<input '.$this->getAttributes($options).' />' . $error_feedback);
    }

    /**
     * @param array $options
     * @param bool $isLabel
     * @return HtmlString
     */
    public function getInputFilter($options = [], $isLabel = true){

        $type       = $this->_type;
        $name               = 'filters['.$this->_name.']';
        $id         = $this->getIdAttribute($name, $options);
        $value      = request()->input($this->transformKey($name));
        $autocomplete = $name;
        $merge      = compact('type', 'name', 'id', 'value', 'autocomplete');
        $options    = array_merge($options, $merge);

        foreach ($this->_attributes as $attribute_key => $attribute) {
            $options[$attribute_key] = $attribute;
        }

        $options['class'][] = 'form-control';


        $error_feedback = $this->getInputError($name);
        if($error_feedback){
            $options['class'][] = 'is-invalid';
        }

        $label = '';
        if($isLabel)
            $label = $this->getLabel(['name' => $name]);

        return $this->toHtmlString($label . '<input '.$this->getAttributes($options).' />' . $error_feedback);
    }



    protected function hasInputError($name){
        return session()->has('errors') && session()->get('errors')->hasBag() && session()->get('errors')->getBag('default')->has($name);
    }
    public function getInputError($name){
        $error = "";

        if ($this->hasInputError($name)){
            foreach (session()->get('errors')->getBag('default')->get($name) as $item) {
                $error .= '<span class="invalid-feedback">'.$item.'</span>';
            }
        }
        return $error;
    }
}
