<?php

namespace App\Services;

use App\Http\Requests\TaskRequest;
use App\Interfaces\TaskServiceInterface;
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

    /**
     * @inheritDoc
     */
    public function createFromRequest(TaskRequest $request) : Task
    {
        $taskArray = $request->only($this->model->fillable);
        return $this->create($taskArray);
    }

    /**
     *@inheritDoc
     */
    public function updateFromRequest(Task $task, TaskRequest $request) : Task
    {
        $taskArray = $request->only($this->model->fillable);
        return $this->update($task, $taskArray);
    }

}
