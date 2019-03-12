<?php

namespace App\Interfaces;



interface UserServiceInterface extends EloquentServiceInterface
{
    /**
     * Sets the seeded Guest account as the currently logged in user.
     *
     * @return void
     */
    public function loginGuestUser();
}
