<?php


namespace App\Http\Traits;


use App\Models\Panel\User;

trait ModelUserTraits
{
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function last_modifier()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
