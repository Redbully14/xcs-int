<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
	protected $table = 'activity';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patrol_start_date', 'patrol_end_date', 'start_time', 'end_time', 'details', 'patrol_area', 'type', 'user_id'
    ];
}
