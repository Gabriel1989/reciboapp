<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Acreedor extends Model{

    protected $table = 'acreedores';
    protected $primaryKey = 'id';

    public $timestamps = false;
}