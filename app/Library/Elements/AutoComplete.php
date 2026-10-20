<?php


namespace App\Library\Elements;



class AutoComplete extends BaseElement
{

    /**
     * @var string
     */
    protected $_from       = "";



    public function __construct($name, $title = null, $from = "")
    {
        $this->_type = 'text';
        $this->_name = $name;
        $this->_title = $title;
        $this->_from = $from;
    }

    public function getInput($options = [], $isLabel = true){

        $type       = $this->_type;
        $name       = isset($options['name']) ? $options['name'] : $this->_name;
        $id         = $this->getIdAttribute($name, $options);
        $value      = panel()->getInputValue($name);
        $merge      = compact('type', 'name', 'id', 'value');
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

        $input = '<input '.$this->getAttributes($options).' />';
        $input_autocomplete = '<input type="text" value="'.$value.'" class="form-control" auto-complete="'.$this->_from.'" />';

        return $this->toHtmlString($label . '<div class="position-relative">'.$input_autocomplete . $input.'</div>' . $error_feedback);
    }


}
