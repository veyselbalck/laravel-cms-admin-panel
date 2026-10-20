<?php


namespace App\Http\Traits;



use Illuminate\Support\Facades\Route;

trait PanelRouteTraits
{
    /**
     *
     * @var string
     */
    private $route_name;

    /**
     * @var string
     */
    private $route_method;

    /**
     * @var string
     */
    protected $route_create = 'store';


    /**
     * @var string
     */
    protected $route_update = 'update';

    /**
     * @var int
     */
    protected $_lang_id;
    /**
     * @var string
     */
    protected $_lang_code ;

    /**
     * @var string
     */
    protected $_lang_name ;

    private function RouteInit(){
        if(Route::getCurrentRoute() != null) {
            $parse = explode('.', Route::getCurrentRoute()->getName());
            $this->route_name = current($parse);
            $this->route_method=Route::getCurrentRoute()->getActionMethod();
        }
    }

    /**
     * @return mixed|string
     */
    public function getRouteName(){
        return $this->route_name;
    }


    /**
     * @return string
     */
    public function getRouteMethodName(){
        return $this->route_method;
    }


    /**
     * @return mixed|string
     */
    public function getAction(){
        return isset($this->model) && isset($this->model->exists) && $this->model->exists ? $this->setRoute($this->route_update, array_merge(request()->query(), ['id' => $this->model->getKey()])) : $this->setRoute($this->route_create);
    }

    /**
     * @return string
     */
    public function getMethod(){

        return isset($this->model->exists) && $this->model->exists ? 'PUT' : 'POST';
    }

    /**
     * @param $method_name
     * @param array $query
     * @return mixed|string
     */
    public function setRoute($method_name, $query = [])
    {

        $except = ['show_type'];
        $request_query = [];
        foreach (request()->query() as $key => $item) {
            if(!in_array($key, $except)){
                $request_query[$key] = $item;
            }

        }
        return \route($this->route_name . '.' . $method_name, array_merge($request_query, $query));
    }

    /**
     * @return int
     */
    public function getLangId()
    {
        return $this->_lang_id;
    }

    /**
     * @return string
     */
    public function getLangCode()
    {
        return $this->_lang_code;
    }







}
