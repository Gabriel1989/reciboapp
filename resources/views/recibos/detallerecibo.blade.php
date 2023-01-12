<span style="float:right;font-weight:bold;">Folio N°{{$recibo->id}}</span>

<h4 style="text-align:center;">RECIBO DE DOCUMENTOS</h4>

<?php 
$readonly = '';
$cierra_recibo = false;
if(trim($recibo->imagen_recibo) != ""){
    $readonly = 'readonly';
    $cierra_recibo = true;
}

?>

<div class="form-group">
    <label for="recibeDe">Se recibe de:</label>
    <input type="text" class="form-control" value="{{$recibo->Cliente->nombre}}" readonly>
</div>

<div class="form-group">
    <label for="recibeDe">Cédula Identidad:</label>
    <input type="text" class="form-control" value="{{$recibo->Cliente->rut."-".$recibo->Cliente->dv}}" readonly>
</div>

<div class="form-group">
    <label for="recibeDe">La cantidad de:</label>
    <input type="text" class="form-control" value="" id="cantidad" {{$readonly}}>
</div>

<div class="form-group">
    <label for="recibeDe">Por concepto de:</label>
    <input type="text" class="form-control" id="concepto" value="<?php echo $recibo->concepto == '0' ? '' : $recibo->concepto; ?>" {{$readonly}}>
</div>


<div class="form-group">
    <label for="recibeDe">A favor de:</label>
    <input type="text" class="form-control" value="{{$recibo->Acreedor->nombre}}" readonly>
</div>

@if(!$cierra_recibo)
<form id="formDocRecep">
<div class="form-group">
    <label for="fileImgRecibo">Carga Documento Recepcionado</label>
    <input type="file" class="form-control-file" name="fileImgRecibo" id="fileImgRecibo" accept=".png,.jpg,.jpeg" style="width:inherit;">
    <input type="hidden" name="id_recibo" value="{{$recibo->id}}">
</div>
<div class="form-group">
      <button type="submit" class="btn btn-warning btnSubeArchivoRecep"><i class="fa fa-upload"></i> Subir Archivo</button>
