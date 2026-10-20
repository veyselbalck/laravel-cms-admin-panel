<?php

namespace App\Models\Panel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoRedirect extends Model
{
    use HasFactory;
    protected $table = 'seo_redirect';
    protected $primaryKey = "id";
    protected $fillable = [
        "title", "address", 'redirect', 'http_status', "created_by", "updated_by"
    ];
    protected $dates = ['updated_at', 'deleted_at'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function last_modifier()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
