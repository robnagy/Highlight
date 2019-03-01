<?php

namespace App\Interfaces;


interface TaskServiceInterface extends EloquentServiceInterface
{
    /**
     * Checks if given task exists for the given user.
     *
     * @param int $user_id
     * @param int $task_id
     * @return boolean
     */
    public function verifyUserTask(int $user_id, int $task_id) : bool;

    /**
     * Deletes Task with given task_id. Also
     * deletes subtasks linked the task.
     *
     * @param integer $task_id
     * @return boolean
     */
    public function deleteTask(int $task_id) : bool;
}
