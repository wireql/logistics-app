<?php

namespace App\Services;

use App\Models\RouteList;
use Exception;
use Illuminate\Http\Request;

class CargoService
{
    public function findRouteList(Request $request, $route_list)
    {
        $route_list = $request->user()->route_lists()->find($route_list);

        if (!$route_list) {
            throw new Exception("Маршрутный лист не найден.", 404);
        }

        return $route_list;
    }

    public function findRoutePoint(RouteList $routeList, $route_point)
    {
        $route_point = $routeList->route_points()->find($route_point);

        if (!$route_point) {
            throw new Exception("Подзадача не найдена.", 404);
        }

        return $route_point;
    }

    public function barcodeGenerate()
    {
        return strtoupper(substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 10));
    }
}
