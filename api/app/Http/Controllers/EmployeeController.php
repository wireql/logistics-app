<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\EmployeeStoreRequest;
use App\Http\Requests\Employee\EmployeeUpdateRequest;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = $user->employees();

        if ($request->has('category')) {
            $query->where('user_category_id', $request->input('category'));
        }

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
    
            $query->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('middle_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        $items = $query->with('category')->paginate(10);

        return response()->json([
            "message" => "Список сотрудников успешно получен.",
            "data" => $items
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeStoreRequest $request)
    {
        $fields = $request->validated();
        if ($fields['user_category_id'] == 1) {
            $fields['user_category_id'] = 2;
        }

        $item = $request->user()->employees()->create($fields);

        return response()->json([
            "message" => "Сотрудник успешно добавлен.",
            "data" => $item
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $item = $request->user()->employees()->find($id);
        
        if(!$item) {
            return response()->json([
                "message" => "Информация о данном сотруднике не найдена",
                "data" => null
            ], 404);
        }
        
        return response()->json([
            "message" => "Информация о сотруднике успешно получена",
            "data" => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeUpdateRequest $request, string $id)
    {
        $item = $request->user()->employees()->find($id);

        if(!$item) {
            return response()->json([
                "message" => "Информация о данном сотруднике не найдена",
                "data" => null
            ], 404);
        }

        $fields = $request->validated();

        $item->update($fields);

        return response()->json([
            "message" => "Информация о сотруднике успешно обновлена",
            "data" => $item
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $item = $request->user()->employees()->find($id);

        if(!$item) {
            return response()->json([
                "message" => "Информация о данном сотруднике не найдена",
                "data" => null
            ], 404);
        }

        if($item->id === $request->user()->id) {
            return response()->json([
                "message" => "Нельзя удалить самого себя :(",
                "data" => null
            ], 404);
        }

        $item->delete();

        return response()->json([
            "message" => "Сотрудник успешно удален",
            "data" => []
        ]);
    }
}
