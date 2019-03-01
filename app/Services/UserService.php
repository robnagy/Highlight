<?php

namespace App\Services;

use App\Interfaces\UserServiceInterface;
use App\Models\User;
Use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class UserService extends EloquentService implements UserServiceInterface
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }


}
