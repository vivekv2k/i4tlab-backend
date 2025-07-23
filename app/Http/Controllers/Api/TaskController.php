<?php

namespace App\Http\Controllers\Api;

use App\Interfaces\TaskRepositoryInterface;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    protected $taskRepo;

    public function __construct(TaskRepositoryInterface $taskRepo)
    {
        $this->taskRepo = $taskRepo;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['user_id', 'status']);
        $perPage = $request->input('per_page', 10); // default 10

        return response()->json(
            $this->taskRepo->paginateWithFilters($filters, $perPage)
        );
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskRepo->create($request->validated());
        return response()->json($task, 201);
    }

    public function assign($id, Request $request)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);
        return response()->json($this->taskRepo->assignUser($id, $request->user_id));
    }

    public function filter(Request $request)
    {
        return response()->json($this->taskRepo->filter($request->only(['user_id', 'status'])));
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $data = $request->only(['title', 'description', 'due_date', 'assigned_user_id']);

        if ($request->has('status')) {
            $data['status'] = $request->status;
        }

        $task->update($data);

        return response()->json(['success' => true, 'task' => $task]);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }

}
