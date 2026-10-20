<?php

namespace App\Models\Panel;

use App\Http\Traits\ModelUserTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentsDescription extends Model
{
    use HasFactory, ModelUserTraits;


    protected $table = "contents_description";

    protected $primaryKey = 'contents_id';

    protected $fillable = [
        'contents_id',
        'language_id',
        'slug',
        'description',
        'name',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'created_by',
        'datas',
    ];

    protected $casts = [
        'datas' => 'json',
    ];

    public function content()
    {
        return $this->hasOne(Contents::class, 'id', 'contents_id');
    }
}
