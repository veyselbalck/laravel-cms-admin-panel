<?php


namespace App\Http\Traits;




use Illuminate\Support\Str;

trait PanelInputTraits
{
    /**
     * @param $key
     * @param array $options
     * @param bool $isLabel
     * @return BaseElement|mixed|string
     */
    public function getElementInput($key, $options = [], $isLabel = true){
        return isset($this->_elements[$key]) ? $this->_elements[$key]->getInput($options, $isLabel) : '';
    }

    public function hasElement($key){
        return isset($this->_elements[$key]);
    }

    /**
     * @param null $key
     * @param null $default
     * @return mixed
     */
    public function getInputValue($key = null, $default = null){

        $old = $this->old($key);

        if (!empty($old) && $key !== '_method') {
            return $old;
        }

        $request = request()->input($this->transformKey($key));


        if (! is_null($request) && $key != '_method') {
            return $request;
        }
        return $this->getModelValueAttribute($key, $default);
    }



    /**
     * @param $key
     * @return mixed
     */
    public function old($key)
    {
        if(session()->hasOldInput($this->transformKey($key))){
            $payload = session()->getOldInput($this->transformKey($key));


            if (!is_array($payload)) {
                return $payload;
            }

            if(is_null($payload))
                return "";
        }

        if(session()->hasOldInput($key)){
            $payload = session()->getOldInput($key);


            if (!is_array($payload)) {
                return $payload;
            }

            if(is_null($payload))
                return "";
        }

        return false;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    protected function getModelValueAttribute($key, $default = null )
    {

        if (isset($this->model->exists) && $this->model->exists) {
            if ((is_string(panel()->getModel()) || is_object(panel()->getModel())) && method_exists(panel()->getModel(), 'getFormValue')) {
                return panel()->getModel()->getFormValue($key);
            }
            $value = data_get($this->model, $this->transformKey($key));
            if(!is_null($value))
                return $value;

            $value = data_get($this->model, $key);

            if(!is_null($value))
                return $value;
        }

        return $default;
    }



    /**
     * @param $key
     * @return mixed
     */
    protected function transformKey($key)
    {
        return str_replace(['.', '[]', '[', ']'], ['_', '', '.', ''], $key);
    }


}
