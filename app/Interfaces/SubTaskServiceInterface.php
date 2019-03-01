<?php

namespace App\Interfaces;


interface SubtaskServiceInterface extends EloquentServiceInterface
{
    /**
     * Deletes a Subtask
     *
     * @param integer $subtask_id
     * @return integer
     */
    public function deleteSubtask(int $subtask_id) : bool;
}
