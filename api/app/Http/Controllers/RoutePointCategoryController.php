<?php

namespace App\Http\Controllers;

use App\Models\RoutePointCategory;
use Illuminate\Http\Request;

class RoutePointCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = RoutePointCategory::query()->get();

        return response()->json([
            "message" => "Список категорий успешно получен.",
            "data" => $item
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
