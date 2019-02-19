<?php

namespace App\Interfaces;

Use App\Http\Requests\TagRequest;
Use App\Tag;
use Illuminate\Database\Eloquent\Collection;
Use Illuminate\Database\Eloquent\Model;

interface TagServiceInterface extends EloquentServiceInterface
{
    /**
     * Creates a tag from a request
     *
     * @param TagRequest $request
     * @return Tag
     */
    public function createFromRequest(TagRequest $request) : Tag;

}
