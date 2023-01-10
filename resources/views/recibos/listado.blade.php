<?php  //dd($_SERVER) ?> 
<table id="datatable_recibos">
    <thead>
        <tr>
        <th>N° Folio</th>
        <th>Cliente</th>
        <th>Acreedor</th>
        <th>Concepto</th>
        <th>Fecha de creación</th>
        <th>Fecha de actualización</th>
        <th>Imagen recibo</th>
        <th>Estado</th>
        <th></th>
        </tr>
    </thead>
    <tbody id="tbody_detalle_recibo">
        @foreach($recibos as $r)
            <tr>
                <td>{{$r->id}}</td>
                <td>{{$r->Cliente->nombre}}</td>
                <td>{{$r->Acreedor->nombre}}</td>
                <td>{{$r->concepto}}</td>
                <td>{{date("d-m-Y H:i:s",strtotime($r->created_at))}}</td>
                <td>{{date("d-m-Y H:i:s",strtotime($r->updated_at))}}</td>
                <td>@if($r->imagen_recibo != "") <button data-src="{{str_replace('public','storage','http://'.$_SERVER['HTTP_HOST'].'/'.$r->imagen_recibo)}}" class="btn btn-success btnVerReciboRecep"><i class='fa fa-eye'></i></button> @endif</td>
                <td><?php echo $r->imagen_recibo == ""? '<i class="btn btn-danger fa fa-times"> No recepcionado</i>' : '<i class="btn btn-success fa fa-check"> Recepcionado</i>'  ?></td>
                <td><a href="/recibo/detalleRecibo/{{$r->id}}" class='btn btn-primary'><i class='fa fa-pencil'></i></a></td>
            </tr>

        @endforeach
    </tbody>
</table>

<div class="modal fade" id="reciboModal" tabindex="-1" role="dialog" aria-labelledby="reciboModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="min-width:450px;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Imagen recibo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <img id="imgReciboModal" style="width: 450px;height:450px;">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>



<script>
    $(document).ready(function(){
        $("#datatable_recibos").DataTable();
    });


    $(document).on("click",".btnVerReciboRecep",function(){
        let src = $(this).data('src');
        $("#imgReciboModal").attr('src',src);
        $("#reciboModal").modal('toggle');

    });
</script>