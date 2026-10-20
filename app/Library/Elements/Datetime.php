<?php


namespace App\Library\Elements;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Datetime extends Date
{

    protected $_format = "d/m/Y H:i";


    /**
     * @param $query
     * @param $value
     * @return Model
     */
    public function filter_query($query, $value){
        return $query->where($this->_name, 'LIKE', Carbon::parse($value)->format('Y-m-d H:i').'%');
    }


}
