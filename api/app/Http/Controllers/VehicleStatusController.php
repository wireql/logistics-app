<?php

namespace App\Http\Controllers;

use App\Models\VehicleStatus;

class VehicleStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = VehicleStatus::query()->get();

        return response()->json([
            "message" => "Список статусов успешно получен.",
            "data" => $item
        ]);
    }
}
