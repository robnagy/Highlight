<?php

namespace App\Services;

use App\Interfaces\TagServiceInterface;
use App\Tag;
Use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagService extends EloquentService implements TagServiceInterface
{
    public function __construct(Tag $tag)
    {
        parent::__construct($tag);
    }

    /**
     * Creates a Tag
     *
     * @param Request $request
     * @return App\Tag
     */
    public function createFromRequest(Request $request) : Tag
    {
        $tagArray = $request->only($this->model->fillable);
        return $this->create($tagArray);
    }
}
