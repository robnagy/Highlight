<?php

namespace App\Policies;

use App\Models\User;
use App\Services\TagService;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * Determine whether the user can view the tag.
     *
     * @param  \App\Models\User  $user
     * @param  int  $user_id
     * @return mixed
     */
    public function view(User $user, int $user_id)
    {
        return $user->id === $user_id;
    }

    /**
     * Determine whether the user can create tags.
     *
     * @param  \App\Models\User  $user
     * @param  int  $user_id
     * @return mixed
     */
    public function create(User $user, int $user_id)
    {
        return $user->id === $user_id;
    }

    /**
     * Determine whether the user can update the tag.
     *
     * @param  \App\Models\User  $user
     * @param  int $user_id
     * @param  int $tag_id
     * @return mixed
     */
    public function update(User $user, int $user_id, int $tag_id)
    {
        $tag_user_id = $this->tagService->getTagUserId($tag_id);
        return $user->id === $user_id && $user->id === $tag_user_id;
    }

    /**
     * Determine whether the user can delete the tag.
     *
     * @param  \App\Models\User  $user
     * @param  int  $user_id
     * @param  int  $tag_id
     * @return mixed
     */
    public function delete(User $user, int $user_id, int $tag_id)
    {
        $tag_user_id = $this->tagService->getTagUserId($tag_id);
        return $user->id === $user_id && $user->id === $tag_user_id;
    }
}
