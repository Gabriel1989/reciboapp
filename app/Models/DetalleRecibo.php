<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DetalleRecibo extends Model{

    protected $table = 'detalle_recibo';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nro_cheque',
        'vencimiento',
        'detalle',
        'monto_cheque',
        'nro_cuenta'
    ];
}