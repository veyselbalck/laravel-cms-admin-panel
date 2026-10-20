<?php

namespace App\Models\Panel;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject', 'url', 'method', 'ip', 'user_id'
    ];


}
