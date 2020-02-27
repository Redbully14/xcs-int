<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
	use SoftDeletes;
	
	protected $table = 'activity';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patrol_start_date', 'patrol_end_date', 'start_time', 'end_time', 'total_time', 'details', 'priorities','patrol_area', 'flag', 'type', 'user_id'
    ];
}