</div>
</form>
@endif
<div>
<?php
$nro_cuenta = '';
$monto_cheque = 0;
?>
<!--<div class="row">-->
    <!--<div class="col-md-4">-->
    <table id="table_detalle_recibo" style="min-width:1000px;">
        <thead>
            <tr>
            <th style="width: 125px;">N° Cheque</th>
            <th style="width: 125px;">Detalle</th>
            <th style="width: 125px;">Vencimiento</th>
            <th style="width: 125px;">Monto Cheque</th>
            <th style="width: 125px;">N° Cuenta</th>
            <th style="width: 125px;">Banco</th>
            <th style="width: 125px;"></th>
            </tr>
        </thead>
        <tbody id="tbody_detalle_recibo">

    @foreach($detalle_recibo as $detalle)
    <?php 
    $nro_cuenta =  $detalle->nro_cuenta; 
    $monto_cheque = $detalle->monto_cheque;
    ?>
    <tr class='trDetalle' id="detalle_recibo_{{$recibo->id}}_{{$detalle->id}}" data-id='<?php echo $detalle->id; ?>'>
        <td style="width: 125px;"><span id="spanNumCheque_{{$recibo->id}}_{{$detalle->id}}" class="txtDetalleRecibo_{{$recibo->id}}_{{$detalle->id}}">{{$detalle->nro_cheque}}</span> <input style="display:none;width: 125px;" id="txtNumCheque_{{$recibo->id}}_{{$detalle->id}}" class="inputDetalle_{{$recibo->id}}_{{$detalle->id}}" type="text" value="{{$detalle->nro_cheque}}"></td>
        <td style="width: 125px;"><span id="spanDetalle_{{$recibo->id}}_{{$detalle->id}}" class="txtDetalleRecibo_{{$recibo->id}}_{{$detalle->id}}">{{$detalle->detalle}}</span> <input style="display:none;width: 125px;" id="txtDetalle_{{$recibo->id}}_{{$detalle->id}}" class="inputDetalle_{{$recibo->id}}_{{$detalle->id}}" type="text" value="{{$detalle->detalle}}"></td>
        <td style="width: 125px;"><span id="spanVencimiento_{{$recibo->id}}_{{$detalle->id}}" class="txtDetalleRecibo_{{$recibo->id}}_{{$detalle->id}}">{{$detalle->vencimiento}}</span> <input style="display:none;width: 125px;" id="txtVencimiento_{{$recibo->id}}_{{$detalle->id}}" class="inputDetalle_{{$recibo->id}}_{{$detalle->id}} inputEditVencimiento" type="text" value="{{$detalle->vencimiento}}"></td>
        <td style="width: 125px;"><span id="spanMontoCheque_{{$recibo->id}}_{{$detalle->id}}" class="txtDetalleRecibo_{{$recibo->id}}_{{$detalle->id}}">{{$detalle->monto_cheque}}</span> <input style="display:none;width: 125px;" id="txtMontoCheque_{{$recibo->id}}_{{$detalle->id}}" class="inputDetalle_{{$recibo->id}}_{{$detalle->id}}" type="number" value="{{$detalle->monto_cheque}}"></td>
        <td style="width: 125px;"><span id="spanNroCuenta_{{$recibo->id}}_{{$detalle->id}}" class="txtDetalleRecibo_{{$recibo->id}}_{{$detalle->id}}">{{$detalle->nro_cuenta}}</span> <input style="display:none;width: 125px;" id="txtNroCuenta_{{$recibo->id}}_{{$detalle->id}}" class="inputDetalle_{{$recibo->id}}_{{$detalle->id}}" type="number" value="{{$detalle->nro_cuenta}}"></td>
        <td style="width: 125px;"><span id="spanBanco_{{$recibo->id}}_{{$detalle->id}}" class="txtDetalleRecibo_{{$recibo->id}}_{{$detalle->id}}">{{$detalle->banco}}</span> <input style="display:none;width: 125px;" id="txtBanco_{{$recibo->id}}_{{$detalle->id}}" class="inputDetalle_{{$recibo->id}}_{{$detalle->id}}" type="text" value="{{$detalle->banco}}"></td>
        <td style="width: 125px;">@if(!$cierra_recibo) <button class='btn btn-danger btnborrarDetalle' data-id='<?php echo $detalle->id; ?>'><i class='fa fa-trash'></i></button> 
            <button class="btn btn-primary btnEditarDetalle" data-detalle="{{$detalle->id}}" data-recibo="{{$recibo->id}}"><i class="fa fa-pencil"></i></button> @endif</td>
    </tr>

    @endforeach
        </tbody>    
    </table>
    <table style="min-width:902px;">
        @if(!$cierra_recibo)
            <tr>
                <td><input type="text" id="txtNumCheque" style="width: 125px;"></td>
                <td><input type="text" id="txtDetalle" style="width: 125px;"></td>
                <td><input type="text" id="txtVencimiento" style="width: 125px;"></td>
                <td><input type="number" id="txtMontoCheque" style="width: 125px;"data-montoanterior="{{$monto_cheque}}"></td>
                <td><input type="number" id="txtNroCuenta" style="width: 125px;" value="{{$nro_cuenta}}"></td>
                <td><input type="text" id="txtBanco" style="width: 125px;"></td>
                <td><button class="btn btn-success btnAgregaDetalle"><i class="fa fa-plus"></i></button></td>
            </tr>
        @endif
    </table>
</div>    
    <!--</div>-->
<!--</div>-->   
<br>
@if(!$cierra_recibo)
<div class="form-group">
    <button type="button" class="btn btn-primary btnGeneraComprobante">Generar comprobante de recibo</button>
