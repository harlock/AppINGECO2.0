<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Mesa;
use App\Models\AutoresCorrespondencia;
use App\Models\AsignaRevisores;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use function GuzzleHttp\Promise\all;
use Illuminate\Support\Facades\Mail;
use App\Mail\ArticlesMail;
use App\Mail\ArticulosEmail;
use App\Mail\ArticulosAceptadosEmail;
use App\Mail\ArticulosRechazadosEmail;
use App\Mail\ArticulosAceptadosCambiosEmail;
use App\Mail\ReenvioArticulosEmail;
use Illuminate\Support\Facades\Storage;

use ZipArchive;
use Illuminate\Support\Facades\File;
use App\Models\ComprobantePago;
use Illuminate\Support\Facades\Session;

class ArticuloController extends Controller
{
    public $id_articulo, $titulo, $archivo, $id_mesa,
        $id_autor, $nom_autor, $ap_autor, $am_autor, $correo, $tel;
    public $id;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $usuario = Auth::user();

        // Obtener artículos según el filtro de texto
        if ($texto == "/1" || $texto == "/2" || $texto == "/4" || $texto == "/5") {
            $estado = str_replace("/", "", $texto);

            $Artic = AsignaRevisores::join('articulos', 'articulos.id_articulo', '=', 'asigna_revisores.id_articulo')
                ->join('mesas', 'mesas.id_mesa', 'articulos.id_mesa')
                ->join('users', 'users.id', '=', 'asigna_revisores.id_user')
                ->where('articulos.estado', $estado)
                ->where("articulos.id_mesa", $usuario->id_mesa)
                ->where("asigna_revisores.id_user", $usuario->id)
                ->select(
                    'articulos.id_articulo',
                    'articulos.revista',
                    'articulos.titulo',
                    'articulos.estado',
                    'articulos.modalidad',
                    'articulos.archivo',
                    'mesas.descripcion',
                    'users.id',
                    'users.name',
                    'users.ap_paterno',
                    'users.email',
                    'users.ap_materno'
                )
                ->orderBy('users.created_at', 'desc')
                ->get();
        } elseif ($texto == "/6") {
            $Artic = DB::table('asigna_revisores')
                ->join('articulos', 'articulos.id_articulo', '=', 'asigna_revisores.id_articulo')
                ->join('mesas', 'mesas.id_mesa', 'articulos.id_mesa')
                ->join('users', 'users.id', '=', 'asigna_revisores.id_user')
                ->where("articulos.id_mesa", $usuario->id_mesa)
                ->where("asigna_revisores.id_user", $usuario->id)
                ->where(function ($query) use ($texto) {
                    $query
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
                    'users.name',
                    'users.ap_paterno',
                    'users.email',
                    'users.ap_materno'
                )
                ->orderBy('users.created_at', 'desc')
                ->get();
        } else {
            $Artic = AsignaRevisores::join('articulos', 'articulos.id_articulo', '=', 'asigna_revisores.id_articulo')
                ->join('mesas', 'mesas.id_mesa', 'articulos.id_mesa')
                ->join('users', 'users.id', '=', 'asigna_revisores.id_user')
                ->where("articulos.id_mesa", $usuario->id_mesa)
                ->where("asigna_revisores.id_user", $usuario->id)
                ->where(function ($query) use ($texto) {
                    $query
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
                    'users.name',
                    'users.email',
                    'users.ap_paterno',
                    'users.ap_materno'
                )
                ->orderBy('users.created_at', 'desc')
                ->get();
        }

        //dd($Artic);

        $autores = DB::table('articulos')
            ->join('autores_correspondencias', 'autores_correspondencias.id_autor', '=', 'articulos.id_autor')
            ->select('articulos.id_articulo', 'autores_correspondencias.correo')
            ->get()
            ->keyBy('id_articulo');

        return view('articulos.index', compact('Artic', 'autores'));
    }

    public function showArticulos()
    {
        $usuario = Auth::user();
        //dd($usuario->id);
        $articulos = DB::table('articulos')
            ->join('mesas', 'mesas.id_mesa', 'articulos.id_mesa')
            ->join('users', 'users.id', '=', 'articulos.id_user')
            ->leftJoin('comprobante_pagos', 'comprobante_pagos.id_articulo', '=', 'articulos.id_articulo')
            ->where("users.id", $usuario->id)
            ->select(
                'articulos.id_articulo',
                'articulos.revista',
                'articulos.titulo',
                'articulos.estado',
                'articulos.modalidad',
                'articulos.archivo',
                'mesas.descripcion',
                'comprobante_pagos.observacion',
                'users.id',
            )
            ->orderBy('articulos.created_at', 'desc')
            ->get();
        //dd($articulos);
        return view('enviar_articulo.lista_articulos', compact('articulos'));
    }

    public function articAdministrador(Request $request)
    {
        //dd($request);
        $texto = trim($request->get('texto'));
        //dd($texto);
        if ($texto == "/1") {
            $Artic = DB::table('asigna_revisores')
                ->join('articulos', 'articulos.id_articulo', '=', 'asigna_revisores.id_articulo')
                ->join('mesas', 'mesas.id_mesa', 'articulos.id_mesa')
                ->join('users', 'users.id', '=', 'articulos.id_user')
                ->where('articulos.estado', 1)
                ->select(
                    'articulos.id_articulo',
                    'articulos.revista',
                    'articulos.titulo',
                    'articulos.estado',
                    'articulos.modalidad',
                    'articulos.archivo',
                    'mesas.descripcion',
                    'users.id',
                    DB::raw("CONCAT(users.name, ' ', users.ap_paterno, ' ', users.ap_materno) as nombreCompleto"),
                    'users.telefono',
                    'users.email',
                )
                ->orderBy('users.created_at', 'desc')
                ->get();
        } elseif ($texto == "/2") {
            $Artic = DB::table('asigna_revisores')
                ->join('articulos', 'articulos.id_articulo', '=', 'asigna_revisores.id_articulo')
                ->join('mesas', 'mesas.id_mesa', 'articulos.id_mesa')
                ->join('users', 'users.id', '=', 'articulos.id_user')
                ->where('articulos.estado', 2)
                ->select(
                    'articulos.id_articulo',
                    'articulos.revista',
                    'articulos.titulo',
                    'articulos.estado',
                    'articulos.modalidad',
                    'articulos.archivo',
                    'mesas.descripcion',
                    'users.id',
                    DB::raw("CONCAT(users.name, ' ', users.ap_paterno, ' ', users.ap_materno) as nombreCompleto"),
                    'users.telefono',
                    'users.email',
                )
                ->orderBy('users.created_at', 'desc')
                ->get();
        } elseif ($texto == "/4") {
            $Artic = DB::table('asigna_revisores')
                ->join('articulos', 'articulos.id_articulo', '=', 'asigna_revisores.id_articulo')
                ->join('mesas', 'mesas.id_mesa', 'articulos.id_mesa')
                ->join('users', 'users.id', '=', 'articulos.id_user')
                ->whereIn('articulos.estado', [3,4])
                ->select(
                    'articulos.id_articulo',
                    'articulos.revista',
                    'articulos.titulo',
                    'articulos.estado',
                    'articulos.modalidad',
                    'articulos.archivo',
                    'mesas.descripcion',
                    'users.id',
                    DB::raw("CONCAT(users.name, ' ', users.ap_paterno, ' ', users.ap_materno) as nombreCompleto"),
                    'users.telefono',
                    'users.email',
                )
                ->orderBy('users.created_at', 'desc')
                ->get();
        } elseif ($texto == "/6") {
            $Artic = DB::table('asigna_revisores')
                ->join('articulos', 'articulos.id_articulo', '=', 'asigna_revisores.id_articulo')
                ->join('mesas', 'mesas.id_mesa', 'articulos.id_mesa')
                ->join('users', 'users.id', '=', 'articulos.id_user')
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
                    DB::raw("CONCAT(users.name, ' ', users.ap_paterno, ' ', users.ap_materno) as nombreCompleto"),
                    'users.telefono',
                    'users.email',
                )
                ->orderBy('users.created_at', 'desc')
                ->get();
        }elseif ($texto == "/5") {
            $Artic = DB::table('asigna_revisores')
                ->join('articulos', 'articulos.id_articulo', '=', 'asigna_revisores.id_articulo')
                ->join('mesas', 'mesas.id_mesa', 'articulos.id_mesa')
                ->join('users', 'users.id', '=', 'articulos.id_user')
                ->where('articulos.estado', 5)
                ->select(
                    'articulos.id_articulo',
                    'articulos.revista',
                    'articulos.titulo',
                    'articulos.estado',
                    'articulos.modalidad',
                    'articulos.archivo',
                    'mesas.descripcion',
                    'users.id',
                    DB::raw("CONCAT(users.name, ' ', users.ap_paterno, ' ', users.ap_materno) as nombreCompleto"),
                    'users.telefono',
                    'users.email',
                )
                ->orderBy('users.created_at', 'desc')
                ->get();
        } else {
            // dd("ok");
            $Artic = DB::table('articulos')
                // ->join('articulos', 'articulos.id_articulo', '=', 'asigna_revisores.id_articulo')

                ->join('mesas', 'mesas.id_mesa', 'articulos.id_mesa')
                ->join('users', 'users.id', '=', 'articulos.id_user')
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
                    DB::raw("CONCAT(users.name, ' ', users.ap_paterno, ' ', users.ap_materno) as nombreCompleto"),
                    'users.telefono',
                    'users.email',
                )
                ->orderBy('users.created_at', 'desc')
                ->get();
        }
        //dd($Artic);

