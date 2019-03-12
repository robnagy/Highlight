<?php

namespace App\Policies;

use App\Models\User;
use App\Services\TaskService;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Services\SubtaskService;

class SubtaskPolicy
{
    use HandlesAuthorization;

    protected $taskService;
    protected $subtaskService;

    public function __construct(TaskService $taskService, SubtaskService $subtaskService)
    {
        $this->taskService = $taskService;
        $this->subtaskService = $subtaskService;
    }

    /**
     * Determine whether the user can view the subtask.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Subtask  $subtask
     * @return bool
     */
    public function view(User $user, int $user_id, int $task_id) : bool
    {
        return $user->id === $user_id && $user->id === $this->taskService->getTaskUserId($task_id);
    }

    /**
     * Determine whether the user can create subtasks.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user, int $user_id, int $task_id) : bool
    {
        return $user->id === $user_id && $user->id === $this->taskService->getTaskUserId($task_id);
    }

    /**
     * Determine whether the user can update the subtask.
     *
     * @param  \App\Models\User  $user
     * @param  int  $task_id
     * @param  int  $subtask_id
     * @return bool
     */
    public function update(User $user, int $task_id, int $subtask_id) : bool
    {
        $task_user_id = $this->taskService->getTaskUserId($task_id);
        $subtask_task_id = $this->subtaskService->getSubtaskTaskId($subtask_id);

        return $user->id === $task_user_id && $task_id === $subtask_task_id;
    }

    /**
     * Determine whether the user can delete the subtask.
     *
     * @param  \App\Models\User  $user
     * @param  int  $task_id
     * @param  int  $subtask_id
     * @return bool
     */
    public function delete(User $user, int $task_id, int $subtask_id) : bool
    {
        $task_user_id = $this->taskService->getTaskUserId($task_id);
        $subtask_task_id = $this->subtaskService->getSubtaskTaskId($subtask_id);

        return $user->id === $task_user_id && $task_id === $subtask_task_id;
    }

}
