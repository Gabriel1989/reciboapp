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
    <input type="file" class="form-control-file" name="fileImgRecibo" id="fileImgRecibo" accept=".png,.jpg,.jpeg">
    <input type="hidden" name="id_recibo" value="{{$recibo->id}}">
</div>
<div class="form-group">
      <button type="submit" class="btn btn-warning btnSubeArchivoRecep"><i class="fa fa-upload"></i> Subir Archivo</button>
</div>
</form>
@endif
<!--<div class="row">-->
    <!--<div class="col-md-4">-->
    <table id="table_detalle_recibo" style="min-width:1000px;">
        <thead>
            <tr>
            <th>N° Cheque</th>
            <th>Detalle</th>
            <th>Vencimiento</th>
            <th>Monto Cheque</th>
            <th>N° Cuenta</th>
            <th></th>
            </tr>
        </thead>
        <tbody id="tbody_detalle_recibo">

    @foreach($detalle_recibo as $detalle)
    <tr class='trDetalle' data-id='<?php echo $detalle->id; ?>'>
        <td>{{$detalle->nro_cheque}}</td>
        <td>{{$detalle->detalle}}</td>
        <td>{{$detalle->vencimiento}}</td>
        <td>{{$detalle->monto_cheque}}</td>
        <td>{{$detalle->nro_cuenta}}</td>
        <td>@if(!$cierra_recibo) <button class='btn btn-danger btnborrarDetalle' data-id='<?php echo $detalle->id; ?>'><i class='fa fa-trash'></i></button> @endif</td>
    </tr>

    @endforeach

    @if(!$cierra_recibo)
    <tr>
        <td><input type="text" id="txtNumCheque"></td>
        <td><input type="text" id="txtDetalle"></td>
        <td><input type="text" id="txtVencimiento"></td>
        <td><input type="number" id="txtMontoCheque"></td>
        <td><input type="number" id="txtNroCuenta"></td>
        <td><button class="btn btn-success btnAgregaDetalle"><i class="fa fa-plus"></i></button></td>
    </tr>
    @endif
        </tbody>    
    </table>
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

    $("#txtVencimiento").datepicker({
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

});

$(document).on("click",".btnAgregaDetalle",function(){

    $.ajax({
        url: "{{ route('detalleRecibo.insertar') }}",
        type: "post",
        data: {
            num_cheque: $("#txtNumCheque").val(),
            detalle: $("#txtDetalle").val(),
            vencimiento : $("#txtVencimiento").val(),
            monto_cheque: $("#txtMontoCheque").val(),
            nro_cuenta : $("#txtNroCuenta").val(),
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
                "<td>"+$("#txtNumCheque").val()+"</td>"+
                "<td>"+$("#txtDetalle").val()+"</td>"+
                "<td>"+$("#txtVencimiento").val()+"</td>"+
                "<td>"+$("#txtMontoCheque").val()+"</td>"+
                "<td>"+$("#txtNroCuenta").val()+"</td>"+
                "<td><button class='btn btn-danger btnborrarDetalle' data-id='"+data+"'><i class='fa fa-trash'></i></button>"+"</td>"+
                "</tr>";
                $("#txtNumCheque").val('');
                $("#txtDetalle").val('');
                $("#txtVencimiento").val('');
                $("#txtMontoCheque").val('');
                $("#txtNroCuenta").val('');

                $("#tbody_detalle_recibo").prepend(html);

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