<?php

namespace App\Models\Panel;

use App\Http\Traits\ModelUserTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory, ModelUserTraits;

    protected $table = "testimonials";

    protected $fillable = [
        'name',
        'title',
        'profile',
        'message',
        'datas',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'datas' => 'json',
    ];

    public function scopeActive($query, $status = 1)
    {
        return $query->where('status', $status);
    }
}
