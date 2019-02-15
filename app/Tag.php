<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = ['user_id', 'text', 'style'];

    /**
     * Sets the Tag belongs to a User relationship
     *
     * @return void
     */
    public function user()
    {
        $this->belongsTo('App\User');
    }
}
