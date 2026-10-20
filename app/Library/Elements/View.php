<?php


namespace App\Library\Elements;


use Illuminate\Support\Carbon;

class View extends BaseElement
{

    protected $_type = 'view';

    protected $view_file = "";


    public function __construct($name, $view_file, $title = "")
    {
        $this->_name        = $name;
        $this->view_file    = $view_file;
        $this->_title       = $title;
    }


    public function getInput($options=[], $isLabel=true)
    {
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

        return $this->toHtmlString($label . view($this->view_file, ['element' => $this])->render());
    }

}
