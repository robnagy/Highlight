<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Interfaces\TagServiceInterface;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\UserService;

class TagController extends Controller
{
    /**
     * Tag service
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
     * Display all tags belonging to user_id. $user_id can be either
     * an existing user_id, or be the string identifier
     * for the guest user which is "guest".
     *
     * @param mixed $user_id
     * @return \Illuminate\Http\Response
     */
    public function indexFor($user_id) {
        $user_id = UserService::checkUserId($user_id);
        return $this->tagService->allForUser($user_id)
            ->sortBy('text')->values();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TagRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        return $this->tagService->createFromRequest($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //
    }
}
