<?php

namespace App\Interfaces;



interface TagServiceInterface extends EloquentServiceInterface
{
    /**
     * Returns the user_id for the provided tag_id.
     * Returns null if the tag_id does not exist.
     *
     * @param integer $tag_id
     * @return integer|null
     */
    public function getTagUserId(int $tag_id) : ?int;
}
