<?php


namespace App\Library\Elements;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ViewErrorBag;

class Select extends BaseElement
{

    /**
     * @var array
     */
    protected $_options       = [];

    protected $_selected      = null;

    public function __construct($type, $name, $title=null, $options = [])
    {
        parent::__construct($type, $name, $title);
        $this->_options = $options;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function options($options = []){
        $this->_options = $options;
        return $this;
    }

    public function selected($value){
        $this->_selected = $value;
        return $this;
    }


    public function getInput($options = [], $isLabel = true){

        $name               = isset($options['name']) ? $options['name'] : $this->_name;

        $id                 = $this->getIdAttribute($name, $options);

        $selected_value     = panel()->getInputValue($name, $this->_selected);


        $autocomplete       = $name;
        $merge              = compact('name', 'id', 'autocomplete');
        $options            = array_merge($options, $merge);

        $html = [];

        $html[] = '<option value="0">'.trans('Selected').'</option>';
        foreach ($this->_options as $value => $display) {
            $selected = $this->getSelectedValue($value, $selected_value);

            $html[] = '<option value="'.$value.'" '.$selected.'>'.$display.'</option>';
        }

        $options['class'][] = 'form-control';
        if(count($this->_options) > 10){
            $options['class'][] = 'select2-search';
        }else{
            $options['class'][] = 'select2';
        }

        $options            = array_merge($options, $this->_attributes);

        $list = implode(' ', $html);

        $error_feedback = $this->getInputError($name);
        if($error_feedback){
            $options['class'][] = 'is-invalid';
        }

        $label = '';
        if($isLabel)
            $label = $this->getLabel(['name' => $name]);

        return $this->toHtmlString($label . "<select{$this->getAttributes($options)}>{$list}</select>" . $error_feedback);
    }
    public function getInputFilter($options = [], $isLabel = true){

        $name               = 'filters['.$this->transformKey($this->_name).']';
        $id                 = $this->getIdAttribute($name, $options);

        $selected_value     = request()->input($this->transformKey($name));

        $autocomplete       = $name;
        $merge              = compact('name', 'id', 'autocomplete');
        $options            = array_merge($options, $merge);

        $html = [];

        $html[] = '<option value="">'.trans('Selected').'</option>';
        foreach ($this->_options as $value => $display) {
            $selected = $this->getSelectedValue($value, $selected_value);
            $html[] = '<option value="'.$value.'" '.$selected.'>'.$display.'</option>';
        }

        $options['class'][] = 'form-control';
        if(count($this->_options) > 10){
            $options['class'][] = 'select2-search';
        }else{
            $options['class'][] = 'select2';
        }

        $options            = array_merge($options, $this->_attributes);

        $list = implode(' ', $html);

        $error_feedback = $this->getInputError($name);
        if($error_feedback){
            $options['class'][] = 'is-invalid';
        }

        $label = '';
        if($isLabel)
            $label = $this->getLabel(['name' => $name]);

        return $this->toHtmlString($label . "<select{$this->getAttributes($options)}>{$list}</select>" . $error_feedback);
    }
    public function getTableTdValue(Model $model){
        if ($this->_callback){
            return call_user_func($this->_callback, $model, $this->_options);
        }

        $value = $model->getAttribute($this->_name) ? $model->getAttribute($this->_name) : '-';

        if(isset($this->_options[$value])){
            return $this->_options[$value];
        }
        return $value;
    }

    protected function getSelectedValue($value, $selected)
    {

        if (is_array($selected)) {
            return in_array($value, $selected, true) || in_array((string) $value, $selected, true) ? 'selected' : null;
        } elseif ($selected instanceof Collection) {
            return $selected->contains($value) ? 'selected' : null;
        }


        if (is_int($value) && is_bool($selected)) {
            return (bool)$value === $selected;
        }

        return ((string) $value === (string) $selected) ? 'selected' : null;
    }

}
