<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acreedor;
use App\Models\Cliente;
use App\Models\Recibo;
use App\Models\DetalleRecibo;
use Illuminate\Support\Facades\Auth;

class ReciboController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function nuevoReciboForm(){
        $id_menu = 1;
        $acreedores = Acreedor::all();

        return view('home')->with('id_menu', $id_menu)->with('acreedores',$acreedores);
    }


    public function store(Request $request){
        $rut = $request->input('rut');
        $dv = $request->input('dv');
        $acreedorSelect = $request->input('acreedorSelect');
        $acreedor = Acreedor::find($acreedorSelect);
        $cliente = Cliente::select('id')->where('rut',$rut)->where('dv',$dv)->first();

        if($acreedor == null){
            echo "ERROR: ACREEDOR INVÁLIDO O NO EXISTE";
            return;
        }

        if ($cliente == null) {
            echo "ERROR: CLIENTE NO EXISTE";
            return;
        }

        $recibo = new Recibo();
        $recibo->acreedor_id = $acreedorSelect;
        $recibo->cliente_id = $cliente->id;
        $recibo->user_id = Auth::user()->id;
        $recibo->save();

        return $recibo->id;
        
        
    }

    public function detalleReciboNew($id){
        $id_menu = 3;
        $detalleRecibo = DetalleRecibo::where('id_recibo', $id)->get();
        $recibo = Recibo::find($id);

        return view('home')->with('id_menu', $id_menu)->with('id_recibo',$id)->with('detalle_recibo',$detalleRecibo)
        ->with('recibo',$recibo);
    }

    public function insertarNuevoDetalle(Request $request){
        $num_cheque = $request->input('num_cheque');
        $detalle = $request->input('detalle');
        $vencimiento = $request->input('vencimiento');
        $monto_cheque = $request->input('monto_cheque');
        $nro_cuenta = $request->input('nro_cuenta');
        $id_recibo = $request->input('id_recibo');

        $detalle_recibo = new DetalleRecibo();
        $detalle_recibo->nro_cheque = $num_cheque;
        $detalle_recibo->detalle = $detalle;
        $detalle_recibo->vencimiento = $vencimiento;
        $detalle_recibo->monto_cheque = $monto_cheque;
        $detalle_recibo->nro_cuenta = $nro_cuenta;
        $detalle_recibo->id_recibo = $id_recibo;

        $detalle_recibo->save();
        return $detalle_recibo->id;
    }

    public function borrarDetalle(Request $request){
        $detalle_recibo = DetalleRecibo::find($request->input('id'));
        if ($detalle_recibo != null) {
            $detalle_recibo->delete();
            return 1;
        }
    }

    public function generaComprobanteRecibo(Request $request){
        set_time_limit(0);
        $id_recibo = $request->input('recibo_id');
        $concepto = $request->input('concepto');
        $cantidad = $request->input('cantidad');

        $detalle_recibo = DetalleRecibo::where('id_recibo',$id_recibo)->get();
        $recibo = Recibo::find($id_recibo);
        $recibo->concepto = $concepto;
        $recibo->save();

        $recibo = Recibo::find($id_recibo);


        $html = view('recibos.docrecibo', compact('id_recibo','concepto','cantidad','detalle_recibo','recibo'))->render();

        //dd($html);
        //echo '<img src="'.$_SERVER["DOCUMENT_ROOT"].'/logo.png'.'">';
        //die;
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($html);

        return $pdf->stream('folio.pdf');

    }

    public function list(){
        $id_menu = 4;
        $recibos = Recibo::where('user_id',Auth::user()->id)->get();
        
        return view('home')->with('id_menu', $id_menu)->with('recibos',$recibos);
    }

    public function subirArchivoRecepcionado(Request $request){
        $id = $request->input('id_recibo');
        //dd($request->file('fileImgRecibo'));
        if ($request->file('fileImgRecibo') != null) {
            $recibo = Recibo::find($id);
            $recibo->imagen_recibo = $request->file('fileImgRecibo')->store('public');
            $recibo->save();

            return 1;
        }
        else{
            return "ERROR: ARCHIVO NO VÁLIDO";
        }

    }
}