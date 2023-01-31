<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Recibo extends Model{

    protected $table = 'recibos';
    protected $primaryKey = 'id';

    public function Cliente(){
        return $this->belongsTo('App\Models\Cliente');
    }

    public function Acreedor(){
        return $this->belongsTo('App\Models\Acreedor');
    }

    public function Usuario(){
        return $this->belongsTo('App\Models\User');
    }
}