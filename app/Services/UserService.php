<?php

namespace App\Services;

use App\Interfaces\UserServiceInterface;
use App\User;
Use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserService extends EloquentService implements UserServiceInterface
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * Returns user_id of "Guest" account in the database
     *
     * @return int
     */
    public function guestUserId() : int {
        return $this->model->where('name', 'guest')->first()->id;
    }
}
