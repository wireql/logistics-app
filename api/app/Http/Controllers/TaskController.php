<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\TaskRequest;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $item = $request->user()->tasks()->get();

        return response()->json([
            "message" => "Список задач успешно получен.",
            "data" => $item
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $fields = $request->validated();

        if($request->has('vehicle_id')) {
            $vehicle = $request->user()->vehicles()->find($fields['vehicle_id']);

            if(!$vehicle) {
                return response()->json([
                    "message" => "Автомобиль не найден.",
                    "data" => []
                ], 404);
            }
        }

        if($request->has('user_id')) {
            $user = $request->user()->employees()->find($fields['user_id']);

            if(!$user) {
                return response()->json([
                    "message" => "Пользователь не найден.",
                    "data" => []
                ], 404);
            }

            if($user->user_category_id !== 4) {
                return response()->json([
                    "message" => "Водителем может быть пользователь с категорией Водитель.",
                    "data" => []
                ], 404);
            }
        }

        $item = $request->user()->tasks()->create($fields);

        return response()->json([
            "message" => "Задача успешно добавлена.",
            "data" => $item
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $item = $request->user()->tasks()->find($id);
        
        if(!$item) {
            return response()->json([
                "message" => "Информация о данной задаче не найдена",
                "data" => null
            ], 404);
        }
        
        return response()->json([
            "message" => "Информация а задаче успешно получена",
            "data" => $item
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
    public function destroy(Request $request, string $id)
    {
        $item = $request->user()->tasks()->find($id);

        if(!$item) {
            return response()->json([
                "message" => "Информация о данной задаче не найдена",
                "data" => null
            ], 404);
        }

        $item->delete();

        return response()->json([
            "message" => "Задача успешно удалена",
            "data" => []
        ]);
    }
}