</div>
@endif

<script>

$(document).ready(function(){
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '< Ant',
        nextText: 'Sig >',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };

    $.datepicker.setDefaults($.datepicker.regional['es']);

    $("#txtVencimiento,.inputEditVencimiento").datepicker({
        language: 'es',
        dateFormat: 'yy-mm-dd',
    });

    let varPesos = 0;

    $(".trDetalle").each(function(){
        varPesos += parseFloat($(this).find('td:eq(3)').text());
    });
    var pesos = numeroALetras(varPesos, {
        plural: "PESOS",
        singular: "PESO",
        centPlural: "CENTAVOS",
        centSingular: "CENTAVO"
    });
    $("#cantidad").val("$"+number_format(varPesos,0,",",".") + " (" +pesos+ ")" );
});


$(document).on("click",".btnborrarDetalle",function(){
    let id = $(this).data('id');
    $.ajax({
        url: "{{ route('detalleRecibo.borrar')}}",
        data: {
            id: id,
            _token: "{{csrf_token()}}"
        },
        type: "post",
        success: function(){
            $(".trDetalle[data-id='"+id+"']").remove();

            let varPesos = 0;
            let cantidadCheques = 0;
            let montoAnterior = 0;

            $(".trDetalle").each(function(){
                varPesos += parseFloat($(this).find('td:eq(3)').text());

                if(montoAnterior > parseFloat($(this).find('td:eq(3)').text())){
                    montoAnterior = parseFloat($(this).find('td:eq(3)').text());
                }
                montoAnterior = parseFloat($(this).find('td:eq(3)').text());
                cantidadCheques++;
            });

            if(parseFloat(cantidadCheques) == 0){
                $("#txtMontoCheque").attr('data-montoanterior',0);
                $("#txtMontoCheque").data('montoanterior',0);
            }
            else{
                $("#txtMontoCheque").attr('data-montoanterior',montoAnterior);
                $("#txtMontoCheque").data('montoanterior',montoAnterior);
            }
            

            var pesos = numeroALetras(varPesos, {
                plural: "PESOS",
                singular: "PESO",
                centPlural: "CENTAVOS",
                centSingular: "CENTAVO"
            });

            $("#cantidad").val("$"+number_format(varPesos,0,",",".") + " (" +pesos+ ")" );
        }
    })
});

$(document).on("click",".btnEditarDetalle",function(){

    let montoAnterior = 0;
    $(".trDetalle").each(function(){
                
        if(montoAnterior > parseFloat($(this).find('td:eq(3)').text())){
            montoAnterior = parseFloat($(this).find('td:eq(3)').text());
        }
        montoAnterior = parseFloat($(this).find('td:eq(3)').text());
                
    });
    let detalle_id = $(this).data('detalle');
    let recibo_id = $(this).data('recibo');
    $(".txtDetalleRecibo_"+recibo_id+"_"+detalle_id).fadeToggle();
    $(".inputDetalle_"+recibo_id+"_"+detalle_id).fadeToggle();

    $(this).toggleClass('btnEditarExecute');

});

