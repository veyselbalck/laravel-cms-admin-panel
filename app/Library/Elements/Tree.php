<?php


namespace App\Library\Elements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Tree extends BaseElement
{

    /**
     * @var array
     */
    protected $_json       = [];
    protected $_data       = [];
    public function __construct($name, $title=null)
    {
        parent::__construct('tree', $name, $title);
    }

    /**
     * @param array $data
     * @return $this
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function options($data = []){

        $this->_json = getTree($data);
        $this->_data = $data;
        return $this;
    }

    public function getInput($options = [], $isLabel = true){

        $type       = "hidden";
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

        $hidden_input = '<input '.$this->getAttributes($options).' />';
        $tree = '<div class="tree-json fancytree-radio" data-type="json" data-target="[name=\''.$name.'\']">';

        $tree .= '<div class="d-none">' . $this->_json->toJson() . '</div>';
        $tree .= '</div>';

        return $this->toHtmlString($label . $tree . $hidden_input . $error_feedback);
    }
    public function getInputFilter($options = [], $isLabel = true){

        $type       = "hidden";
        $name       = 'filters['.$this->_name.']';
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

        $hidden_input = '<input '.$this->getAttributes($options).' />';
        $tree = '<div class="tree-json-filter border rounded" data-type="json" data-target="[name=\''.$name.'\']">';

        $tree .= '<div class="d-none">' . $this->_json->toJson() . '</div>';
        $tree .= '</div>';

        return $this->toHtmlString($label . $tree . $hidden_input . $error_feedback);
    }

    public function getSelectOption($display, $value, $selected)
    {
        if ($display->children->count()) {
            return $this->optionGroup($display->children, $display->name, $value, $selected, 5);
        }

        return $this->option($display->name, $display->id, $selected);

    }

    protected function optionGroup($list, $label, $value, $selected, $level = 0)
    {
        $html = [];
        $space = str_repeat("-", $level);
        $space .= '> ';

        $html[] = $this->option($label, $value, $selected);

        foreach ($list as $display) {
            if ($display->children->count()) {
                $html[] = $this->optionGroup($display->children, $space.$display->name, $display->id, $selected, $level+5);
            } else {
                $html[] = $this->option($space.$display->name, $display->id, $selected);
            }
        }
        return implode('', $html);
    }

    public function getTableTdValue(Model $model){
        if ($this->_callback){
            return call_user_func($this->_callback, $model);
        }

        $value = $model->getAttribute($this->_name) ? $model->getAttribute($this->_name) : '-';


        $find_data = $this->_data->firstWhere('id', $value);

        if($find_data){
            return $find_data->title;
        }
        return $value;
    }

    protected function option($display, $value, $selected, array $attributes = [])
    {
        $selected = $this->getSelectedValue($value, $selected);

        $options = array_merge(['value' => $value, 'selected' => $selected], $attributes);

        $string = '<option' . $this->getAttributes($options) . '>';
        if ($display !== null) {
            $string .= e($display, false) . '</option>';
        }

        return $string;
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

    public function filter_query($query, $value)
    {
        return $query->whereIn($this->_name, explode(',', $value));
    }

}
