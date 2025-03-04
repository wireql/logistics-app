<?php

namespace App\Http\Controllers;

use App\Models\AddressCategories;
use Illuminate\Http\Request;

class AddressCategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = AddressCategories::query()->get();

        return response()->json([
            "message" => "Список категорий успешно получен.",
            "data" => $item
        ]);
    }
}
