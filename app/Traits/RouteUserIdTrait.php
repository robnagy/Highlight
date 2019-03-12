<?php

namespace App\Traits;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Request;

trait RouteUserIdTrait
{
    /**
     * Returns a user id. If given a valid user, returns it's ID.
     * Otherwise checks the route for a user id.
     *
     * @param User|null $user
     * @return void
     */
    protected function getUserId(?User $user)
    {
        return $user ? $user->id : $this->translateRouteUserId();
    }

    /**
     * Returns user_id based on "user_id" URL segment. This can be
     * the "guest" user identifier which gets translated to
     * the actual id of the seeded "guest" account
     *
     * @return int user_id
     */
    protected function translateRouteUserId()
    {
        $user_id = Request::route('user_id');
        return $this->checkUserId($user_id);
    }

    /**
     * Checks if $user_id is shortcut for the guest
     * user. Returns actual guest user id if yes,
     * otherwise returns passed in $user_id.
     *
     * @param mixed $user_id
     * @return int $user_id
     */
    protected function checkUserId($user_id)
    {
        return $this->isUserGuest($user_id) ? $this->guestUserId() : $user_id;
    }

    /**
     * Checks if $user_id is identifier
     * for the guest user: "guest".
     *
     * @param [type] $user_id
     * @return boolean
     */
    protected function isUserGuest($user_id)
    {
        return $user_id === "guest";
    }

    /**
     * Returns user_id of "Guest" account in the database
     *
     * @return int
     */
    protected function guestUserId() : int
    {
        $user = User::where('name', 'guest')->first();
        return $user ? $user->id : null;
    }

}
