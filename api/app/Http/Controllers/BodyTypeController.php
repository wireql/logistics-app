<?php

namespace App\Http\Controllers;

use App\Models\BodyType;
use Illuminate\Http\Request;

class BodyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = BodyType::query()->get();

        return response()->json([
            "message" => "Список типов кузовов успешно получен.",
            "data" => $item
        ]);
    }
}
