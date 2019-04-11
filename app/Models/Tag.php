<?php

namespace App\Models;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Sets the Tag belongs to many Task relationship
     */
    public function tasks()
    {
        return $this->belongsToMany('App\Models\Task');
    }
}
