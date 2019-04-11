<?php

namespace App\Services;

use App\Interfaces\TagServiceInterface;
use App\Models\Tag;

class TagService extends EloquentService implements TagServiceInterface
{
    protected $tagTaskService;

    public function __construct(Tag $tag)
    {
        parent::__construct($tag);
    }

    public function getTagUserId(int $tag_id) : ?int
    {
        return $this->pluckFirstWhere('user_id', ['id' => $tag_id]);
    }

    public function deleteTag(int $tag_id) : bool
    {
        //delete all tag task entries
        $subtasks = $this->subtaskService->selectWhere(['id'], ['task_id' => $tag_id]);
        $this->subtaskService->bulkDelete($subtasks->toArray());
        //delete task
        return (bool) Task::where('id', $tag_id)->delete();
    }
}
