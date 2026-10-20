<?php


namespace App\Library\Elements;



class TextArea extends BaseElement
{

    private $_rows = 3;

    public function __construct($name, $title=null)
    {
        parent::__construct('text-area', $name, $title);
    }

    public function rows($rows){
        $this->_rows = $rows;
        return $this;
    }

    /**
     * @param $query
     * @param $value
     * @return Model
     */
    public function filter_query($query, $value){
        return $query->where($this->_name, 'LIKE', '%'.$value.'%');
    }


    public function getInput($options = [], $isLabel = true){

        $type       = $this->_type;
        $name       = isset($options['name']) ? $options['name'] : $this->_name;
        $id         = $this->getIdAttribute($name, $options);
        $value      = panel()->getInputValue($name);
        $autocomplete = $name;
        $rows       = $this->_rows;

        $merge      = compact('type', 'name', 'id', 'rows', 'autocomplete');
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

        return $this->toHtmlString($label . '<textarea '.$this->getAttributes($options).'>'.$value.'</textarea>' . $error_feedback);
    }

}
