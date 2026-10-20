<?php

namespace App\Models\Panel;

use App\Http\Traits\ModelUserTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory, ModelUserTraits;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'code',
        'value',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'value' => 'json',
    ];

}
