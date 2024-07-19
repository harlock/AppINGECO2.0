<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PeriodoArticulo;

class CheckPeriodoActivo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $currentDate = now()->format('Y-m-d');

        // Buscar un periodo activo
        $periodoActivo = PeriodoArticulo::whereDate('fecha_inicio', '<=', $currentDate)
                                        ->whereDate('fecha_fin', '>=', $currentDate)
                                        ->first();

        // Compartir el estado del periodo con la vista
        view()->share('periodoActivo', $periodoActivo);

        return $next($request);
    }
}
