<?php

namespace App\Interfaces;

Use App\Tag;
use Illuminate\Database\Eloquent\Collection;
Use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface TagServiceInterface extends EloquentServiceInterface
{
    /**
     * Creates a tag from a request
     *
     * @param Request $request
     * @return Tag
     */
    public function createFromRequest(Request $request) : Tag;
}
