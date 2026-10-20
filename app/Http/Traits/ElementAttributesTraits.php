<?php
/**
 * Created by PhpStorm.
 * User: XENAN
 * Date: 25.10.2021
 * Time: 12:35
 */

namespace App\Http\Traits;


trait ElementAttributesTraits
{
    /**
     * @var array
     */
    protected $_attributes      = [];

    /**
     * @var array
     */
    protected $_attributes_th   = [];

    /**
     * @var array
     */
    protected $_attributes_td   = [];


    /**
     * @return $this
     */
    public function center(){
        $this->_attributes_th['class'][] = 'text-center';
        $this->_attributes_td['class'][] = 'text-center';
        return $this;
    }

    /**
     * @param $width
     * @return $this
     */
    public function width($width){
        $this->_attributes_th['width'] = $width;
        return $this;
    }

    public function required(){
        $this->_attributes['required'] = true;
        return $this;
    }


    public function disabled(){
        $this->_attributes['disabled'] = true;
        return $this;
    }


    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function attribute($key, $value){
        $this->_attributes[$key] = $value;
        return $this;
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function attributes($attributes = []){
        $this->_attributes = $attributes;
        return $this;
    }

    /**
     * @param $attributes
     * @return string
     */
    public function getAttributes($attributes){
        $html = [];

        foreach ((array) $attributes as $key => $value) {
            $element = $this->attributeElement($key, $value);

            if (! is_null($element)) {
                $html[] = $element;
            }
        }

        return count($html) > 0 ? ' ' . implode(' ', $html) : '';
    }

    /**
     * @return string
     */
    public function getThAttributes(){
        return $this->toHtmlString($this->getAttributes($this->_attributes_th));
    }

    /**
     * @return string
     */
    public function getTdAttributes(){
        return $this->toHtmlString($this->getAttributes($this->_attributes_td));
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getInputValue($name){

        $old = $this->old($name);

        if (!empty($old) && $name !== '_method') {
            return $old;
        }


        $request = request()->input($this->transformKey($name));


        if (! is_null($request) && $name != '_method') {
            return $request;
        }



        return $this->getModelValueAttribute($name);
    }

    /**
     * @param $key
     * @param $value
     * @return string
     */
    protected function attributeElement($key, $value)
    {
        if (is_numeric($key)) {
            return $value;
        }

        // Treat boolean attributes as HTML properties
        if (is_bool($value) && $key !== 'value') {
            return $value ? $key : '';
        }

        if (is_array($value) && $key === 'class') {
            return 'class="' . implode(' ', $value) . '"';
        }

        if (! is_null($value)) {
            return $key . '="' . e($value, false) . '"';
        }
    }

    /**
     * @param $name
     * @return mixed
     */
    public function old($name)
    {
        if(session()->hasOldInput($this->transformKey($name))){
            $payload = session()->getOldInput($this->transformKey($name));


            if (!is_array($payload)) {
                return $payload;
            }

            if(is_null($payload))
                return "";
        }

        return false;
    }

    /**
     * @param $name
     * @return mixed
     */
    protected function getModelValueAttribute($name)
    {


        if (isset(panel()->getModel()->exists) && panel()->getModel()->exists) {
            $key = $this->transformKey($name);


            /*
            if ((is_string(panel()->getModel()) || is_object(panel()->getModel())) && method_exists($this, 'getFormValue')) {
                return $this->getFormValue($key);
            }
            */

            return data_get(panel()->getModel(), $key);
        }

    }

    /**
     * @param $name
     * @param $options
     * @return mixed
     */
    protected function getIdAttribute($name, $options){
        if (array_key_exists('id', $options)) {
            return $options['id'];
        }
        return $this->transformKey($name);
    }
}
