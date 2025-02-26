<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vehicle\VehicleRequest;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $item = $request->user()->vehicles()->get();

        return response()->json([
            "message" => "Список автомобилей успешно получен.",
            "data" => $item
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VehicleRequest $request)
    {
        $fields = $request->validated();

        $item = $request->user()->vehicles()->create($fields);

        return response()->json([
            "message" => "Автомобиль успешно добавлен.",
            "data" => $item
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $item = $request->user()->vehicles()->find($id);
        
        if(!$item) {
            return response()->json([
                "message" => "Информация о данном автомобиле не найдена",
                "data" => null
            ], 404);
        }
        
        return response()->json([
            "message" => "Информация об автомобиле успешно получена",
            "data" => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VehicleRequest $request, string $id)
    {
        $item = $request->user()->vehicles()->find($id);

        if(!$item) {
            return response()->json([
                "message" => "Информация о данном автомобиле не найдена",
                "data" => null
            ], 404);
        }

        $fields = $request->validated();

        $item->update($fields);

        return response()->json([
            "message" => "Информация об автомобиле успешно обновлена",
            "data" => $item
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $item = $request->user()->vehicles()->find($id);

        if(!$item) {
            return response()->json([
                "message" => "Информация о данном автомобиле не найдена",
                "data" => null
            ], 404);
        }

        $item->delete();

        return response()->json([
            "message" => "Автомобиль успешно удален",
            "data" => []
        ]);
    }
}
