<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    protected function query()
    {
        return auth()->user()->tasks();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = $this->query()
        ->when($request->filled('search'),fn ($q) =>  $q->search($request->search))
        ->when($request->filled('status') ,fn($q) => $q->status($request->status));
        return TaskResource::collection($tasks->latest()->paginate(10)->withQueryString());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $storeRequest)
    {
        $task = $this->query()->create($storeRequest->validated());
        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return new TaskResource($task);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        $data = $request->validated();
        if (isset($data['status']) && $data['status'] === 'completed')
       {     $data['completed_at'] = now();}
        $task->update($data);

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->noContent();
    }
}
