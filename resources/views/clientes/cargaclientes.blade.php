<h3>Cargar Datos de Clientes</h3>


<form id="formClienteExcel" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="fileExcel">Carga Excel Clientes</label>
      <input type="file" class="form-control-file" name="fileExcel" id="fileExcel" accept=".xlsx">
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Subir Archivo</button>
    </div>
</form>

<script>

$(document).on("submit","#formClienteExcel",function(e){
    e.preventDefault();
    var formData  = new FormData(document.getElementById("formClienteExcel"));
    $.ajax({
        beforeSend: function(){
            $('.ajax-loader').css("visibility", "visible");
        },
        url: '{{route('cargaClientesPost')}}',
        type: 'post',
        processData: false,
        contentType: false,
        data: formData,
        success: function(data){
            Swal.fire(
                'Listo!',
                'Archivo subido exitosamente',
                'success'
            )   
        },
        complete: function(){
            $('.ajax-loader').css("visibility", "hidden");
            $("#fileExcel").val('');
        }
    });
});


</script>