<?php


namespace App\Repositories;

use App\Models\Task;
use App\Interfaces\TaskRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskRepository implements TaskRepositoryInterface
{
    public function all()
    {
        return Task::with('user')->latest()->paginate(10);
    }

    public function find($id)
    {
        return Task::with('user')->findOrFail($id);
    }

    public function create(array $data)
    {
        $data['status'] = 'pending';
        return Task::create($data);
    }

    public function update($id, array $data)
    {
        $task = Task::findOrFail($id);
        unset($data['id']);
        $task->update($data);

        return $task;
    }

    public function delete($id)
    {
        $task = Task::findOrFail($id);
        return Task::destroy($id);
    }

    public function assignUser($taskId, $userId)
    {
        $task = Task::findOrFail($taskId);
        $task->assigned_user_id = $userId;
        $task->save();
        return $task;
    }


    public function paginateWithFilters(array $filters, $perPage = 10)
    {
        $query = \App\Models\Task::with('user');

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['user_id'])) {
            $query->where('assigned_user_id', $filters['user_id']);
        }

        return $query->orderBy('id')->paginate($perPage);
    }

}
