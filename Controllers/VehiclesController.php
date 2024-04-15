<?php


namespace Controllers;

class VehiclesController {


    public static function listado() {

        //aca se buscan los vehiculos de la base de datos y luego se muestran en formato json

    
        //ejemplo

        $vehicles = [
            "vehicle1" => "asas",
            "vehicle2" => "asas",
            "vehicle3" => "asas",
            "vehicle4" => "asas",
            
        ];

        //serializas

        $json = json_encode($vehicles);


        //se muestran

        echo $json;
        exit;

    }
}