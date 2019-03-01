<?php

namespace App\Services;

use App\Http\Requests\TaskRequest;
use App\Interfaces\TaskServiceInterface;
use App\Models\Subtask;
use App\Models\Task;
use App\Services\EloquentService;
use Illuminate\Database\Eloquent\Collection;
Use Illuminate\Database\Eloquent\Model;

class TaskService extends EloquentService implements TaskServiceInterface
{
    public function __construct(Task $task)
    {
        parent::__construct($task);
    }

    public function verifyUserTask(int $user_id, int $task_id) : bool
    {
        $count = Task::where('user_id', $user_id)->where('id', $task_id)->count();
        return $count ? true : false;
    }

    public function deleteTask(int $task_id) : bool
    {
        //delete all subtasks
        Subtask::where('task_id', $task_id)->delete();
        return (bool) Task::where('id', $task_id)->delete();
    }
}
