<?php

namespace App\Imports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportCliente implements ToModel{

    public function model(array $row){
        //Saltando registros que tengan el texto "rut"
        if (trim(strtolower($row[0])) != "rut") {
            //Saltando registros que tengan el texto "rut cliente"
            if (trim(strtolower($row[0])) != "rut cliente") {
                return new Cliente([
                    'rut' => trim($row[0]),
                    'dv' => trim($row[1]),
                    'nombre' => trim($row[2]),
                    'cartera' => trim($row[3])
                ]);
            }
        }
    }
}









