<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cargo\CargoStoreRequest;
use App\Services\CargoService;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    protected $cargoService;

    public function __construct(CargoService $cargoService)
    {
        $this->cargoService = $cargoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $route_list, $route_point)
    {
        try {
            $route_list = $this->cargoService->findRouteList($request, $route_list);
            $route_point = $this->cargoService->findRoutePoint($route_list, $route_point);

            $items = $route_point->cargos()->get();

            return response()->json([
                "message" => "Список грузов успешно получен.",
                "data" => $items
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
                "data" => []
            ], $th->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CargoStoreRequest $request, $route_list, $route_point)
    {
        try {
            $fields = $request->validated();

            $route_list = $this->cargoService->findRouteList($request, $route_list);
            $route_point = $this->cargoService->findRoutePoint($route_list, $route_point);

            $fields['barcode'] = $this->cargoService->barcodeGenerate();

            $item = $route_point->cargos()->create($fields);

            return response()->json([
                "message" => "Груз успешно добавлен.",
                "data" => $item
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
                "data" => []
            ], $th->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
