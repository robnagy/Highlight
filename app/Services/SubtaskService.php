<?php

namespace App\Services;

use App\Interfaces\SubtaskServiceInterface;
use App\Models\Subtask;

class SubtaskService extends EloquentService implements SubtaskServiceInterface
{
    public function __construct(Subtask $subtask)
    {
        parent::__construct($subtask);
    }

    public function deleteSubtask(int $subtask_id) : bool
    {
        $result = Subtask::where('id', $subtask_id)->delete();
        return $result ? true : false;
    }

    public function getSubtaskTaskId(int $subtask_id) : ?int
    {
        return $this->pluckFirstWhere('task_id', ['id' => $subtask_id]);
    }
}
