<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class DocumentController extends Controller
{
    
    public function routeListGenerate(Request $request, $routeList) {
        $template = storage_path('app/templates/route-list.docx');

        if (!file_exists($template)) {
            return response()->json(['error' => 'Шаблон не найден'], 404);
        }

        $item = $request->user()->route_lists()->with(['vehicle', 'vehicle.category', 'vehicle.body_type', 'vehicle.status', 'driver'])->find($routeList);
        
        if(!$item) {
            return response()->json([
                "message" => "Информация о данном маршрутном листе не найдена",
                "data" => null
            ], 404);
        }

        $templateProcessor = new TemplateProcessor($template);

        $data = [
            'uuid' => $item['id'],
            'org_name' => $request->user()->company->name,
            'day' => now()->format('d'),
            'month' => now()->format('m'),
            'year' => now()->format('Y'),
            'employee_name' => $item['driver']['first_name'] . " " . $item['driver']['middle_name'] . " " . $item['driver']['last_name'],
            'employee_category' => 'Водитель',
        ];

        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value, true);
        }

        $fileName = 'route_' . $data['uuid'] . '.docx';
        $outputPath = storage_path('app/public/' . $fileName);

        $templateProcessor->saveAs($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }

}
