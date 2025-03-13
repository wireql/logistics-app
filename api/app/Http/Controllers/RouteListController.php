<?php

namespace App\Http\Controllers;

use App\Http\Requests\RouteList\RouteListRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RouteListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = $user->route_lists();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
    
            $query->where(function ($q) use ($searchTerm) {
                $q->where('id', 'like', '%' . $searchTerm . '%');
            });
        }

        $items = $query->paginate(10);

        return response()->json([
            "message" => "Список маршрутных листов успешно получен.",
            "data" => $items
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RouteListRequest $request)
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

        $item = $request->user()->route_lists()->create($fields);

        return response()->json([
            "message" => "Маршрутный лист успешно добавлен.",
            "data" => $item
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $item = $request->user()->route_lists()->find($id);
        
        if(!$item) {
            return response()->json([
                "message" => "Информация о данном маршрутном листе не найдена",
                "data" => null
            ], 404);
        }
        
        return response()->json([
            "message" => "Информация о маршрутном листе успешно получена",
            "data" => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RouteListRequest $request, string $id)
    {
        $item = $request->user()->route_lists()->find($id);
        
        if(!$item) {
            return response()->json([
                "message" => "Информация о данном маршрутном листе не найдена",
                "data" => null
            ], 404);
        }

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

        $item->update($fields);

        return response()->json([
            "message" => "Информация о маршрутном листе успешно обновлена",
            "data" => $item
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $item = $request->user()->route_lists()->find($id);

        if(!$item) {
            return response()->json([
                "message" => "Информация о данном маршрутном листе не найдена",
                "data" => null
            ], 404);
        }

        $item->delete();

        return response()->json([
            "message" => "Маршрутный лист успешно удален",
            "data" => []
        ]);
    }
}