$(document).on("click",".btnEditarExecute",function(){
    let detalle = $(this).data('detalle');
    let recibo = $(this).data('recibo');

    let num_cheque = $("#txtNumCheque_"+recibo+"_"+detalle).val();
    let txtdetalle = $("#txtDetalle_"+recibo+"_"+detalle).val();
    let vencimiento = $("#txtVencimiento_"+recibo+"_"+detalle).val();
    let monto_cheque = $("#txtMontoCheque_"+recibo+"_"+detalle).val();
    let num_cuenta = $("#txtNroCuenta_"+recibo+"_"+detalle).val();
    let banco = $("#txtBanco_"+recibo+"_"+detalle).val();

    $.ajax({
        url: "{{ route('editarDetalleCheque') }}",
        data: {
            detalle_id : detalle,
            recibo_id : recibo,
            num_cheque : num_cheque,
            txtdetalle : txtdetalle,
            vencimiento : vencimiento,
            monto_cheque : monto_cheque,
            num_cuenta : num_cuenta,
            banco : banco,
            _token : "{{csrf_token()}}"
        },
        type: "post",
        success: function(){
            $("#spanNumCheque_"+recibo+"_"+detalle).text(num_cheque);
            $("#spanDetalle_"+recibo+"_"+detalle).text(txtdetalle);
            $("#spanVencimiento_"+recibo+"_"+detalle).text(vencimiento);
            $("#spanMontoCheque_"+recibo+"_"+detalle).text(monto_cheque);
            $("#spanNroCuenta_"+recibo+"_"+detalle).text(num_cuenta);
            $("#spanBanco_"+recibo+"_"+detalle).text(banco);

            let varPesos = 0;

            $(".trDetalle").each(function(){
                varPesos += parseFloat($(this).find('td:eq(3)').text());
            });

            var pesos = numeroALetras(varPesos, {
                plural: "PESOS",
                singular: "PESO",
                centPlural: "CENTAVOS",
                centSingular: "CENTAVO"
            });

            $("#cantidad").val("$"+number_format(varPesos,0,",",".") + " (" +pesos+ ")" );
        }
    })
})

