<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Interfaces\TaskServiceInterface;
use App\Models\Task;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Task Service Interface
     *
     * @var TaskServiceInterface
     */
    protected $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Returns tasks for user_id specified in route parameter.
     *
     * @var mixed $user_id
     * @return \Illuminate\Http\Response
     */
    public function indexForUser($user_id)
    {
        $user_id = UserService::checkUserId($user_id);
        return $this->taskService->allForUserWith($user_id, ['tags']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        return $this->taskService->createFromRequest($request);
    }

    /**
     * Updates the Task model. Model is resolved using route model
     * binding that links the {task} url segment to a task id.
     *
     * @param TaskRequest $request
     * @param mixed $user_id
     * @param Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $user_id, Task $task)
    {
        return $this->taskService->updateFromRequest($task, $request);
    }
}
