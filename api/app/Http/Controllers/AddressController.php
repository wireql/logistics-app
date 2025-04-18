<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\AddressRequest;
use App\Http\Requests\Address\AddressUpdateRequest;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('paginate')) {
            $item = Address::query()->with('category')->get();
        } else {
            $item = Address::query()->with('category')->paginate(10);
        }

        return response()->json([
            "message" => "Список адресов успешно получен.",
            "data" => $item
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressRequest $request)
    {
        $fields = $request->validated();

        $item = $request->user()->addresses()->create($fields);

        return response()->json([
            "message" => "Адрес успешно добавлен.",
            "data" => $item
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $item = $request->user()->addresses()->find($id);

        if (!$item) {
            return response()->json([
                "message" => "Информация о данном адресе не найдена",
                "data" => null
            ], 404);
        }

        return response()->json([
            "message" => "Информация об адресе успешно получена",
            "data" => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddressUpdateRequest $request, string $id)
    {
        $item = $request->user()->addresses()->find($id);

        if (!$item) {
            return response()->json([
                "message" => "Информация о данном адресе не найдена",
                "data" => null
            ], 404);
        }

        $fields = $request->validated();

        $item->update($fields);

        return response()->json([
            "message" => "Информация об адресе успешно обновлена",
            "data" => $item
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $item = $request->user()->addresses()->find($id);

        if (!$item) {
            return response()->json([
                "message" => "Информация о данном адресе не найдена",
                "data" => null
            ], 404);
        }

        $item->delete();

        return response()->json([
            "message" => "Адрес успешно удален",
            "data" => []
        ]);
    }
}
