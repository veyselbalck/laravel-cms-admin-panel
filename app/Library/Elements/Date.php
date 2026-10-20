<?php


namespace App\Library\Elements;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Date extends Input
{

    protected $_format = "d/m/Y";

    public function __construct($type, $name, $title=null)
    {
        parent::__construct($type, $name, $title);
        $this->width(1);
        $this->center();
        $this->_attributes_td['class'][] = 'text-nowrap';
    }

    /**
     * @param $query
     * @param $value
     * @return Model
     */
    public function filter_query($query, $value){
        return $query->where($this->_name, 'LIKE', Carbon::parse($value)->format('Y-m-d').'%');
    }

    /**
     * @param $format
     * @return $this
     */
    public function format($format){
        $this->_format = $format;
        return $this;
    }

    /**
     * @param Model $model
     * @return \Illuminate\Support\HtmlString|mixed
     */
    public function getTableTdValue(Model $model)
    {
        $value = $model->getAttribute($this->_name) ? '<i class="icon-calendar2 mr-2"></i>' . $model->getAttribute($this->_name)->format($this->_format) : '-';
        return $this->toHtmlString($value);
    }

}
