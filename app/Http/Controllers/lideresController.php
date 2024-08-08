<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mesa;
use App\Models\Articulo;
use App\Models\AsignaRevisores;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RevisorAsignadoEmail;
use Illuminate\Support\Facades\DB;

class lideresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $usuario = Auth::user();
        //dd($usuario->id_mesa);
        $usuarios = DB::table("users")
            ->where("users.id_mesa", $usuario->id_mesa)
            ->where("user_type", 2)/*
            ->whereNotIn('users.id', function ($query) {
                $query->select('id_user')
                    ->from('asigna_revisores');
            })*/
            ->get();
        /*

        $articulos = Articulo::where("id_mesa", $usuario->id_mesa)
            ->get();*/

        $articulos = DB::table("articulos")
            ->where("id_mesa", $usuario->id_mesa)
            ->whereNotIn(
                'articulos.id_articulo',
                AsignaRevisores::whereNotNull('id_articulo')
                    ->get()
                    ->pluck("id_articulo")
            )
            ->get();
        //dd($articulos);



        $texto = trim($request->get('texto'));
        $usuario = Auth::user();
        $lista_revisores = DB::table('asigna_revisores')
            ->join('articulos', 'articulos.id_articulo', '=', 'asigna_revisores.id_articulo')
            ->join('mesas', 'mesas.id_mesa', 'articulos.id_mesa')
            ->join('users', 'users.id', '=', 'asigna_revisores.id_user')
            ->where("articulos.id_mesa", $usuario->id_mesa)
            ->select(
                'asigna_revisores.id',
                'articulos.id_articulo',
                'articulos.revista',
                'articulos.titulo',
                'articulos.estado',
                'articulos.modalidad',
                'articulos.archivo',
                'mesas.descripcion',
                DB::raw("CONCAT(users.name, ' ', users.ap_paterno, ' ', users.ap_materno) as nombreRevisores"),
            )
            ->where(function ($query) use ($texto) {
                $query->WhereRaw("CONCAT(users.name, ' ', users.ap_paterno, ' ',users.ap_materno) LIKE ?", ['%' . $texto . '%'])
                    ->orWhere('articulos.titulo', 'LIKE', '%' . $texto . '%');
            })
            ->orderBy('asigna_revisores.created_at', 'desc')
            ->get();
        //dd($lista_revisores);

        $Artic = DB::table('asigna_revisores')
            ->join('articulos', 'articulos.id_articulo', '=', 'asigna_revisores.id_articulo')
            ->join('users', 'users.id', '=', 'asigna_revisores.id_user')
            ->where("articulos.id_mesa", $usuario->id_mesa)
            ->get();
        //dd($Artic);
        return view("lideres.index", compact("usuarios", "articulos", "lista_revisores", "Artic"));
    }




    public function vistaArtReva()
    {
        $usuario = Auth::user();
        $Artic = DB::table('asigna_revisores')
            ->join('articulos', 'articulos.id_articulo', '=', 'asigna_revisores.id_articulo')
            ->join('users', 'users.id', '=', 'asigna_revisores.id_user')
            ->where("articulos.id_mesa", $usuario->id_mesa)
            ->get();

        dd($Artic);
        return view("lideres.articulos_revision", compact("Artic"));
    }
    public function vistaArtRev(Request $request)
    {
        //dd($request);
        $texto = trim($request->get('texto'));
        $usuario = Auth::user();
        //dd($texto);
        if ($texto == "/1") {
            $Artic = DB::table('asigna_revisores')
                ->join('articulos', 'articulos.id_articulo', '=', 'asigna_revisores.id_articulo')
                ->join('mesas', 'mesas.id_mesa', 'articulos.id_mesa')
                ->join('users', 'users.id', '=', 'asigna_revisores.id_user')
                ->where('articulos.estado', 1)
                ->where("articulos.id_mesa", $usuario->id_mesa)
                ->select(
                    'articulos.id_articulo',
                    'articulos.revista',
                    'articulos.titulo',
                    'articulos.estado',
                    'articulos.modalidad',
                    'articulos.archivo',
                    'mesas.descripcion',
                    'users.id',
                    'users.telefono',
                    'users.email',
                    DB::raw("CONCAT(users.name, ' ', users.ap_paterno, ' ', users.ap_materno) as nombreCompleto"),
                )
                ->orderBy('users.created_at', 'desc')
                ->get();
        } elseif ($texto == "/2") {
            $Artic = DB::table('asigna_revisores')
                ->join('articulos', 'articulos.id_articulo', '=', 'asigna_revisores.id_articulo')
                ->join('mesas', 'mesas.id_mesa', 'articulos.id_mesa')
                ->join('users', 'users.id', '=', 'asigna_revisores.id_user')
                ->where('articulos.estado', 2)
                ->where("articulos.id_mesa", $usuario->id_mesa)
                ->select(
                    'articulos.id_articulo',
                    'articulos.revista',
                    'articulos.titulo',
                    'articulos.estado',
                    'articulos.modalidad',
                    'articulos.archivo',
                    'mesas.descripcion',
                    'users.id',
                    'users.telefono',
                    'users.email',
                    DB::raw("CONCAT(users.name, ' ', users.ap_paterno, ' ', users.ap_materno) as nombreCompleto"),

                )
                ->orderBy('users.created_at', 'desc')
                ->get();
        } elseif ($texto == "/4") {
            $Artic = DB::table('asigna_revisores')
                ->join('articulos', 'articulos.id_articulo', '=', 'asigna_revisores.id_articulo')
                ->join('mesas', 'mesas.id_mesa', 'articulos.id_mesa')
                ->join('users', 'users.id', '=', 'asigna_revisores.id_user')
                ->whereIn('articulos.estado', [3,4])
                ->where("articulos.id_mesa", $usuario->id_mesa)
                ->select(
                    'articulos.id_articulo',
                    'articulos.revista',
                    'articulos.titulo',
                    'articulos.estado',
                    'articulos.modalidad',
                    'articulos.archivo',
                    'mesas.descripcion',
                    'users.id',
                    'users.telefono',
                    'users.email',
                    DB::raw("CONCAT(users.name, ' ', users.ap_paterno, ' ', users.ap_materno) as nombreCompleto"),

                )
                ->orderBy('users.created_at', 'desc')
                ->get();
        } elseif ($texto == "/6") {
            $Artic = DB::table('asigna_revisores')
                ->join('articulos', 'articulos.id_articulo', '=', 'asigna_revisores.id_articulo')
                ->join('mesas', 'mesas.id_mesa', 'articulos.id_mesa')
                ->join('users', 'users.id', '=', 'asigna_revisores.id_user')
                ->where("articulos.id_mesa", $usuario->id_mesa)
                ->where(function ($query) use ($texto) {
                    $query->WhereRaw("CONCAT(users.name, ' ', users.ap_paterno, ' ',users.ap_materno) LIKE ?", ['%' . $texto . '%'])
                        ->orWhere('articulos.titulo', 'LIKE', '%' . $texto . '%')
                        ->orWhere('articulos.modalidad', 'LIKE', '%' . $texto . '%')
                        ->orWhere('articulos.revista', 'LIKE', '%' . $texto . '%');
                })
                ->select(
                    'articulos.id_articulo',
                    'articulos.revista',
                    'articulos.titulo',
                    'articulos.estado',
                    'articulos.modalidad',
                    'articulos.archivo',
                    'mesas.descripcion',
                    'users.id',
                    'users.telefono',
                    'users.email',
                    DB::raw("CONCAT(users.name, ' ', users.ap_paterno, ' ', users.ap_materno) as nombreCompleto"),

                )
                ->orderBy('users.created_at', 'desc')
                ->get();
        } elseif ($texto == "/5") {
            $Artic = DB::table('asigna_revisores')
                ->join('articulos', 'articulos.id_articulo', '=', 'asigna_revisores.id_articulo')
                ->join('mesas', 'mesas.id_mesa', 'articulos.id_mesa')
                ->join('users', 'users.id', '=', 'asigna_revisores.id_user')
                ->where('articulos.estado', 5)
                ->where("articulos.id_mesa", $usuario->id_mesa)
                ->select(
                    'articulos.id_articulo',
                    'articulos.revista',
                    'articulos.titulo',
                    'articulos.estado',
                    'articulos.modalidad',
                    'articulos.archivo',
                    'mesas.descripcion',
                    'users.id',
                    'users.telefono',
                    'users.email',
                    DB::raw("CONCAT(users.name, ' ', users.ap_paterno, ' ', users.ap_materno) as nombreCompleto"),

                )
                ->orderBy('users.created_at', 'desc')
                ->get();
        } else {
            $Artic = DB::table('articulos')
               // ->join('articulos', 'articulos.id_articulo', '=', 'asigna_revisores.id_articulo')
                ->join('mesas', 'mesas.id_mesa', 'articulos.id_mesa')
                //->join('users', 'users.id', '=', 'asigna_revisores.id_user')
                ->where("articulos.id_mesa", $usuario->id_mesa)
                ->where(function ($query) use ($texto) {
                   // $query->WhereRaw("CONCAT(users.name, ' ', users.ap_paterno, ' ',users.ap_materno) LIKE ?", ['%' . $texto . '%'])
                       $query ->orWhere('articulos.titulo', 'LIKE', '%' . $texto . '%')
                        ->orWhere('articulos.modalidad', 'LIKE', '%' . $texto . '%')
                        ->orWhere('articulos.revista', 'LIKE', '%' . $texto . '%');
                })
                ->select(
                    'articulos.id_articulo',
                    'articulos.revista',
                    'articulos.titulo',
                    'articulos.estado',
                    'articulos.modalidad',
                    'articulos.archivo',
                    'mesas.descripcion',
                  //  'users.id',
                   // 'users.telefono',
                   // 'users.email',
                    //DB::raw("CONCAT(users.name, ' ', users.ap_paterno, ' ', users.ap_materno) as nombreCompleto"),

                )
               // ->orderBy('users.created_at', 'desc')
                ->get();
        }
        //dd($Artic);
        return view('lideres.articulos_revision', compact('Artic'));
    }
    public function asignArticulo($request)
    {
        $revisor = DB::table("users")
            ->where('id', $request)
            ->update(['user_type' => '3']);
    }

    public function store(Request $request)
    {
        //dd($request);

        //$usuario=User::find($request->usuario);
        //dd($request->id);

        $request->validate([
            "id_articulo" => "required",
        ]);

        //dd('Articulo',$request->id_articulo, 'usuario',$request->id);
        AsignaRevisores::create([
            'id_articulo' => $request->id_articulo,
            'id_user' => $request->id,
        ]);

        $articulo = DB::table('articulos')->where('id_articulo', $request->id_articulo)->first();
        $revisor = DB::table('users')->where('id', $request->id)->first();

        //dd($request->id_articulo);
        $cambiarArticulo = DB::table("articulos")
            ->where('id_articulo', $request->id_articulo)
            ->update(['estado' => '4']);

        // Enviar el correo al revisor
        Mail::to($revisor->email)->send(new RevisorAsignadoEmail(
            $articulo->titulo,
            $articulo->revista,
            $articulo->modalidad
        ));

        return redirect()->route('lideres.index')->with('success', 'Autor asignado correctamente.');
    }

    public function eliminarRevArtic($id)
    {
        //dd($id, 'asigna_revisores');
        //dd(AsignaRevisores::where('id',$id));
        $ind = AsignaRevisores::where('id', $id);
        $ind->delete();
        return redirect()->back();
    }
}
