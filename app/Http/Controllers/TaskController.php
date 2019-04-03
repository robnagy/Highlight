<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Interfaces\TaskServiceInterface;
use App\Models\Task;
use App\Models\User;
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
    public function indexForUser(int $user_id, string $date = null)
    {
        $this->authorize('view', [User::class, $user_id]);
        $tasks = $this->taskService->tasksForUser($user_id, $date);
        $dates = [
            'previous' => $this->taskService->getPreviousTaskDate($user_id, $date),
            'next' => $this->taskService->getFutureTaskDate($user_id, $date),
            'all' =>  $this->taskService->getAllTaskDates($user_id),
        ];
        $response = [ 'data' => $tasks, 'meta' => ['dates' => $dates]];
        return $response;
    }

    /**
     * Store a newly created task in storage.
     * Authorization occurs in the TaskRequest.
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
     * Stores updates for a task.
     * Authorization occurs in the TaskRequest.
     *
     * @param TaskRequest $request
     * @param int $user_id
     * @param int $task_id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, int $user_id, int $task_id)
    {
        $response = [ 'data' => $this->taskService->updateFromRequest($task_id, $request) ];
        return $response;
    }

    /**
     * Deletes a task. Runs the delete method on the eloquent model.
     *
     * @param int $user_id
     * @param int $task_id
     * @return \Illuminate\Http\Response
     */
    public function delete(int $user_id, int $task_id)
    {
        $this->authorize('delete', [Task::class, $user_id, $task_id]);

        $response = (string) $this->taskService->deleteTask( (int) $task_id);
        $response = [ 'meta' => [ 'message' => 'Task deleted: ' . $response ] ];
        return $response;
    }
}
