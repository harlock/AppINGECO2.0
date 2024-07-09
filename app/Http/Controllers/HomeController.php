<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $usuarios = User::where("user_type", 3)->get();
        $usuariosre = User::where("user_type", 2)->get();


        return view(
            'home',
            compact(
                'usuarios',
                'usuariosre',

            )
        );
    }

    public function actualizaTabla(Request $request)
    {
        $anio = $request->input('anio', date('Y'));
        //dd($anio);

        $usuariosPorAnio = User::select(DB::raw('YEAR(created_at) as anio'), DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', $anio)
            ->where("user_type", 3)
            ->groupBy('anio')
            ->orderBy('anio', 'asc')
            ->get();

        $texto = trim($request->get('texto'));
        $filtro_usuarios = DB::table('users')
            ->select(
                'id',
                'name',
                'ap_paterno',
                'ap_materno',
                DB::raw("CONCAT(name, ' ',ap_paterno, ' ', ap_materno) as nombreUsuarios"),
                'email',
                'telefono',
                'user_type',
                'id_mesa',
                'created_at',
            )
            ->whereYear('created_at', $anio)
            ->where("user_type", 3)
            ->where(function ($query) use ($texto) {
                $query->orWhereRaw("CONCAT(name, ' ', ap_paterno, ' ',ap_materno) LIKE ?", ['%' . $texto . '%'])
                    ->orWhere('email', 'LIKE', '%' . $texto . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();
        //dd($filtro_usuarios);



        return view(
            'usuarios.lista_usuarios',
            compact(
                'filtro_usuarios',
                'texto',
                'usuariosPorAnio',
                'anio',
            )
        );
    }
}
