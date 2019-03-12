<?php

namespace App\Interfaces;


interface SubtaskServiceInterface extends EloquentServiceInterface
{
    /**
     * Deletes a Subtask
     *
     * @param integer $subtask_id
     * @return bool
     */
    public function deleteSubtask(int $subtask_id) : bool;

    /**
     * Returns the task_id for the given subtask_id.
     * Returns null if subtask_id does not exist.
     *
     * @param integer $subtask_id
     * @return integer|null
     */
    public function getSubtaskTaskId(int $subtask_id) : ?int;
}
