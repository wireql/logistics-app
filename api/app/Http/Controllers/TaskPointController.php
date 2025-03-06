<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskPoint\TaskPointRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskPointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $task)
    {
        $item = $request->user()->tasks()->find($task);

        if(!$item) {
            return response()->json([
                "message" => "Задача не найдена.",
                "data" => []
            ], 404);
        }

        $task_points = $item->task_points()->get();

        return response()->json([
            "message" => "Список подзадач успешно получен.",
            "data" => $task_points
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskPointRequest $request, $task)
    {
        $fields = $request->validated();

        $item = $request->user()->tasks()->find($task);

        if(!$item) {
            return response()->json([
                "message" => "Задача не найдена.",
                "data" => []
            ], 404);
        }

        $task_point = $item->task_points()->create($fields);

        return response()->json([
            "message" => "Подзадача успешно добавлена.",
            "data" => $task_point
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $task, string $id)
    {
        $item = $request->user()->tasks()->find($task);

        if(!$item) {
            return response()->json([
                "message" => "Задача не найдена.",
                "data" => []
            ], 404);
        }

        $task_point = $item->task_points()->find($id);
        
        if(!$task_point) {
            return response()->json([
                "message" => "Информация о данной подзадаче не найдена",
                "data" => null
            ], 404);
        }
        
        return response()->json([
            "message" => "Информация о подзадаче успешно получена",
            "data" => $task_point
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
