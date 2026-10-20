<?php


namespace App\Library;


use App\Library\Elements\AutoComplete;
use App\Library\Elements\BaseElement;
use App\Library\Elements\Column;
use App\Library\Elements\Date;
use App\Library\Elements\Datetime;
use App\Library\Elements\Language;
use App\Library\Elements\Password;
use App\Library\Elements\Select;
use App\Library\Elements\Status;
use App\Library\Elements\TextArea;
use App\Library\Elements\Tree;
use App\Library\Elements\View;
use App\Library\Elements\ID;
use App\Library\Elements\Image;
use App\Library\Elements\Input;
use App\Library\Elements\InputImage;
use Illuminate\Support\Collection;

class Elements extends Collection
{
    public static function ID($name = 'id'){
        return new ID("id", $name, "ID");
    }
    public static function Language(){
        return new Language();
    }
    public static function Input($type, $name, $title = null){
        return new Input($type, $name, $title);
    }
    public static function Text($name, $title = null){
        return new Input("text", $name, $title);
    }
    public static function Password($name, $title = null){
        return new Password("password", $name, $title);
    }
    public static function Email($name, $title = null){
        return new Input("email", $name, $title);
    }
    public static function Image($name, $title = null){
        return new Image("image", $name, $title);
    }
    public static function InputImage($name, $title = null){
        return new InputImage("input-image", $name, $title);
    }
    public static function Date($name, $title = null){
        return new Date('date', $name, $title);
    }
    public static function Datetime($name, $title = null){
        return new Datetime('datetime-local', $name, $title);
    }
    public static function Select($name, $title = null){
        return new Select("select", $name, $title);
    }
    public static function AutoComplete($name, $title = null, $from = ""){
        return new AutoComplete($name, $title, $from);
    }
    public static function Status($name, $title = null){
        return new Status("select", $name, $title ? $title : trans('status'), [
            1 => trans('Open'),
            0 => trans('Close'),

        ]);
    }


    public static function Tree($name, $title = null){
        return new Tree($name, $title);
    }
    public static function TextArea($name, $title = null){
        return new TextArea($name, $title);
    }

    public static function View($name, $view_file, $title = null){
        return new View($name, $view_file, $title);
    }

    public static function Column($name, $title = null){
        return new Column($name, $title);
    }


    /**
     * @return Elements|BaseElement|BaseElement[]
     */

    public function getFilterSidebar(){

        return $this->filter(function ($item){
            return $item->isFilterOnSidebar();
        });
    }

    /**
     * @return Elements|BaseElement|BaseElement[]
     */
    public function getFilterHeader(){

        return $this->filter(function ($item){
            return $item->isFilterOnHeader();
        });
    }

    public function isFilter(){
        return $this->contains(function ($value) {
            return $value->isFilter();
        });
    }

    /**
     * @return bool
     */
    public function isFilterSidebar(){
        return $this->contains(function ($value) {
            return $value->isFilterOnSidebar();
        });
    }

    /**
     * @return bool
     */
    public function isFilterHeader(){
        return $this->contains(function ($value) {
            return $value->isFilterOnHeader();
        });
    }
}
