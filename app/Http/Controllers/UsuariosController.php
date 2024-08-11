<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $usuariosRegistrados = User::where("user_type", 4)->where("id_mesa", null)->get();
        $usuariosAsignados = User::join("mesas", "mesas.id_mesa", "users.id_mesa")
            ->where("user_type", 4)
            ->get();
        //dd($dato);
        /*
        $usuarios = DB::table("users")
            ->where("users.id_mesa", $usuario->id_mesa)
            ->where("user_type", 4)
            ->whereNotIn('users.id', function ($query) {
                $query->select('id_user')
                    ->from('asigna_revisores');
            })
            ->get();*/
        //MOSTRAR LAS MESAS QUE NO ESTAN ASIGNADAS A UN USUARIO TIPO 2 lider
        $mesas = DB::table("mesas")
            ->where("mesas.deleted_at", NULL)
            ->whereNotIn('mesas.id_mesa', User::where('user_type', 4)
                ->whereNotNull('id_mesa')->get()->pluck("id_mesa"))
            ->get();
        //dd($mesas);

        //$mesas=Mesa::whereNotIn("id_mesa",'')->get();
        return view("usuarios.index", compact("usuariosAsignados", "usuariosRegistrados", "mesas"));
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
        // dd($request->all());
        if ($request->accion == 2)
            $request->validate([
                "mesa" => "required"
            ]);
        $usuario = User::find($request->usuario);
        $usuario->update([
            //"user_type"=>$request->accion,
            "id_mesa" => $request->mesa,
        ]);
        return redirect()->back();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $usuario = Auth::user();
        //dd($usuario);
        return view("auth.profile", compact('usuario'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $usuario = Auth::user();
        //dd($usuario);
        return view("auth.profile_edit", compact('usuario'));
    }
    public function profileEditSave(Request $request)
    {
        //dd($request->name);
        $usuario = Auth::user();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'numeric', 'digits:10'],
        ], [
            'name.required' => 'Necesitas agregar un nombre.',
        ]);
        $registro = User::find($usuario->id);
        //dd($request);
        $registro->update($request->all());

        return redirect()->route('show.profile')->with('success', 'Perfil correctamente actualizado.');
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
        //dd($request->user_type);
        if ($request->user_type == 2) {
            $request->validate([
                "user_type" => "required"
            ]);
            $user = User::find($request->usuar);
            //dd($request->user_type ,'revisor');
            $user->update([
                "user_type" => $request->user_type,
            ]);
        } elseif ($request->user_type == 4) {
            $request->validate([
                "user_type" => "required"
            ]);
            $user = User::find($request->usuar);
            //dd($user->id);
            // dd($request->user_type );
            $user->update(["user_type" => $request->user_type,]);
        } elseif ($request->user_type == 5) {
            $request->validate([
                "user_type" => "required"
            ]);
            $user = User::find($request->usuar);
            //dd($user->id);
            // dd($request->user_type );
            $user->update(["user_type" => $request->user_type,]);
        }


        return redirect()->back();
    }
    public function deleteRevisor($request)
    {
        //dd($request);
        $revisor = DB::table("users")
            ->where('id', $request)
            ->update(['user_type' => '3']);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $ind = User::find($request->idd);
        $ind->delete();
        return redirect()->route('home');
    }
}
