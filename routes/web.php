<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('login');
});
Route::get('/welcome', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/nuevoRecibo',[App\Http\Controllers\ReciboController::class, 'nuevoReciboForm'])->name('nuevoRecibo');
Route::post('/nuevoRecibo/store',[App\Http\Controllers\ReciboController::class, 'store'])->name('nuevoReciboStore');

Route::get("/recibo/detalleRecibo/{id}", [App\Http\Controllers\ReciboController::class, 'detalleReciboNew'])->name('detalleRecibo.new');
Route::post("/recibo/detalleRecibo/new", [App\Http\Controllers\ReciboController::class, 'insertarNuevoDetalle'])->name('detalleRecibo.insertar');
Route::post("/recibo/detalleRecibo/delete",[App\Http\Controllers\ReciboController::class, 'borrarDetalle'])->name('detalleRecibo.borrar');
Route::post("/recibo/detalleRecibo/generateDoc",[App\Http\Controllers\ReciboController::class, 'generaComprobanteRecibo'])->name("generaComprobanteRecibo");
Route::get("/recibo/list",[App\Http\Controllers\ReciboController::class, 'list'])->name("listadoRecibos");
Route::post("/recibo/detalleRecibo/uploadImageDoc",[App\Http\Controllers\ReciboController::class, 'subirArchivoRecepcionado'])->name('subirArchivoRecepcionado');

Route::get('/cargaClientes',[App\Http\Controllers\ClienteController::class, 'cargaClientesForm'] )->name('cargaClientes');
Route::post('/cargaClientesPost',[App\Http\Controllers\ClienteController::class, 'cargaClientesArchivo'] )->name('cargaClientesPost');
Route::post('/validaRutCliente',[App\Http\Controllers\ClienteController::class, 'validaRut'] )->name('validaRut');

Route::get('/qrcode', [QrCodeController::class, 'index']);
