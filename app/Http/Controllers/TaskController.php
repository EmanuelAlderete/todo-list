<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $tasks = $this->taskService->all();

        return response()->json([
            'status' => 'success',
            'data' => $tasks,
        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task_list_id' => 'required|exists:task_lists,id',
            'text' => 'required|string',
            'labels' => 'array',
            'status' => 'string',
            'priority' => 'boolean',
        ]);

        $task = $this->taskService->create($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $task,
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
