<?php


namespace App\Library\Elements;


use Illuminate\Support\Carbon;

class Input extends BaseElement
{

    /**
     * @param $query
     * @param $value
     * @return Model
     */
    public function filter_query($query, $value){
        return $query->where($this->_name, 'LIKE', '%'.$value.'%');
    }



}
