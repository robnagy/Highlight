<?php

namespace App\Services;

use App\Http\Requests\TaskRequest;
use App\Interfaces\TaskServiceInterface;
use App\Models\Subtask;
use App\Models\Task;
use App\Services\EloquentService;
use App\Services\SubtaskService;
use Illuminate\Database\Eloquent\Collection;
Use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TaskService extends EloquentService implements TaskServiceInterface
{
    protected $subtaskService;

    public function __construct(Task $task, SubtaskService $subtaskService)
    {
        $this->subtaskService = $subtaskService;
        parent::__construct($task);
    }

    public function verifyUserTask(int $user_id, int $task_id) : bool
    {
        $count = Task::where('user_id', $user_id)->where('id', $task_id)->count();
        return $count ? true : false;
    }

    public function deleteTask(int $task_id) : bool
    {
        //delete all subtasks
        $subtasks = $this->subtaskService->selectWhere(['id'], ['task_id' => $task_id]);
        $this->subtaskService->bulkDelete($subtasks->toArray());
        //delete task
        return (bool) Task::where('id', $task_id)->delete();
    }

    public function getTaskUserId(int $task_id) : ?int
    {
        return $this->pluckFirstWhere('user_id', ['id' => $task_id]);
    }

    public function tasksForUser(int $user_id, string $date = null) : array
    {
        $date = $date ? $date : Carbon::today()->format('Y-n-j');
        $tasks = $this->model->where('user_id', $user_id)
                            ->whereDate('display_date', $date)
                            ->with(['tags'])
                            ->get()->toArray();
        return $tasks;
    }

    public function tasksForTag(int $user_id, int $tag_id) : array
    {
        $tasks = $this->model->where('user_id', $user_id)
                            ->whereHas('tags', function($q) use ($tag_id) {
                                $q->where('tag_id', $tag_id);
                            })
                            ->with(['tags'])
                            ->get()->toArray();
        return $tasks;
    }

    public function getPreviousTaskDate(int $user_id, string $date = null) : ?string
    {
        $date = $date ? $date : Carbon::today()->format('Y-n-j');
        $date = $this->model->where('user_id', $user_id)
                            ->whereDate('display_date', '<', $date)
                            ->groupBy('date')
                            ->orderBy('date', 'DESC')
                            ->first(array(
                                DB::raw('Date(display_date) as date')
                            ));
        $date = $date->date ?? null;
        if ($date) {
            $date = $this->formatDateForFrontend($date);
        }
        return $date;
    }

    public function getFutureTaskDate(int $user_id, string $date = null) : ?string
    {
        $date = $date ? $date : Carbon::today()->format('Y-n-j');
        $date = $this->model->where('user_id', $user_id)
                            ->whereDate('display_date', '>', $date)
                            ->groupBy('date')
                            ->orderBy('date', 'ASC')
                            ->first(array(
                                DB::raw('Date(display_date) as date'),
                                // DB::raw('COUNT(*) as "tasks"')
                            ));
        $date = $date->date ?? null;
        if ($date) {
            $date = $this->formatDateForFrontend($date);
        }
        return $date;
    }

    public function getAllTaskDates(int $user_id) : ?array
    {
        $dates = $this->model->where('user_id', $user_id)
                            ->groupBy('date')
                            ->orderBy('date', 'ASC')
                            ->get(array(
                                DB::raw('Date(display_date) as date'),
                                // DB::raw('COUNT(*) as "tasks"')
                            ));
        $dates = $dates->toArray();
        $dates = array_column($dates, 'date');
        foreach ($dates as &$date) {
            $date = $this->formatDateForFrontend($date);
        }
        return $dates;
    }

    protected function formatDateForFrontend(string $date) : string
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('Y-n-j');
    }
}
