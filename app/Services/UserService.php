<?php

namespace App\Services;

use App\Interfaces\UserServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService extends EloquentService implements UserServiceInterface
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function loginGuestUser()
    {
        $guest = $this->where('name', 'Guest')->first();
        if ($guest) Auth::login($guest, true);
    }
}
