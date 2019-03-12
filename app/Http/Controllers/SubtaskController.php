<?php

namespace App\Http\Controllers;

use App\Interfaces\SubtaskServiceInterface;
use App\Models\Subtask;
use App\Http\Requests\SubtaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubtaskController extends Controller
{
    protected $subtaskService;

    public function __construct(SubtaskServiceInterface $subtaskService)
    {
        $this->subtaskService = $subtaskService;
    }

    /**
     * Display a listing of Subtasks for selected Task.
     *
     * @param mixed $user_id
     * @param int $task_id
     * @return \Illuminate\Http\Response
     */
    public function indexForTask($user_id, $task_id)
    {
        $this->authorize('view', [Subtask::class, $user_id, $task_id]);
        return $this->subtaskService->where('task_id', $task_id);
    }

    /**
     * Store a newly created Subtask in storage.
     *
     * @param mixed $user_id
     * @param int $task_id
     * @param SubtaskRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store($user_id, $task_id, SubtaskRequest $request)
    {
        $this->authorize('create', [Subtask::class, $user_id, $task_id]);
        $response = [ 'data' => $this->subtaskService->createFromRequest($request) ];
        return $response;
    }

    /**
     * Update the Subtask in storage.
     *
     * @param SubtaskRequest $request
     * @param mixed $user_id
     * @param int $task_id
     * @param  \App\Subtask  $subtask
     * @return \Illuminate\Http\Response
     */
    public function update(SubtaskRequest $request, $user_id, $task_id, int $subtask_id)
    {
        $response = [ 'data' => $this->subtaskService->updateFromRequest($subtask_id, $request) ];
        return $response;
    }

    /**
     * Remove the Subtask from storage
     *
     * @param mixed $user_id
     * @param int $task_id
     * @param int $subtask_id
     * @return void
     */
    public function delete($user_id, $task_id, $subtask_id)
    {
        $response = $this->subtaskService->deleteSubtask($subtask_id);
        $response = [ 'meta' => [ 'message' => 'Subtask deleted: ' . (string) $response ] ];
        return $response;
    }
}
