<?php
/**
 * Created by PhpStorm.
 * User: XENAN
 * Date: 25.10.2021
 * Time: 12:44
 */

namespace App\Http\Traits;


trait ElementFiltersTraits
{
    /**
     * @var bool
     */
    protected $_is_filter   = false;

    /**
     * @var bool
     */
    protected $_is_filter_query   = true;

    /**
     * @var bool
     */
    protected $_filter_on_sidebar = false;

    /**
     * @var bool
     */
    protected $_filter_on_header = false;

    /**
     * @param bool $is_query
     * @return $this
     */
    public function filterOnSidebar($is_query = true){
        $this->_filter_on_sidebar = true;
        $this->_filter_on_header = false;
        $this->_is_filter = true;
        $this->_is_filter_query = $is_query;
        return $this;
    }

    /**
     * @param bool $is_query
     * @return $this
     */
    public function filterOnHeader($is_query = true){
        $this->_filter_on_header = true;
        $this->_filter_on_sidebar = false;
        $this->_is_filter = true;
        $this->_is_filter_query = $is_query;
        return $this;
    }

    /**
     * @param $query
     * @param $value
     * @return Model
     */
    public function filter_query($query, $value){
        $name = $this->_name;
        $explode = explode('.', $name);
        if(count($explode) > 1){
            if($query->hasCast(current($explode), 'json')){
                $name = implode('->', $explode);
            }
        }
        return $query->where($name, $value);
    }

    /**
     * @return bool
     */
    public function isFilterQuery(){
        return $this->_is_filter_query;
    }

    /**
     * @return bool
     */
    public function isFilter(){
        return $this->_is_filter;
    }

    /**
     * @return bool
     */
    public function isFilterOnSidebar(){
        return $this->_filter_on_sidebar;
    }

    /**
     * @return bool
     */
    public function isFilterOnHeader(){
        return $this->_filter_on_header;
    }
}
