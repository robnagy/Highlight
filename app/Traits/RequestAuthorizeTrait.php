<?php

namespace App\Traits;

use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait RequestAuthorizeTrait
{
    /**
     * Determine if the user can call this specific route.
     *
     * @return bool
     */
    protected function authorizeUserId()
    {
        // is user guest, and is route user_id also for guest?
        if (Auth::guest() && $this->route('user_id') === "guest")
            return true;

        // is user logged in, and does their id match the route user_id?
        if (Auth::user() && Auth::user()->id === (int) $this->route('user_id'))
            return true;

        return false;
    }

    /**
     * Determine if the task referenced is accessible by the user
     *
     * @return void
     */
    protected function authorizeUserIdTaskId($userId, $taskId)
    {
        if (is_null($taskId)) return true;
        $ts = new TaskService(new Task());
        return $ts->verifyUserTask($userId, $taskId);
    }
}
