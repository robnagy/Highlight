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

    /**
     * Returns tasks for $user_id, for $date
     * (format Y-n-j, default today).
     *
     * @param integer $user_id
     * @param string $date
     * @return array
     */
    public function tasksForUser(int $user_id, string $date = null) : array;

    /**
     * Returns date of previous task belonging to $user_id,
     * where that task is before given $date (Y-n-j)
     *
     * @param integer $user_id
     * @param string $date
     * @return string|null
     */
    public function getPreviousTaskDate(int $user_id, string $date = null) : ?string;

    /**
     * Returns date of next task belonging to $user_id,
     * where that task is after given $date (Y-n-j)
     *
     * @param integer $user_id
     * @param string $date
     * @return string|null
     */
    public function getFutureTaskDate(int $user_id, string $date = null) : ?string;

    /**
     * Returns all dates that have a task
     * assigned, for given $user_id.
     *
     * @param integer $user_id
     * @return string|null
     */
    public function getAllTaskDates(int $user_id) : ?array;

}
