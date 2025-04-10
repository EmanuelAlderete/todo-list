<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use App\Services\TaskListService;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskListController extends Controller
{
    use AuthorizesRequests;
    protected TaskListService $taskListService;

    public function __construct(TaskListService $taskListService)
    {
        $this->taskListService = $taskListService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasklists = TaskList::where('user_id', Auth::user()->id)->get();
        return response()->json($tasklists, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',

        ]);

        $request['user_id'] = Auth::user()->id;

        $taksList = $this->taskListService->create($request->all());
        return response()->json($taksList, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $taskList = $this->taskListService->findOrFail($id);
        return response()->json($taskList, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $taksList = $this->taskListService->update($id, $request->all());
        return response()->json($taksList, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskList $taskList)
    {
        $taskList = $this->taskListService->findOrFail($taskList->id);
        $taskList->delete();
        return response()->json([
            'message' => 'Lista de tarefas deletada com sucesso.'
        ], 200);
    }
}
