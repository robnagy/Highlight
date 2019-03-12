<?php

namespace App\Interfaces;

use App\Interfaces\EloquentServiceInterface;
use Illuminate\Database\Eloquent\Collection;

interface TagTaskServiceInterface
{
    /**
     * Returns collection of tags for the task.
     *
     * @param integer $task_id
     * @return Collection
     */
    public function list(int $task_id) : Collection;

    /**
     * Adds DB entry to Tag_Task table, linking tags to tasks.
     *
     * @param int $tag_id
     * @param int $task_id
     * @return boolean
     */
    public function link(int $tag_id, int $task_id) : bool;

    /**
     * Removes the entry linking tag to task for given tag and task id.
     *
     * @param integer $tag_id
     * @param integer $task_id
     * @return boolean
     */
    public function unlink(int $tag_id, int $task_id) : bool;
}
