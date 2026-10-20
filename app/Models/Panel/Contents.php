<?php

namespace App\Models\Panel;

use App\Http\Traits\ModelUserTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contents extends Model
{
    use HasFactory, ModelUserTraits;

    protected $table = "contents";

    protected $fillable = [
        'parent_id',
        'subdomain',
        'title',
        'template',
        'content_type',
        'image',
        'cover',
        'modules',
        'content_datas',
        'sort_order',
        'status',
        'created_by',
        'updated_by',
    ];
    protected $appends = [
        'key',
        'title',
    ];

    protected $casts = [
        'modules' => 'json',
        'content_datas' => 'json',
    ];

    public function parent()
    {
        return $this->belongsTo(Contents::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Contents::class, 'parent_id')->with('children');
    }

    public function descriptions(){
        return $this->hasMany(ContentsDescription::class, 'contents_id');
    }

    public function description($language_id){
        return $this->descriptions()->where('language_id', $language_id)->first();
    }

    public function getDescriptionsAttribute()
    {
        return $this->getRelationValue('descriptions')->keyBy('language_id');
    }
}
