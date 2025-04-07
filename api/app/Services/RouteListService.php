<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Request;

class RouteListService
{
    public function getAllRouteLists($request)
    {
        $query = $request->user()->route_lists();

        if ($request->has('search')) {
            $query = $this->queryFindById($query, $request);
        }

        return $query->with('status')->paginate(10);
    }

    public function queryFindById($query, $request)
    {
        $searchTerm = $request->input('search');

        return $query->where(function ($q) use ($searchTerm) {
            $q->where('id', 'like', '%' . $searchTerm . '%');
        });
    }

    public function storeRouteList($request, $fields)
    {
        if ($request->has('vehicle_id')) {
            $vehicle = $request->user()->vehicles()->find($fields['vehicle_id']);

            if (!$vehicle) {
                throw new Exception("Автомобиль не найден.");
            }
        }

        if ($request->has('user_id')) {
            $user = $request->user()->employees()->find($fields['user_id']);

            if (!$user) {
                throw new Exception("Пользователь не найден.");
            }

            if ($user->user_category_id !== 4) {
                throw new Exception("Водителем может быть пользователь с категорией Водитель.");
            }
        }

        return $request->user()->route_lists()->create($fields);
    }

    public function showRouteList($request, $id)
    {
        $item = $request->user()->route_lists()->with(['vehicle', 'vehicle.category', 'vehicle.body_type', 'vehicle.status', 'driver'])->find($id);

        if (!$item) {
            throw new Exception("Информация о данном маршрутном листе не найдена");
        }

        return $item;
    }

    public function updateRouteList($request, $id)
    {
        $item = $request->user()->route_lists()->find($id);

        if (!$item) {
            throw new Exception("Информация о данном маршрутном листе не найдена");
        }

        $fields = $request->validated();

        if ($request->has('vehicle_id')) {
            $vehicle = $request->user()->vehicles()->find($fields['vehicle_id']);

            if (!$vehicle) {
                throw new Exception("Автомобиль не найден.");
            }
        }

        if ($request->has('user_id')) {
            $user = $request->user()->employees()->find($fields['user_id']);

            if (!$user) {
                throw new Exception("Пользователь не найден.");
            }

            if ($user->user_category_id !== 4) {
                throw new Exception("Водителем может быть пользователь с категорией Водитель.");
            }
        }

        $item->update($fields);

        return $item->fresh();
    }

    public function desctroyRouteList($request, $id)
    {
        $item = $request->user()->route_lists()->find($id);

        if (!$item) {
            throw new Exception("Информация о данном маршрутном листе не найдена");
        }

        return $item->delete();
    }
}
