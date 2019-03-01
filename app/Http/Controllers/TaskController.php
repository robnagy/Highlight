<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Interfaces\TaskServiceInterface;
use App\Models\Task;
use App\Services\UserService;
use App\Traits\RouteUserIdTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    use RouteUserIdTrait;

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
        $user_id = $this->checkUserId($user_id);
        $response = [ 'data' => $this->taskService->allForUserWith($user_id, ['tags']) ];
        return $response;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $response = [ 'data' => $this->taskService->createFromRequest($request) ];
        return $response;
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
        $response = [ 'data' => $this->taskService->updateFromRequest($task, $request) ];
        return $response;
    }

    /**
     * Deletes a task. Runs the delete method on the eloquent model.
     *
     * @param mixed $user_id
     * @param string $task_id
     * @return \Illuminate\Http\Response
     */
    public function delete($user_id, $task_id)
    {
        $response = (string) $this->taskService->deleteTask( (int) $task_id);
        $response = [ 'meta' => [ 'message' => 'Task deleted: ' . $response ] ];
        return $response;
    }
}
