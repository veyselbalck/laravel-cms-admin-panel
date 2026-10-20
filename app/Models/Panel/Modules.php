<?php

namespace App\Models\Panel;

use App\Http\Traits\ModelUserTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    use HasFactory, ModelUserTraits;
    protected $fillable = [
        'name',
        'code',
        'template',
        'settings',
        'status',
        'created_by',
        'updated_by',
    ];
    protected $casts = [
        'settings' => 'json',
    ];

    public static function getModule($code, $id){
        return \App\Models\Modules::where('code', $code)->where('id', $id)->first();
    }
}
