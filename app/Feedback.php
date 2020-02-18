<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
	protected $table = 'superadmin_feedback';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'score', 'feedback'
    ];
}