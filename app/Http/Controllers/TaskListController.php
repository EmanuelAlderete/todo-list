<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use App\Services\TaskListService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskListController extends Controller
{
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
        try {

            $tasklists = $this->taskListService->getAll();
            return response()->json($tasklists, 200);

        } catch (Exception $e) {

            return response()->json([
                'message' => 'Erro ao listar listas de tarefas.',
                'error' => $e->getMessage()

            ], 500);
        }
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

            $taksList = $this->taskListService->create($request->all());
            return response()->json($taksList, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message: ' => 'Erro ao criar lista de tarefas.',
                'error: ' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $taskList = $this->taskListService->findOrFail($id);
            return response()->json($taskList, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Lista de tarefas não encontrada.',
                'error' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro ao listar lista de tarefas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255'
            ]);

            $taksList = $this->taskListService->update($id, $request->all());
            return response()->json($taksList, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message: ' => 'Erro ao criar lista de tarefas.',
                'error: ' => $e->getMessage()
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Lista de tarefas não encontrada.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskList $taskList)
    {
        try {
            $taskList = $this->taskListService->findOrFail($taskList->id);
            $taskList->delete();
            return response()->json([
                'message' => 'Lista de tarefas deletada com sucesso.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar lista de tarefas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
