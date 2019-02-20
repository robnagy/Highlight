<?php

namespace App\Interfaces;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
Use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface TaskServiceInterface extends EloquentServiceInterface
{
    /**
     * Creates a new Task using mass fillable
     * values from validated TaskRequest.
     *
     * @param TaskRequest $request
     * @return Task
     */
    public function createFromRequest(TaskRequest $request) : Task;

    /**
     * Updates a Task using mass fillable
     * values from validated TaskRequest
     *
     * @param Task $task
     * @param TaskRequest $request
     * @return Task
     */
    public function updateFromRequest(Task $task, TaskRequest $request) : Task;
}