$(document).on("click",".btnAgregaDetalle",function(){

    let monto_cheque_ultimo = $("#txtMontoCheque").data('montoanterior');
    let montoTotalCheques = 0;
    let cantMaxCheques = 0;
    //cheque a agregar = 1
    let cantCheques = 1;
    //console.log(monto_cheque_ultimo);
    //console.log($("#txtMontoCheque").val());
    if(parseFloat(monto_cheque_ultimo) > 0){
        if(parseFloat($("#txtMontoCheque").val()) > parseFloat(monto_cheque_ultimo))
        {
            Swal.fire(
            '¡Error!',
            'El monto del cheque ingresado no puede ser mayor al que fue ingresado anteriormente',
            'error'
            )   
            return;
        }
    }

    $(".trDetalle").each(function(){
        montoTotalCheques += parseFloat($(this).find('td:eq(3)').text());
        cantCheques++;
    });
    //monto total de cheques hasta el momento + el monto del cheque que quiero agregar ahora
    montoTotalCheques = parseFloat(montoTotalCheques) + parseFloat($("#txtMontoCheque").val());

    //Validación de excepciones
    if(montoTotalCheques >= 400000 && montoTotalCheques <= 1000000){
        cantMaxCheques = 10;
        if(cantCheques > cantMaxCheques){
            Swal.fire(
            '¡Error!',
            'Ha sobrepasado el máximo de cheques permitido, debe solicitar una excepción',
            'error'
            )   
            return;
        }
    }

    if(montoTotalCheques >= 1000001 && montoTotalCheques <= 3000000){
        cantMaxCheques = 12;
        if(cantCheques > cantMaxCheques){
            Swal.fire(
            '¡Error!',
            'Ha sobrepasado el máximo de cheques permitido, debe solicitar una excepción',
            'error'
            )   
            return;
        }
    }

    if(montoTotalCheques >= 3000001 && montoTotalCheques <= 6000000){
        cantMaxCheques = 15;
        if(cantCheques > cantMaxCheques){
            Swal.fire(
            '¡Error!',
            'Ha sobrepasado el máximo de cheques permitido, debe solicitar una excepción',
            'error'
            )   
            return;
        }
    }

    if(montoTotalCheques >= 6000001 && montoTotalCheques <= 9000000){
        cantMaxCheques = 20;
        if(cantCheques > cantMaxCheques){
            Swal.fire(
            '¡Error!',
            'Ha sobrepasado el máximo de cheques permitido, debe solicitar una excepción',
            'error'
            )   
            return;
        }
    }

    if(montoTotalCheques >= 9000001){
        cantMaxCheques = 24;
        if(cantCheques > cantMaxCheques){
            Swal.fire(
            '¡Error!',
            'Ha sobrepasado el máximo de cheques permitido, debe solicitar una excepción',
            'error'
            )   
            return;
        }
    }


    $.ajax({
        url: "{{ route('detalleRecibo.insertar') }}",
        type: "post",
        data: {
            num_cheque: $("#txtNumCheque").val(),
            detalle: $("#txtDetalle").val(),
            vencimiento : $("#txtVencimiento").val(),
            monto_cheque: $("#txtMontoCheque").val(),
            nro_cuenta : $("#txtNroCuenta").val(),
            banco: $("#txtBanco").val(),
            id_recibo: "{{$recibo->id}}",
            _token: "{{csrf_token()}}"
        },
        success: function(data){
            if(data.indexOf("ERROR", 0) != -1){
                Swal.fire(
                '¡Error!',
                data,
                'error'
                )   
            }
            else{
                let html = "<tr class='trDetalle' data-id='"+data+"'>"+
                "<td style='width: 125px;'><span id='spanNumCheque_{{$recibo->id}}_"+data+"' class='txtDetalleRecibo_{{$recibo->id}}_"+data+"'>"+$("#txtNumCheque").val()+"</span> <input style='display:none;width: 125px;' id='txtNumCheque_{{$recibo->id}}_"+data+"' class='inputDetalle_{{$recibo->id}}_"+data+"' type='text' value='"+$("#txtNumCheque").val()+"'></td>"+
                "<td style='width: 125px;'><span id='spanDetalle_{{$recibo->id}}_"+data+"' class='txtDetalleRecibo_{{$recibo->id}}_"+data+"'>"+$("#txtDetalle").val()+"</span> <input style='display:none;width: 125px;' id='txtDetalle_{{$recibo->id}}_"+data+"' class='inputDetalle_{{$recibo->id}}_"+data+"' type='text' value='"+$("#txtDetalle").val()+"'></td>"+
                "<td style='width: 125px;'><span id='spanVencimiento_{{$recibo->id}}_"+data+"' class='txtDetalleRecibo_{{$recibo->id}}_"+data+"'>"+$("#txtVencimiento").val()+"</span> <input style='display:none;width: 125px;' id='txtVencimiento_{{$recibo->id}}_"+data+"' class='inputDetalle_{{$recibo->id}}_"+data+" inputEditVencimiento' type='text' value='"+$("#txtVencimiento").val()+"'></td>"+
                "<td style='width: 125px;'><span id='spanMontoCheque_{{$recibo->id}}_"+data+"' class='txtDetalleRecibo_{{$recibo->id}}_"+data+"'>"+$("#txtMontoCheque").val()+"</span> <input style='display:none;width: 125px;' id='txtMontoCheque_{{$recibo->id}}_"+data+"' class='inputDetalle_{{$recibo->id}}_"+data+"' type='number' value='"+$("#txtMontoCheque").val()+"'></td>"+
                "<td style='width: 125px;'><span id='spanNroCuenta_{{$recibo->id}}_"+data+"' class='txtDetalleRecibo_{{$recibo->id}}_"+data+"'>"+$("#txtNroCuenta").val()+"</span> <input style='display:none;width: 125px;' id='txtNroCuenta_{{$recibo->id}}_"+data+"' class='inputDetalle_{{$recibo->id}}_"+data+"' type='number' value='"+$("#txtNroCuenta").val()+"'></td>"+
                "<td style='width: 125px;'><span id='spanBanco_{{$recibo->id}}_"+data+"' class='txtDetalleRecibo_{{$recibo->id}}_"+data+"'>"+$("#txtBanco").val()+"</span> <input style='display:none;width: 125px;' id='txtBanco_{{$recibo->id}}_"+data+"' class='inputDetalle_{{$recibo->id}}_"+data+"' type='text' value='"+$("#txtBanco").val()+"'></td>"+
                "<td style='width: 125px;'><button class='btn btn-danger btnborrarDetalle' data-id='"+data+"'><i class='fa fa-trash'></i></button> "+"<button class='btn btn-primary btnEditarDetalle' data-detalle='"+data+"' data-recibo='{{$recibo->id}}'><i class='fa fa-pencil'></i></button>"+"</td>"+
                "</tr>";

                $("#txtNumCheque").val('');
                $("#txtDetalle").val('');
                $("#txtVencimiento").val('');
                $("#txtMontoCheque").attr('data-montoanterior',$("#txtMontoCheque").val());
                $("#txtMontoCheque").data('montoanterior',$("#txtMontoCheque").val());
                //console.log("nuevo monto: "+$("#txtMontoCheque").data('montoanterior'));
                $("#txtMontoCheque").val('');               
                //$("#txtNroCuenta").val('');
                $("#txtBanco").val('');

                $("#tbody_detalle_recibo").append(html);

                let varPesos = 0;

                $(".trDetalle").each(function(){
                    varPesos += parseFloat($(this).find('td:eq(3)').text());
                });

                var pesos = numeroALetras(varPesos, {
                    plural: "PESOS",
                    singular: "PESO",
                    centPlural: "CENTAVOS",
                    centSingular: "CENTAVO"
                });

                $("#cantidad").val("$"+number_format(varPesos,0,",",".") + " (" +pesos+ ")" );

            }
        }
    });
});

