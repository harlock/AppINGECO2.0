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
        //dd($datos);

        $datos = array_map(function ($dato) {
            if($dato['estado']==1){
                $dato['estado'] = 'Aceptado';

            }elseif($dato['estado']==0){
                $dato['estado'] = 'Sin revisar';

            }elseif($dato['estado']==5){
                $dato['estado'] = 'Aceptado condicionado';

            }
            elseif($dato['estado']==4){
                $dato['estado'] = 'Proceso de revisión';

            }
            elseif($dato['estado']==3){
                $dato['estado'] = 'Proceso de revisión';

            }
            elseif($dato['estado']==2){
                $dato['estado'] = 'Rechazado';

            }
            return $dato;
        }, $datos);

        $coleccion = collect($datos);
        
        $export = new ConsultaExport($coleccion);
        
        
        return Excel::download($export, 'Articulos.xlsx');
    }
}