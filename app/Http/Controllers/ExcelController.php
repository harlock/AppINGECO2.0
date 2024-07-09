<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ConsultaExport;

class ExcelController extends Controller
{

    
    public function descargarExcel(Request $request)
    {
        $datos = json_decode($request->input('datos'), true);
       // dd($datos);
        $coleccion = collect($datos);
        
        $export = new ConsultaExport($coleccion);
        
        
        return Excel::download($export, 'Articulos.xlsx');
    }
}