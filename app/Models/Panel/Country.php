<?php

namespace App\Models\Panel;

use App\Http\Traits\ModelUserTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory, ModelUserTraits;

    protected $table = "country";

    protected $fillable = [
        'name',
        'iso_code_2',
        'iso_code_3',
        'address_format',
        'postcode_required',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        //'address_format' => 'json',
    ];
}
