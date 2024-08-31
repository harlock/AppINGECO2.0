<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use App\Mail\ArticulosEmail;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\lideresController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\RevisoresController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\ComprobantePagoController;
use App\Http\Controllers\PeriodoArticuloController;
use App\Http\Controllers\ContadoresController;
use App\Http\Controllers\ArchivosDerechosController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

// Ruta para la verificación de correos electrónicos
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->middleware('verified')->name('home');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('homeUsers', [HomeController::class, 'actualizaTabla'])->name('home.users');
    Route::post('descargar-excel', [ExcelController::class, 'descargarExcel'])->name('descargar.excel');

    Route::middleware(['TypeAcces'])->group(function () {

        Route::resource("usuarios", UsuariosController::class);
        Route::get('revisores', [UsuariosController::class, 'indexRevisores'])->name('asign.revisores');
        Route::resource('mesas', MesaController::class);
        Route::get('artAdministrador', [ArticuloController::class, 'articAdministrador'])->name('art.admin');
    });

    Route::middleware(['UserAcces'])->group(function () {
    });

    //DESCARGA WORD
    Route::get('articulos/{titulo}/download', [ArticuloController::class, 'download', 'index'])->name('art.download');
    Route::get('download_zip', [ArtculoController::class, 'download_zip', 'index']);
    Route::get('changeValueArticle', [ArticuloController::class, 'download_zip', 'index']);

    //Descargar PDF
    Route::get('/articulos/download/{titulo}', [ArticuloController::class, 'download'])->name('art.download');
    Route::get('/articulos/downloadPlagio/{titulo}', [ArticuloController::class, 'downloadPlagio'])->name('art.downloadPlagio');
    Route::get('/articulos/{titulo}/downloadPlagio', [ArticuloController::class, 'downloadCarta'])->name('art.downloadCarta');

    //RUTAS EVALUADOR
    Route::get('evaluar_art', [ArticuloController::class, 'index'])->name('list.art');
    Route::resource('evaluar_art', ArticuloController::class)->except("index");

    //RUTAS PERFIL
    Route::get('/profileShow', [UsuariosController::class, 'show'])->name('show.profile');
    Route::get('/profileEdit', [UsuariosController::class, 'edit']);
    Route::get('/profileSaveEdit', [UsuariosController::class, 'profileEditSave']);
    //editar
    Route::put('/revisor/{id}', [UsuariosController::class, 'deleteRevisor'])->name('registro.revisor');
    Route::put('/revisor/{id}', [UsuariosController::class, 'deleteRevisor'])->name('registro.revisor');

    //Lideres
    Route::get('revisores', [RevisoresController::class, 'index'])->name('list.revisores');
    Route::get('lideres', [lideresController::class, 'index'])->name('asignaArticulos');
    Route::get('lideresArticulos', [lideresController::class, 'vistaArtRev'])->name('vista.artic.rev');
    Route::resource("lideres", lideresController::class);
    Route::get('lideres/{id}/delete', [lideresController::class, 'eliminarRevArtic', 'index'])->name('rev.artic.delete');

    //RUTAS ARTICULOS
    Route::resource("enviar_articulo", ArticuloController::class)->except('index');
    Route::get('articulosShow', [ArticuloController::class, 'showArticulos'])->name('show.art');

    Route::get('articulos/{titulo}/download', [ArticuloController::class, 'download', 'index'])->name('art.download');
    Route::get('articulos/{id_articulo}/destroy', [ArticuloController::class, 'destroy', 'index'])->name('art.destroy');
    Route::get("enviar_articulo_email", [ArticuloController::class, 'sendEmail']);

    //COMPROBANTES DE PAGO
    Route::resource('comprobantes_pagos', ComprobantePagoController::class);
    Route::post('/comprobantes/store', [ComprobantePagoController::class, 'store'])->name('comprobantes.store');
    Route::post('/regresar-pago/{id_articulo}', [ContadoresController::class, 'regresarPago'])->name('regresar-pago');
    Route::put('/articulos/{articulo}/updateArchivo', [ArticuloController::class, 'updateArchivo'])->name('articulos.updateArchivo');

    // Rutas para el recurso "periodos"
    Route::get('periodos/create', [PeriodoArticuloController::class, 'create'])->name('periodos.create');
    Route::post('periodos', [PeriodoArticuloController::class, 'store'])->name('periodos.store');
    Route::delete('periodos/{id}', [PeriodoArticuloController::class, 'destroy'])->name('periodos.destroy');
    Route::get('periodos/{id}/edit', [PeriodoArticuloController::class, 'edit'])->name('periodos.edit');
    Route::put('periodos/{id}', [PeriodoArticuloController::class, 'update'])->name('periodos.update');

    //Proteger enviar articulo
    Route::middleware(['auth', 'check.periodo.activo'])->group(function () {
        Route::get('enviar_articulo/create', [ArticuloController::class, 'create'])->name('enviar_articulo.create');
    });

    //CORREOS
    Route::get('enviar_articulo/create', [ArticuloController::class, 'create'])->name('enviar_articulo.create');
    Route::post('enviar_articulo', [ArticuloController::class, 'store'])->name('enviar_articulo.store');
    Route::post('evaluar_art', [ArticuloController::class, 'update'])->name('evaluar_art.update');
    Route::post('lideres', [lideresController::class, 'store'])->name('lideres.store');
    Route::post('contadores', [ContadoresController::class, 'regresarPago'])->name('contadores.regresarPago');
    Route::post('contadores', [ContadoresController::class, 'validarPago'])->name('contadores.validarPago');
    Route::post('articulosShow', [ArticuloController::class, 'updateArchivo'])->name('articulosShow.updateArchivo');

    //Contadores
    Route::get('contadores/index', [ContadoresController::class, 'index'])->name('contadores.index');
    Route::post('/validar-pago/{id_articulo}', [ContadoresController::class, 'validarPago'])->name('validar-pago');
    Route::get('contadores/index/{estado_pago?}', [ContadoresController::class, 'index'])->name('contadores.index');

    Route::post('/archivos-derechos', [ArchivosDerechosController::class, 'store'])->name('archivos_derechos.store');
    Route::get('/articulos/{id_articulo}/downloadArchivoDerecho', [ArticuloController::class, 'downloadArchivoDerecho'])->name('art.downloadArchivoDerecho');
    Route::put('/archivo-derecho/{id}', [ArchivosDerechosController::class, 'update'])->name('art.updateArchivoDerecho');

});
