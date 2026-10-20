<?php


namespace App\Library\Elements;



use Illuminate\Database\Eloquent\Model;

class Column extends BaseElement
{

    public function __construct($name, $title=null)
    {
        parent::__construct('column', $name, $title);
        $this->onlyList();
    }

}
