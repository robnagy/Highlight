<?php

namespace App\Services;

use App\Http\Requests\TagRequest;
use App\Interfaces\TagServiceInterface;
use App\Models\Tag;
Use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TagService extends EloquentService implements TagServiceInterface
{
    public function __construct(Tag $tag)
    {
        parent::__construct($tag);
    }

}
