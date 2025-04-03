<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = TaskList::all();

        return response()->json($tasks, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255'
            ]);

            $tasklist = TaskList::create([
                'title' => $request->title
            ]);

            return response()->json($tasklist, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message: ' => 'Erro ao criar lista de tarefas.',
                'erro: ' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskList $taskList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskList $taskList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskList $taskList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskList $taskList)
    {
        //
    }
}
