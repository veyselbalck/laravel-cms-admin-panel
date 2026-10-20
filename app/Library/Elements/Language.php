<?php


namespace App\Library\Elements;


use App\Models\Panel\Languages;

class Language extends Select
{

    public function __construct()
    {
        parent::__construct('select', 'language_id', trans('Language'), Languages::all()->pluck('name', 'id'));
        $this->width(1);
        $this->sorted();

    }

}
