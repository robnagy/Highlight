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
    protected $fillable = ['user_id', 'name'];

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
