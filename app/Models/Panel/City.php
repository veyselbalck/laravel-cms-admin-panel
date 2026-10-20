<?php

namespace App\Models\Panel;

use App\Http\Traits\ModelUserTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory, ModelUserTraits;

    protected $table = "city";

    protected $fillable = [
        'country_id',
        'name',
        'code',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        //'address_format' => 'json',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
