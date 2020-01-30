<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
	protected $table = 'absence';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'start_date', 'end_date', 'forum_post', 'status',
    ];
}
