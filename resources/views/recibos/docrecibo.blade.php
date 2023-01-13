<?php    
setlocale(LC_TIME,"es_CL");

?>
<style>
    .page-break {
        page-break-after: always;
    }
</style>
<div class="pdf" style="width:600px;">
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
    <?php echo count($detalle_recibo). ' CHEQUE(S) POR LA SUMA DE ';  ?> {{$cantidad}}
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
            <th>Banco</th>
            </tr>
        </thead>
        <tbody id="tbody_detalle_recibo">
            <?php $i = 0;  ?>
            @foreach($detalle_recibo as $detalle)
            <?php $i++; 
            
            if($i > 18){
                $valida_max_detalle = true;
                break;
            }
            ?>
            <tr class='trDetalle' data-id='<?php echo $detalle->id; ?>'>
                <td>{{$i}}</td>
                <td>{{$detalle->nro_cheque}}</td>
                <td>{{$detalle->detalle}}</td>
                <td>{{$detalle->vencimiento}}</td>
                <td>${{$detalle->monto_cheque}}</td>
                <td>{{$detalle->nro_cuenta}}</td>
                <td>{{$detalle->banco}}</td>
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
            <th>Banco</th>
            </tr>
        </thead>
        <tbody id="tbody_detalle_recibo">
            <?php  
            $aux_array = $detalle_recibo->slice(18);
            ?>
            @foreach($aux_array as $detalle)
            <?php 
            if($i > 36){
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
                <td>{{$detalle->banco}}</td>
            </tr>
            <?php $i++;  ?>
            @endforeach
        </tbody>    
    </table>

    <div style="position:absolute;top:550;left:330;border: 3px solid #000;;width:165px;">
        <span style="text-align:center;margin-left:5px;font-weight:bold;font-size:20px;white-space:nowrap;">ACOBRO LTDA.</span>
        <br>
        <span style="font-size:9px;text-align:center;margin-left:15px;font-weight:bold;">MERCED 280, PISO 6 SANTIAGO</span>
        <br>
        <span style="border: 2px solid #000;text-align:center;margin-left:15px;padding:0px 15px 0px 15px;font-weight:bold;font-size:20px;">{{date("d-m-Y")}}</span>
        <br>
        <span style="font-size:26px;text-align:center;margin-left:15px;font-weight:bold;">RECIBIDO</span>
    </div>


    <div style="float:left;position:absolute;top:650;">
        
        <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(100)->generate('http://'.$_SERVER['HTTP_HOST'].'/recibo/detalleRecibo/'.$recibo->id)) }} ">

    </div> 
    <div style="float:right;position: absolute;top:650;">
        MERCED N° 280, PISO 6
        <br>
        STGO. CENTRO
        <br>
        MESA CENTRAL (56 2) 2763 5000
        <br>
        www.acobro.cl
    </div>
@else

    <div style="position:absolute;top:550;left:330;border: 3px solid #000;width:165px;">
        <span style="text-align:center;margin-left:5px;font-weight:bold;font-size:20px;white-space:nowrap;">ACOBRO LTDA.</span>
        <br>
        <span style="font-size:9px;text-align:center;margin-left:15px;font-weight:bold;">MERCED 280, PISO 6 SANTIAGO</span>
        <br>
        <span style="border: 2px solid #000;text-align:center;margin-left:15px;padding:0px 15px 0px 15px;font-weight:bold;font-size:20px;">{{date("d-m-Y")}}</span>
        <br>
        <span style="font-size:26px;text-align:center;margin-left:15px;font-weight:bold;">RECIBIDO</span>
    </div>



    <div style="float:left;position:absolute;top:650;">
        <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(100)->generate('http://'.$_SERVER['HTTP_HOST'].'/recibo/detalleRecibo/'.$recibo->id)) }} ">

    </div>    

    <div style="float:right;position: absolute;top:650;">
        MERCED N° 280, PISO 6
        <br>
        STGO. CENTRO
        <br>
        MESA CENTRAL (56 2) 2763 5000
        <br>
        www.acobro.cl
    </div>
@endif

</div>




