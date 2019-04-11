<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Interfaces\TagServiceInterface;
use App\Models\Tag;
use App\Models\User;

class TagController extends Controller
{
    /**
     * Inject Tag service
     *
     * @param TagServiceInterface $tagServiceInterface
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
     * @param integer $user_id
     * @return \Illuminate\Http\Response
     */
    public function indexFor(int $user_id)
    {
        $this->authorize('view', [User::class, $user_id]);
        return $this->tagService->allForUserWithCount($user_id, ['tasks'])
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
        $response = ['data' => $this->tagService->createFromRequest($request)];
        return $response;
    }

    /**
     * Updates the Tag model. Model is resolved using route model
     * binding that links the {tag} url segment to a tag id.
     *
     * @param TagRequest $request
     * @param integer $user_id
     * @param integer $tag_id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, int $user_id, int $tag_id)
    {
        return $this->tagService->updateFromRequest($tag_id, $request);
    }

    /**
     * Removes the Tag from storage.
     *
     * @param  integer  $user_id
     * @param  integer  $tag_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $user_id, int $tag_id)
    {
        $this->authorize('delete', [Tag::class, $user_id, $tag_id]);
        $response = (string) $this->tagService->deleteTag( (int) $tag_id);
        $response = [ 'meta' => [ 'message' => 'Task deleted: ' . $response ] ];
        return $response;
    }
}
