<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
Use Illuminate\Database\Eloquent\Model;
Use App\Tag;

interface TagServiceInterface extends EloquentServiceInterface
{
    /**
     * Create a tag from the model attributes. Adds currently logged in user id to array.
     *
     * @param array $modelAttributes
     * @return Tag
     */
    public function create(array $modelAttributes) : Model;
}
