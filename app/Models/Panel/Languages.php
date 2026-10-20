<?php

namespace App\Models\Panel;

use App\Http\Traits\ModelUserTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Languages extends Model
{
    use HasFactory, ModelUserTraits;

    protected $fillable = [
        'name',
        'code',
        'sort_order',
        'status',
        'created_by',
        'updated_by',
    ];

    public function scopeActive($query, $status = 1)
    {
        return $query->where('status', $status);
    }

    public static function getLanguageId($code){
        return Languages::where('code', $code)->first()->id;
    }
}
