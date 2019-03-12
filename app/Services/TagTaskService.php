<?php

namespace App\Services;

use App\Interfaces\TagServiceInterface;
use App\Interfaces\TagTaskServiceInterface;
use App\Interfaces\TaskServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class TagTaskService implements TagTaskServiceInterface
{
    protected $tagService;
    protected $taskService;

    public function __construct(TaskServiceInterface $taskService, TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
        $this->taskService = $taskService;
    }

    public function list(int $task_id) : Collection
    {
        $task = $this->taskService->find($task_id);
        return $task->tags;
    }

    public function link(int $tag_id, int $task_id) : bool
    {
        $tag = $this->tagService->find($tag_id);
        $task = $this->taskService->find($task_id);

        if ($tag && $task) {
            $task->tags()->attach($tag);
            return true;
        }
        return  false;
    }

    public function unlink(int $tag_id, int $task_id) : bool
    {
        $tag = $this->tagService->find($tag_id);
        $task = $this->taskService->find($task_id);

        if ($tag && $task) {
            $task->tags()->detach($tag);
            return true;
        }
        return  false;
    }
}
