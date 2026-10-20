<?php

namespace App\Models\Panel;

use App\Http\Traits\ModelUserTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory, ModelUserTraits;

    protected $table = "contacts";

    protected $fillable = [
        'name',
        'sort_order',
        'settings',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'settings' => 'json',
    ];

    public function scopeActive($query, $status = 1)
    {
        return $query->where('status', $status);
    }
}
