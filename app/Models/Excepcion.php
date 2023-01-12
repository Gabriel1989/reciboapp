<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Excepcion extends Model{

    protected $table = 'excepciones';
    protected $primaryKey = 'id';

    protected $fillable = [
        'detalle_excepcion'
    ];
}