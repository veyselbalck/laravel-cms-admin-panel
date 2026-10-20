<?php


namespace App\Library\Elements;


use Illuminate\Support\Carbon;

class Password extends BaseElement
{


    protected $_onShowList = false;

    public function __construct($type, $name, $title=null)
    {
        parent::__construct($type, $name, $title);

        $this->attribute('autocomplete', "new-password");
    }

    /**
     * @param $query
     * @param $value
     * @return Model
     */
    public function filter_query($query, $value){
        return $query->where($this->_name, 'LIKE', '%'.$value.'%');
    }

    protected function getModelValueAttribute($name){
        return '';
    }


}
