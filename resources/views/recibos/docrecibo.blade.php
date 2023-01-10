<?php    
setlocale(LC_TIME,"es_CL");

?>
<style>
    .page-break {
        page-break-after: always;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <img style="width:150px;height:50px;float:left;" src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/images/logo.png'))  }}" class="img-responsive" />
    </div>
    <div class="col-md-12">
<?php
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$fecha =  \Carbon\Carbon::parse(date("d-m-Y"));
$mes = $meses[($fecha->format('n')) - 1];
$fecha_spanish = $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');

?>
<span style="float:right;font-weight:bold;">Folio N°{{$recibo->id}} <br><br> {{$fecha_spanish}}</span>


<h4 style="text-align:center;">RECIBO DE DOCUMENTOS</h4>

<br>
<div class="form-group" style="border: 1px solid #000;">
    <label for="recibeDe">Se recibe de:</label>
    {{$recibo->Cliente->nombre}}
</div>
<br>
<div class="form-group" style="border: 1px solid #000;">
    <label for="recibeDe">Cédula Identidad:</label>
    {{$recibo->Cliente->rut."-".$recibo->Cliente->dv}}
</div>
<br>
<div class="form-group" style="border: 1px solid #000;">
    <label for="recibeDe">La cantidad de:</label>
    {{$cantidad}}
</div>
<br>
<div class="form-group" style="border: 1px solid #000;">
    <label for="recibeDe">Por concepto de:</label>
    {{$concepto}}
</div>

<br>
<div class="form-group" style="border: 1px solid #000;">
    <label for="recibeDe">A favor de:</label>
    {{$recibo->Acreedor->nombre}}
</div>
<br>
<?php
    $valida_max_detalle = false;
?>
    <table style="border: 1px solid #000;min-width:630px;max-width:630px">
        <thead>
            <tr>
            <th>N°</th>    
            <th>N° Cheque</th>
            <th>Detalle</th>
            <th>Vencimiento</th>
            <th>Monto Cheque</th>
            <th>N° Cuenta</th>
            </tr>
        </thead>
        <tbody id="tbody_detalle_recibo">
            <?php $i = 0;  ?>
            @foreach($detalle_recibo as $detalle)
            <?php $i++; 
            
            if($i > 26){
                $valida_max_detalle = true;
                break;
            }
            ?>
            <tr class='trDetalle' data-id='<?php echo $detalle->id; ?>'>
                <td>{{$i}}</td>
                <td>{{$detalle->nro_cheque}}</td>
                <td>{{$detalle->detalle}}</td>
                <td>{{$detalle->vencimiento}}</td>
                <td>{{$detalle->monto_cheque}}</td>
                <td>{{$detalle->nro_cuenta}}</td>
            </tr>
            @endforeach
        </tbody>    
    </table>
    </div>
</div>

  

@if($valida_max_detalle)
    <div class="page-break"></div>
    <table style="border: 1px solid #000;min-width:630px;max-width:630px">
        <thead>
            <tr>
            <th>N°</th>    
            <th>N° Cheque</th>
            <th>Detalle</th>
            <th>Vencimiento</th>
            <th>Monto Cheque</th>
            <th>N° Cuenta</th>
            </tr>
        </thead>
        <tbody id="tbody_detalle_recibo">
            <?php  
            $aux_array = $detalle_recibo->slice(26);
            ?>
            @foreach($aux_array as $detalle)
            <?php 
            if($i > 52){
                $valida_max_detalle = true;
                break;
            }
            ?>
            <tr class='trDetalle' data-id='<?php echo $detalle->id; ?>'>
                <td>{{$i}}</td>
                <td>{{$detalle->nro_cheque}}</td>
                <td>{{$detalle->detalle}}</td>
                <td>{{$detalle->vencimiento}}</td>
                <td>{{$detalle->monto_cheque}}</td>
                <td>{{$detalle->nro_cuenta}}</td>
            </tr>
            <?php $i++;  ?>
            @endforeach
        </tbody>    
    </table>
    <div style="float:left;position:absolute;top:700;">
        
        <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(100)->generate('http://'.$_SERVER['HTTP_HOST'].'/recibo/detalleRecibo/'.$recibo->id)) }} ">

    </div> 
    <div style="float:right;position: absolute;top:700;">
        MERCED N° 280, PISO 6
        <br>
        STGO. CENTRO
        <br>
        MESA CENTRAL (56 2) 2763 5000
        <br>
        www.acobro.cl
    </div>
@else

    <div style="float:left;position:absolute;top:700;">
        <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(100)->generate('http://'.$_SERVER['HTTP_HOST'].'/recibo/detalleRecibo/'.$recibo->id)) }} ">

    </div>    

    <div style="float:right;position: absolute;top:700;">
        MERCED N° 280, PISO 6
        <br>
        STGO. CENTRO
        <br>
        MESA CENTRAL (56 2) 2763 5000
        <br>
        www.acobro.cl
    </div>
@endif