        $pagos = DB::table('comprobante_pagos')
            ->select('id_articulo', 'comprobante', 'referencia', 'factura', 'constancia_fiscal', 'deleted_at', 'estado_pago')
            ->where('estado_pago', 1)
            ->get();

        $comprobanteUrls = [];
        foreach ($pagos as $pago) {
            $comprobanteUrls[$pago->id_articulo] = [
                'comprobante' => Storage::url($pago->comprobante),
                'referencia' => $pago->referencia,
                'factura' => $pago->factura,
                'constancia_fiscal' => $pago->constancia_fiscal ? Storage::url($pago->constancia_fiscal) : null,
                'deleted_at' => $pago->deleted_at,
                'estado_pago' => $pago->estado_pago
            ];
        }

        $articulosConPagos = $pagos->pluck('id_articulo')->toArray();

        $autores = DB::table('articulos')
            ->join('autores_correspondencias', 'autores_correspondencias.id_autor', '=', 'articulos.id_autor')
            ->select('articulos.id_articulo', 'autores_correspondencias.correo', 'autores_correspondencias.nom_autor', 'autores_correspondencias.ap_autor', 'autores_correspondencias.am_autor', 'autores_correspondencias.tel')
            ->get()
            ->keyBy('id_articulo');

        return view('administrador.articulos_revisores', compact('Artic', 'pagos', 'comprobanteUrls', 'articulosConPagos', 'autores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mesas = Mesa::all();
        $autor = User::all();
        //$articulos=Articulo::all();
        $articulos = DB::table('articulos')
            ->join('mesas', 'articulos.id_mesa', '=', 'mesas.id_mesa')
            ->where('id_user', '=', Auth::user()->id)
            ->select('articulos.*', 'mesas.*')
            ->orderByDesc('id_articulo')
            ->get();
        //dd($articulos);
        //dd( auth()->user()->id);
        //dd( auth()->user()->name);
        return view('enviar_articulo.create', compact('mesas', 'articulos'));
    }

    public function sendEmail($mail)
    {
        // dd($mail);
        $details = [
            'title' => 'Correo de AppIngeco ',
            'body' => 'Recuerda que te estaremos enviando por correo tus resultados,
            en caso de ser aprobado
            tendrás que realizar el pago y la presentacion para recibir
            tus constancias'
        ];
        Mail::to($mail)->queue(new ArticlesMail($details));
        //return new  ArticlesMail ($details);//Para probarlo local el mensaje
        return "Correo Electronico ENVIADO";
    }
    public function changeValueArticles()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'revista' => 'required',
            'titulo' => 'required|unique:articulos',
            'archivo' => 'required|file|max:5120|mimes:docx',
            'archivo_plagio' => 'required|file|max:5120|mimes:pdf',
            'id_mesa' => 'nullable|exists:mesas,id_mesa',
            'modalidad' => 'required',
            'nom_autor' => 'required|string',
            'ap_autor' => 'required|string',
            'am_autor' => 'required|string',
            'correo' => 'required|email',
            'tel' => 'required|numeric|digits:10',
        ], [
            'revista.required' => 'Es necesario seleccionar una revista.',
            'titulo.required' => 'El título del artículo es obligatorio.',
            'titulo.unique' => 'Ya existe un artículo con este título. Elija otro.',
            'archivo.required' => 'Debe adjuntar un archivo para el artículo.',
            'archivo.file' => 'El archivo debe ser un documento.',
            'archivo.max' => 'El tamaño del archivo no puede superar los 5 MB.',
            'archivo.mimes' => 'El archivo debe estar en formato DOCX.',
            'archivo_plagio.required' => 'Debe adjuntar el archivo de plagio.',
            'archivo_plagio.file' => 'El archivo de plagio debe ser un documento.',
            'archivo_plagio.max' => 'El tamaño del archivo de plagio no puede superar los 5 MB.',
            'archivo_plagio.mimes' => 'El archivo de plagio debe estar en formato PDF.',
            'id_mesa.exists' => 'La mesa seleccionada no es válida.',
            'modalidad.required' => 'La modalidad del artículo es necesaria.',
            'nom_autor.required' => 'Es necesario colocar el nombre del autor.',
            'nom_autor.string' => 'El nombre del autor debe ser una cadena de texto.',
            'ap_autor.required' => 'Es necesario colocar el apellido paterno del autor.',
            'ap_autor.string' => 'El apellido paterno debe ser una cadena de texto.',
            'am_autor.required' => 'Es necesario colocar el apellido materno del autor.',
            'am_autor.string' => 'El apellido materno debe ser una cadena de texto.',
            'correo.required' => 'Es necesario colocar el correo electrónico del autor.',
            'correo.email' => 'El correo electrónico debe tener un formato válido.',
            'tel.required' => 'Es necesario colocar el teléfono del autor.',
            'tel.numeric' => 'El teléfono debe contener únicamente números.',
            'tel.digits' => 'El teléfono debe tener exactamente 10 dígitos.',
        ]);

        // Manejo del archivo principal
        $archivo = $request->file('archivo')->store('archivos/articulos', 'public');

        // Manejo del archivo de plagio
        $archivoPlagio = $request->file('archivo_plagio')->store('archivos/plagio', 'public');


        $autor = AutoresCorrespondencia::firstOrCreate([
            'correo' => $request->correo
        ], [
            'nom_autor' => $request->nom_autor,
            'ap_autor' => $request->ap_autor,
            'am_autor' => $request->am_autor,
            'tel' => $request->tel,
        ]);

        // Crear el artículo
        $articulo = Articulo::create([
            'revista' => $request->revista,
            'titulo' => $request->titulo,
            'archivo' => $archivo, // Se guarda la ruta completa
            'archivo_plagio' => $archivoPlagio, // Se guarda la ruta completa
            'modalidad' => $request->modalidad,
            'id_mesa' => $request->id_mesa,
            'id_user' => auth()->user()->id,
            'id_autor' => $autor->id_autor,
        ]);

        Mail::to($autor->correo)->send(new ArticulosEmail($articulo->titulo, $articulo->revista, $articulo->modalidad));

        return redirect()->route('enviar_articulo.create')->with('success', 'Artículo registrado correctamente, los revisores se pondrán en contacto con el autor de correspondencia por medio del correo electrónico proporcionado.');
    }




    public function download($titulo)
    {
        //dd($titulo);
        $articulo = Articulo::where('titulo', $titulo)->firstOrFail();
        $pathToFile = storage_path('app/public/' . $articulo->archivo);

        //dd($articulo->estado);

        if ($articulo->estado == 0) {

            $articulo = DB::table("articulos")
                ->where('titulo', $titulo)
                ->update(['estado' => '3']);
        }
        $response = response()->download($pathToFile)->send();
        //$articulo = Articulo::where('titulo', $titulo)->update('estado','3');
        //dd($articulo);
        //dd($pathToFile);
        //response()->download($pathToFile);

        // return redirect()->route('list.art');


        //return redirect()->back();
    }

    public function download_zip()
    {
        $zip = new ZipArchive();
        $filename = 'articulos.zip';
        if ($zip->open(storage_path($filename), ZipArchive::CREATE) === TRUE) {
            $files = File::files(storage_path('app/public/archivos/articulos'));
            $i = 0;
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                //dd($relativeNameInZipFile);
                if (Articulo::where("archivo", "like", "%" . $relativeNameInZipFile . "%")->where("id_mesa", auth()->user()->id_mesa)->get()->count() > 0) {
                    $zip->addFile($value, $relativeNameInZipFile);
                    $i++;
                }
            }
            //dd($i);
            $zip->close();
        }
        return Response::download(storage_path($filename), $filename, ["Content-Type: application/zip"])->deleteFileAfterSend(true);
        //dd(public_path($filename));
        //return response()->download(storage_path($filename)->deleteFileAfterSend(true));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function show(Articulo $articulo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function edit(Articulo $articulo)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Articulo $evaluar_art)
    {
        //        dd($evaluar_art);

        $validated = $request->validate([
            'estado' => 'required|integer',
            'archivo' => 'nullable|file|mimes:doc,docx|max:5120'
        ]);

        // Actualizar el estado del artículo
        $evaluar_art->update([
            'estado' => $validated['estado'],
        ]);

        // Si el estado es 1, enviar un correo de aceptado
        if ($validated['estado'] == 1) {
            $autor = $evaluar_art->autorCorrespondencia;

            // Enviar el correo
            Mail::to($autor->correo)->send(new ArticulosAceptadosEmail(
                $evaluar_art->titulo,
                $evaluar_art->revista,
                $evaluar_art->modalidad
            ));
        }

        // Si el estado es 2, enviar un correo de rechazado
        if ($validated['estado'] == 2) {
            $autor = $evaluar_art->autorCorrespondencia;

            // Enviar el correo
            Mail::to($autor->correo)->send(new ArticulosRechazadosEmail(
                $evaluar_art->titulo,
                $evaluar_art->revista,
                $evaluar_art->modalidad
            ));
        }

        // Si el estado es 5, enviar un correo de aceptado con cambios
        if ($validated['estado'] == 5) {
            $autor = $evaluar_art->autorCorrespondencia;

            // Enviar el correo
            Mail::to($autor->correo)->send(new ArticulosAceptadosCambiosEmail(
                $evaluar_art->titulo,
                $evaluar_art->revista,
                $evaluar_art->modalidad
            ));
        }

        if ($validated['estado'] == 5 && $request->hasFile('archivo')) {

            $file = $request->file('archivo')->store('archivos/articulos', 'public');

            $evaluar_art->update([
                'archivo' => $file,
            ]);
        }

        return redirect()->back()->with('success', 'Artículo evaluado con éxito.');
    }

    public function updateArchivo(Request $request, Articulo $articulo)
    {
        $validated = $request->validate([
            'archivo' => 'required|file|mimes:doc,docx|max:5120',
        ],[
            'archivo.required' => 'Debes seleccionar un archivo',
            'archivo.max' => 'El tamaño máximo es de 5MB.'
        ]);

        if ($request->hasFile('archivo')) {
            // Almacenar el archivo
            $file = $request->file('archivo')->store('archivos/articulos', 'public');

            // Actualizar el artículo
            $articulo->update([
                'archivo' => $file,

            ]);
        }

        // Obtener el revisor asignado al artículo desde la tabla asigna_revisores
        $asignacion = DB::table('asigna_revisores')->where('id_articulo', $articulo->id_articulo)->first();
        if ($asignacion) {
            $revisor = DB::table('users')->where('id', $asignacion->id_user)->first();

            if ($revisor) {
                // Enviar el correo al revisor
                Mail::to($revisor->email)->send(new ReenvioArticulosEmail(
                    $articulo->titulo,
                    $articulo->revista,
                    $articulo->modalidad
                ));
            }
        }

        return redirect()->back()->with('success', 'Artículo reenviado con éxito.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Articulo  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($id);
        //$elimina = Articulo::find($articulo);
        //$eliminar = Articulo::find($articulo);
        //$eliminar->delete();
        $articuloRevisor = DB::table("asigna_revisores")
            ->where('id_Articulo', $id);
        $articuloRevisor->delete();
        $articulo = Articulo::findOrFail($id);
        $articulo->delete();


        return redirect()->back()->with('success', 'Articulo eliminado definitivamente');
    }

    /*public function regresarPago(Request $request, $id_articulo)
    {
        $request->validate([
            'observacion' => 'required|string|max:255',
        ],[
            'observacion.required' => 'Debe escribir al menos una observación que tenga el pago.',
            'observacion.max' => 'La observación no debe sobrepasar los 255 carácteres.'
        ]);

        $comprobante = ComprobantePago::where('id_articulo', $id_articulo)->first();

        if ($comprobante) {
            $comprobante->deleted_at = now(); // Marca el comprobante como eliminado
            $comprobante->observacion = $request->observacion; // Guarda la observación

            if ($comprobante->constancia_fiscal) {
                Storage::delete($comprobante->constancia_fiscal);
            }

            $comprobante->constancia_fiscal = null;
            $comprobante->save();

            Session::flash('success', 'Pago regresado exitosamente.');
        } else {
            Session::flash('error', 'No se encontró el comprobante de pago.');
        }

        return redirect()->back();
    }*/


}