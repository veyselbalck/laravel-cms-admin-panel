<?php


namespace App\Library\Elements;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class InputImage extends Image
{

    public function getInput($options = [], $isLabel = true){

        $name       = isset($options['name']) ? $options['name'] : $this->_name;
        $id         = $this->getIdAttribute($name, $options);
        $value      = panel()->getInputValue($name);
        $thumb      = $value;

        if($thumb == null)
            $thumb = $this->_default;

        $img = '<span class="input-group-prepend" style="height: 38px"><img src="'.asset($thumb).'" data-placeholder="'.asset($this->_default).'" class="h-100 rounded-left" /></span>';
        $input = '<input type="text" name="'.$name.'" value="'.$value.'" id="input-'.$id.'" class="form-control" readonly placeholder="'.trans('Select File').'" value="">';

        $label = '';
        if($isLabel)
            $label = $this->getLabel(['name' => $name]);

        $buttons = [];
        if(empty($value)){
            $buttons[] = '<button class="btn btn-danger button-image-clear d-none" type="button"><i class="icon-trash mr-2"></i> '.trans('Destroy').'</button>';
        }else{
            $buttons[] = '<button class="btn btn-danger button-image-clear" type="button"><i class="icon-trash mr-2"></i> '.trans('Destroy').'</button>';
        }

        $buttons[] = '<button class="btn btn-light" data-toggle="image" type="button"><i class="icon-image2 mr-2"></i> '.trans('Select File').'</button>';

        return $this->toHtmlString($label . '<div class="input-group">'. $img . $input.'<span class="input-group-append">'.implode(' ', $buttons).'</span></div>');
    }


}
