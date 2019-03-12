<?php

namespace App\Services;

use App\Http\Requests\TaskRequest;
use App\Interfaces\TaskServiceInterface;
use App\Models\Subtask;
use App\Models\Task;
use App\Services\EloquentService;
use App\Services\SubtaskService;
use Illuminate\Database\Eloquent\Collection;
Use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class TaskService extends EloquentService implements TaskServiceInterface
{
    protected $subtaskService;

    public function __construct(Task $task, SubtaskService $subtaskService)
    {
        $this->subtaskService = $subtaskService;
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
        $subtasks = $this->subtaskService->selectWhere(['id'], ['task_id' => $task_id]);
        $this->subtaskService->bulkDelete($subtasks->toArray());
        //delete task
        return (bool) Task::where('id', $task_id)->delete();
    }

    public function getTaskUserId(int $task_id) : ?int
    {
        return $this->pluckFirstWhere('user_id', ['id' => $task_id]);
    }
}
