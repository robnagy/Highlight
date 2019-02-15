<?php

namespace App\Interfaces;

Use App\Tag;
use Illuminate\Database\Eloquent\Collection;
Use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface UserServiceInterface extends EloquentServiceInterface
{
    /**
     * Returns id of user with name "guest"
     *
     * @param Request $request
     * @return int
     */
    public function guestUserId() : int;
}