$(document).on("click",".btnGeneraComprobante",function(){

    let cantidadCheques = 0;
    $(".trDetalle").each(function(){
        cantidadCheques++;
    });

    if(parseFloat(cantidadCheques) == 0){
        Swal.fire(
            '¡Error!',
            'Debe ingresar al menos un registro de pago al recibo',
            'error'
        )  
        return;
    }


    if($("#concepto").val().trim() == ""){
        Swal.fire(
            '¡Error!',
            'Debe ingresar glosa de concepto para el recibo',
            'error'
        )  
        return;
    }


    $.ajax({
        url: "{{ route('generaComprobanteRecibo')}}",
        type: "post",
        data:{
            concepto : $("#concepto").val().trim(),
            cantidad : $("#cantidad").val().trim(),
            recibo_id : "{{$recibo->id}}",
            _token: "{{csrf_token()}}"
        },
        xhrFields: {
            responseType: 'blob'
        },
        beforeSend: function(){
            $('.ajax-loader').css("visibility", "visible");
        },
        success: function(blob){
            var a = document.createElement('a');
            var url = window.URL.createObjectURL(blob);
            a.href = url;
            a.download = 'folio_recibo_n'+"{{$recibo->id}}"+".pdf";
            document.body.append(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);
        },complete: function(){
            $('.ajax-loader').css("visibility", "hidden");
        }
    })
});

$(document).on("submit","#formDocRecep",function(e){
    e.preventDefault();
    if(confirm("¿Está seguro de subir el comprobante? Después no podrá modificar el recibo")){
        let formData = new FormData(document.getElementById("formDocRecep"));
        formData.append("_token","{{csrf_token()}}");

        $.ajax({
            url: "{{ route('subirArchivoRecepcionado')}}",
            type: "post",
            processData: false,
            contentType: false,
            data: formData,
            success: function(data){
                if(data.indexOf("ERROR", 0) != -1){
                    Swal.fire(
                    '¡Error!',
                    data,
                    'error'
                    )   
                }
                else{
                    Swal.fire(
                    'Listo',
                    'Imagen subida exitosamente',
                    'success'
                    )  
                }
            }
        });
    }
});

number_format = function (number, decimals, dec_point, thousands_sep) {
    number = number.toFixed(decimals);
    var nstr = number.toString();
    nstr += '';
    x = nstr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? dec_point + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1))
        x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

    return x1 + x2;
}
</script>