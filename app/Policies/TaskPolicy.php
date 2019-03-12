<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;
use App\Services\TaskService;

class TaskPolicy
{
    use HandlesAuthorization;

    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Determine whether the user can view the task.
     *
     * @param  \App\Models\User  $user
     * @param  int $task_id
     * @return bool
     */
    public function view(User $user, int $task_id)
    {
        return $user->id === $this->taskService->getTaskUserId($task_id);
    }

    /**
     * Determine whether the user can create tasks.
     *
     * @param  \App\Models\User  $user
     * @param  int  $user_id
     * @return bool
     */
    public function create(User $user, int $user_id)
    {
        return $user->id === $user_id;
    }

    /**
     * Determine whether the user can update the task.
     *
     * @param  \App\Models\User  $user
     * @param  int  $user_id
     * @param  int  $task_id
     * @return bool
     */
    public function update(User $user, int $user_id, int $task_id)
    {
        return $user->id === $user_id && $user->id === $this->taskService->getTaskUserId($task_id);
    }

    /**
     * Determine whether the user can delete the task.
     *
     * @param  \App\Models\User  $user
     * @param  int  $user_id
     * @param  int  $task_id
     * @return bool
     */
    public function delete(User $user, int $user_id, int $task_id)
    {
        return $user->id === $user_id && $user->id === $this->taskService->getTaskUserId($task_id);
    }

}
