<?php

namespace App\Models\Panel;

use App\Http\Traits\ModelUserTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory, ModelUserTraits;

    protected $table = "user_group";
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'permission',
        'status',
        'created_by',
        'updated_by',
    ];
    protected $casts = [
        'permission' => 'json',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function ScopeUseUser($query){
        if(\auth()->user()->is_admin)
            return $query;
        return $query->where('created_by', \auth()->id());
    }

    public function scopeStatus($query){
        return $query->where('status', 1);
    }

}
