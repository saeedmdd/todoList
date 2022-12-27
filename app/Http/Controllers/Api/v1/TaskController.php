<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\v1\Task\StoreTaskRequest;
use App\Http\Requests\Api\v1\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Repositories\Task\TaskRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TaskController extends ApiController
{

    public function __construct(private TaskRepository $taskRepository)
    {
    }

    /**
     * Display a listing of the tasks.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tasks = $this->taskRepository->paginate(relations: 'user');

        return self::success("tasks list", $tasks);
    }

    /**
     * Store a newly created task in storage.
     *
     * @param StoreTaskRequest $request
     * @return JsonResponse
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskRepository->create([
            "title" => $request->title,
            "description" => $request->description,
            "color" => $request->color,
            "done_date" => $request->starts_at,
            "user_id" => auth()->user()->id
        ]);

        return self::success(
            message: "task created successfully",
            data: $task,
            code: Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified task.
     *
     * @param Task $task
     * @return JsonResponse
     */
    public function show(Task $task): JsonResponse
    {
        return self::success(data: $task, code: Response::HTTP_PARTIAL_CONTENT);
    }

    /**
     * Update the specified task in storage.
     *
     * @param UpdateTaskRequest $request
     * @param Task $task
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $this->authorize("user-task", $task);
        return $this->taskRepository->update($task, [
            "title" => $request->title,
            "description" => $request->description,
            "color" => $request->color,
            "done_at" => $request->starts_at,
        ]) ?
            self::success(message: "{$task->title} updated", code: Response::HTTP_ACCEPTED) :
            self::error(message: "server error", code: Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Remove the specified task from storage.
     *
     * @param Task $task
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(Task $task): JsonResponse
    {
        $this->authorize("user-task", $task);
        $this->taskRepository->deleteOrFail($task);
        return self::success(message: "{$task->title} deleted", code: Response::HTTP_ACCEPTED);
    }
}
