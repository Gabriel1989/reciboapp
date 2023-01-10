
<form id="nuevoReciboForm">
    <div class="form-row">
      <div class="form-group col-md-12">
        <label for="rutCliente">Ingrese rut del Cliente</label>
        <input type="text" class="form-control" id="rutCliente" >
      </div>
    </div>
    <div class="form-group">
      <label for="recibeDe">Se recibe de:</label>
      <input type="text" class="form-control" id="recibeDe" readonly>
    </div>
    <div class="form-group">
        <label for="acreedorSelect">A favor de:</label>
        <select id="acreedorSelect" class="form-control form-control-sm">
            @foreach($acreedores as $acree)
                <option value="{{$acree->id}}">{{$acree->nombre}}</option>
            @endforeach
        </select>
      </div>
    <button type="submit" class="btn btn-primary">Generar Folio</button>
</form>


<script>


$(document).on("submit","#nuevoReciboForm",function(e){
    e.preventDefault();
    const host = "<?php echo $_SERVER['HTTP_HOST']; ?>";
    $.ajax({
        url: "{{route('nuevoReciboStore')}}",
        type: "post",
        data: {
            acreedorSelect : $("#acreedorSelect").val(),
            recibeDe : $("#recibeDe").val(),
            rut: $("#rutCliente").val().replaceAll('.', '').split("-")[0],
            dv: $("#rutCliente").val().replace('.', '').split("-")[1],
            _token: "{{csrf_token()}}"
        },
        success: function (data){
            if(data.indexOf("ERROR", 0) != -1){
                Swal.fire(
                '¡Error!',
                data,
                'error'
                )   
            }
            else{
                window.open("http://"+ host +"/recibo/detalleRecibo/"+data);
            }
        }
    })

});


$(document).on("change","#rutCliente",function(){

    $.ajax({
        url: "{{route('validaRut')}}",
        type:"post",
        data: {
            rut: $(this).val().replaceAll('.', '').split("-")[0],
            dv: $(this).val().replace('.', '').split("-")[1],
            _token: "{{csrf_token()}}"
        },
        success: function(data){
            if(data != "ERROR"){
                $("#recibeDe").val(data);
            }
            else{
                Swal.fire(
                '¡Error!',
                'El rut consultado no se encuentra en la base de datos',
                'error'
                )   
            }
        }

    });


});

$(document).ready(function(){

    $("#rutCliente").rut({
        formatOn: 'keyup',
        minimumLength: 8, 
        validateOn: 'change' 
    });

    $("#rutCliente").rut().on('rutInvalido', function(e) {
            Swal.fire({
                title: 'Rut de cliente',
                text: 'El Rut ingresado no es válido.',
                icon: 'error',
                shadow: true,
                opacity: '0.75',
                addclass: 'stack_top_right',
                type: 'danger',
                stack: {
                    "dir1": "down",
                    "dir2": "left",
                    "push": "top",
                    "spacing1": 10,
                    "spacing2": 10
                },
                width: '290px',
                delay: 2000
            });
        });

});


</script>