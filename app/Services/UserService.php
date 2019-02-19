<?php

namespace App\Services;

use App\Interfaces\UserServiceInterface;
use App\User;
Use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class UserService extends EloquentService implements UserServiceInterface
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * Returns user_id based on "user_id" URL segment.
     * This can contain the "guest" user identifier
     * which gets translated to an actual userid.
     *
     * @return int user_id
     */
    public static function getUserIdFromRoute() {
        $user_id = Request::route('user_id');
        return self::checkUserId($user_id);
    }

    /**
     * Checks if $user_id is shortcut for the guest
     * user. Returns actual guest user id if yes,
     * otherwise returns passed in $user_id.
     *
     * @param mixed $user_id
     * @return int $user_id
     */
    public static function checkUserId($user_id) {
        return self::isUserGuest($user_id) ? self::guestUserId() : $user_id;
    }

    /**
     * Checks if $user_id is identifier
     * for the guest user: "guest".
     *
     * @param [type] $user_id
     * @return boolean
     */
    public static function isUserGuest($user_id) {
        return $user_id === "guest";
    }

    /**
     * Returns user_id of "Guest" account in the database
     *
     * @return int
     */
    public static function guestUserId() : int {
        $user = User::where('name', 'guest')->first();
        return $user ? $user->id : null;
    }
}
