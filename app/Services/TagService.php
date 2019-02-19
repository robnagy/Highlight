<?php

namespace App\Services;

use App\Http\Requests\TagRequest;
use App\Interfaces\TagServiceInterface;
use App\Tag;
Use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TagService extends EloquentService implements TagServiceInterface
{
    public function __construct(Tag $tag)
    {
        parent::__construct($tag);
    }

    /**
     * @inheritDoc
     */
    public function createFromRequest(TagRequest $request) : Tag
    {
        $tagArray = $request->only($this->model->fillable);
        return $this->create($tagArray);
    }
}
