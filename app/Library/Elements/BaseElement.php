<?php


namespace App\Library\Elements;


use App\Http\Traits\ElementAttributesTraits;
use App\Http\Traits\ElementFilters;
use App\Http\Traits\ElementFiltersTraits;
use App\Http\Traits\ElementRenderingTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class BaseElement
{

    use ElementAttributesTraits, ElementRenderingTraits, ElementFiltersTraits;

    /**
     * @var string
     */
    protected $_type            = "text";

    /**
     * @var string
     */
    protected $_name            = null;

    /**
     * @var string
     */
    protected $_title           = null;

    /**
     * @var bool
     */
    protected $_sorted          = false;

    /**
     * @var \Closure|bool
     */
    protected $_onShowList      = true;

    /**
     * @var \Closure|bool
     */
    protected $_onShowForm      = true;

    /**
     * @var string
     */
    protected $_info             = "";

    /**
     * @var \Closure|null
     */
    protected $_callback        = null;

    /**
     * BaseElement constructor.
     * @param $type
     * @param $name
     * @param null $title
     */
    public function __construct($type, $name, $title = null)
    {
        $this->_type = $type;
        $this->_name = $name;
        $this->_title = $title;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * @return $this
     */
    public function sorted(){
        $this->_sorted = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function onlyList(){
        $this->_onShowList = true;
        $this->_onShowForm = false;

        return $this;
    }

    /**
     * @return $this
     */
    public function onlyForm(){
        $this->_onShowList = false;
        $this->_onShowForm = true;
        return $this;
    }

    /**
     * @param $info
     * @return $this
     */
    public function info($info){
        $this->_info = $info;
        return $this;
    }

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function callback($callback){
        $this->_callback = $callback;
        return $this;
    }


    /**
     * @return bool
     */
    public function isSorted(){
        return $this->_sorted;
    }

    /**
     * @return bool|\Closure
     */
    public function isOnlyList(){
        return $this->_onShowList;
    }

    /**
     * @return bool|\Closure
     */
    public function isOnlyForm(){
        return $this->_onShowForm;
    }



    /**
     * @param $key
     * @return mixed
     */
    protected function transformKey($key)
    {
        return str_replace(['.', '[]', '[', ']'], ['_', '', '.', ''], $key);
    }

    /**
     * @param $html
     * @return HtmlString
     */
    protected function toHtmlString($html)
    {
        return new HtmlString($html);
    }
}
