<?php

namespace App\Http\Controllers;

use App\Models\VehicleCategorie;

class VehicleCetegorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = VehicleCategorie::query()->get();

        return response()->json([
            "message" => "Список категорий успешно получен.",
            "data" => $item
        ]);
    }
}
