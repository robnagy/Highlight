<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Interfaces\TagServiceInterface;
use App\Models\Tag;
use App\Services\UserService;
use App\Traits\RouteUserIdTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TagController extends Controller
{
    use RouteUserIdTrait;

    /**
     * Inject Tag service
     *
     * @var TagServiceInterface
     */
    protected $tagService;

    public function __construct(TagServiceInterface $tagServiceInterface)
    {
        $this->tagService = $tagServiceInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->tagService->all();
    }

    /**
     * Display all Tags belonging to user_id. $user_id can be either
     * an existing user_id, or be the string identifier
     * for the guest user which is "guest".
     *
     * @param mixed $user_id
     * @return \Illuminate\Http\Response
     */
    public function indexFor($user_id) {
        $user_id = $this->checkUserId($user_id);
        return $this->tagService->allForUser($user_id)
            ->sortBy('text')->values();
    }

    /**
     * Store a newly created Tag in storage.
     *
     * @param TagRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        return $this->tagService->createFromRequest($request);
    }

    /**
     * Updates the Tag model. Model is resolved using route model
     * binding that links the {tag} url segment to a tag id.
     *
     * @param TagRequest $request
     * @param mixed $user_id
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, $user_id, Tag $tag)
    {
        return $this->taskService->updateFromRequest($tag, $request);
    }

    /**
     * Removes the Tag from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $response = [ 'meta' => [ 'message' => 'Tag deleted: ' . $tag->delete() ] ];
        return $response;
    }
}
