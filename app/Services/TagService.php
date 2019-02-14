<?php

namespace App\Services;

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
     * Creates a Tag
     *
     * @param array $modelAttributes
     * @return App\Tag
     */
    public function create(array $modelAttributes) : Model
    {
        return parent::create($modelAttributes);
    }
}
