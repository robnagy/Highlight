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

    /**
     * Returns the user_id for provided task_id.
     * Returns null if task_id not found.
     *
     * @param integer $task_id
     * @return integer
     */
    public function getTaskUserId(int $task_id) : ?int;
}
