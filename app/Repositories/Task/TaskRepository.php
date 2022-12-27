<?php

namespace App\Repositories\Task;

use App\Models\Task;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository extends BaseRepository
{
    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    public function getNearFinished(int $minutes = 30, array|string $columns = ["*"]): Collection|array
    {
        return $this->model
            ->query()
            ->whereBetween(
                "starts_at",
                [
                    now()->addMinutes($minutes),
                    now()->addMinutes($minutes + env("PERCENTAGE_ERROR", 5))
                ]
            )
            ->get($columns);
    }
}
