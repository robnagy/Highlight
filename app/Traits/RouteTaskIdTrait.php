<?php

namespace App\Traits;

use App\Services\UserService;
use Illuminate\Support\Facades\Request;

trait RouteTaskIdTrait
{
    /**
     * Returns task_id based on "task_id" URL segment.
     *
     * @return int user_id
     */
    protected function getTaskIdFromRoute() {
        return Request::route('task_id');
    }
}
