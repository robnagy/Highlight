<?php

namespace App\Services;

use App\Interfaces\TagServiceInterface;
use App\Models\Tag;

class TagService extends EloquentService implements TagServiceInterface
{
    public function __construct(Tag $tag)
    {
        parent::__construct($tag);
    }

    public function getTagUserId(int $tag_id) : ?int
    {
        return $this->pluckFirstWhere('user_id', ['id' => $tag_id]);
    }
}
