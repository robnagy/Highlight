<?php

namespace App\Http\Controllers;

use App\Interfaces\TagTaskServiceInterface;
use App\Models\Tag;
use App\Models\Task;

class TagTaskController extends Controller
{
    protected $tagTaskService;

    /**
     * Constructor with TagTaskService injected.
     *
     * @param TagTaskServiceInterface $tagTaskService
     */
    public function __construct(TagTaskServiceInterface $tagTaskService)
    {
        $this->tagTaskService = $tagTaskService;
    }

    /**
     * Return all tags for a task
     *
     * @param integer $user_id
     * @param integer $task_id
     * @return void
     */
    public function index(int $user_id, int $task_id)
    {
        $this->authorize('view', [Task::class, $task_id]);
        $result = ['data' => $this->tagTaskService->list($task_id)];
        return $result;
    }

    /**
     * Links a tag and a task. Checks if the
     * user is authorised to modify both.
     *
     * @param integer $user_id
     * @param integer $task_id
     * @param integer $tag_id
     * @return void
     */
    public function link(int $user_id, int $task_id, int $tag_id)
    {
        $this->authorize('update', [Task::class, $user_id, $task_id]);
        $this->authorize('update', [Tag::class, $user_id, $tag_id]);
        $result = ['data' => $this->tagTaskService->link($tag_id, $task_id)];
        return $result;
    }

    /**
     * Unlinks a tag and a task. Checks if the
     * user is authorised to modify both.
     *
     * @param integer $user_id
     * @param integer $task_id
     * @param integer $tag_id
     * @return void
     */
    public function unlink(int $user_id, int $task_id, int $tag_id)
    {
        $this->authorize('update', [Task::class, $user_id, $task_id]);
        $this->authorize('update', [Tag::class, $user_id, $tag_id]);
        $result = ['data' => $this->tagTaskService->unlink($tag_id, $task_id)];
        return $result;
    }
}
