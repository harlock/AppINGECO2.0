<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mesa;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RevisoresController extends Controller
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
        $usuariosRegistrados = User::where("user_type", 2)
            ->where("id_mesa", null)
            ->get();
        $usuariosAsignados = User::join("mesas", "mesas.id_mesa", "users.id_mesa")
            ->where("user_type", 2)
            ->get();
        $mesas = Mesa::all();

        //dd($filtro_usuarios);
        //dd($mesas);
        //$mesas=DB::select("select distinct mesas.id_mesa, mesas.descripcion from mesas, users where not users.id_mesa=mesas.id_mesa");
        //dd($usuariosAsignados);
        return view("revisores.index", compact(
            "usuariosAsignados",
            "usuariosRegistrados",
            "mesas",
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
