<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportCliente;
use App\Models\Cliente;
use App\Helpers\Funciones;

class ClienteController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function cargaClientesForm(){
        $id_menu = 2;

        return view('home')->with('id_menu', $id_menu);
    }

    public function cargaClientesArchivo(Request $request){

        Excel::import(new ImportCliente, $request->file('fileExcel')->store('temp'));
        return back();
    }

    public function validaRut(Request $request){
        $rut = $request->input('rut');
        $dv = $request->input('dv');
        $cliente = Cliente::select('nombre')->where('rut',$rut)->where('dv',$dv)->first();
        if($cliente != null){

            return $cliente->nombre;
        }
        else{
            return 'ERROR';
        }
    }

}