<?php
/**
 * Created by PhpStorm.
 * User: XENAN
 * Date: 21.10.2021
 * Time: 14:42
 */

namespace App\Http\Traits;


use Illuminate\Support\Facades\Route;

trait PanelBreadcrumbsTraits
{
    /**
     * @return bool
     */
    public function isBreadcrumbsHome(){
        return true;
    }

    /**
     * @return array
     */
    public function Breadcrumbs(){

        $breadcrumbs = [];


        if($this->getTitle()){
            if(Route::has($this->route_name . '.index')){
                $breadcrumbs[$this->getTitle()] = \route($this->route_name . '.index');
            }
        }

        if($this->route_method == 'show'){
            $breadcrumbs[trans('Show')] = "";
        }

        if($this->route_method == 'create'){
            $breadcrumbs[trans('Create')] = "";
        }

        if($this->route_method == 'edit'){
            $breadcrumbs[trans('Edit')] = "";
        }


        return $breadcrumbs;
    }

    /**
     * @return bool
     */
    public function isBreadcrumbs(){
        return (bool) count($this->Breadcrumbs());
    }
}
