<?php

namespace App\Http\Controllers;

use App\Http\Requests\RouteList\RouteListRequest;
use App\Services\RouteListService;
use Illuminate\Http\Request;

class RouteListController extends Controller
{
    protected $routeListService;

    public function __construct(RouteListService $routeListService)
    {
        $this->routeListService = $routeListService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = $this->routeListService->getAllRouteLists($request);

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
        try {
            $fields = $request->validated();

            $item = $this->routeListService->storeRouteList($request, $fields);

            return response()->json([
                "message" => "Маршрутный лист успешно добавлен.",
                "data" => $item
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
                "data" => []
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        try {
            $item = $this->routeListService->showRouteList($request, $id);

            return response()->json([
                "message" => "Информация о маршрутном листе успешно получена",
                "data" => $item
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
                "data" => []
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RouteListRequest $request, string $id)
    {
        try {
            $item = $this->routeListService->updateRouteList($request, $id);

            return response()->json([
                "message" => "Информация о маршрутном листе успешно обновлена",
                "data" => $item->fresh()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
                "data" => []
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $item = $this->routeListService->desctroyRouteList($request, $id);

            return response()->json([
                "message" => "Маршрутный лист успешно удален",
                "data" => $item
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
                "data" => []
            ], 400);
        }
    }
}
