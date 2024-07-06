<?php


namespace Controllers;

use Models\Vehicle;

abstract class VehicleRestController
{


    public static function vehicles()
    {
        header('Content-Type: application/json;');

        $vehicleId = intval(isset($_GET["id"]) ? $_GET["id"] : 0) ?? null;
        $vehiclePage = intval(isset($_GET["page"]) ? $_GET["page"] : 1) ?? null;


        $vehicleName = $_GET["name"] ?? null;

        if ($vehiclePage) {
            $vehicles = Vehicle::getAllVehiclesByPage($vehiclePage);
        } else {
            $vehicles = Vehicle::getAllVehicles();
        }



        if ($vehicleId != null || $vehicleName != null) {
            foreach ($vehicles as $vehicle) {
                if ($vehicle instanceof Vehicle) {
                    if ($vehicle->id == $vehicleId || $vehicle->nombre == $vehicleName) {
                        $json = json_encode($vehicle);
                    } else {
                        $json = json_encode(["message" => "404"]);
                    }
                }
            }
        } else {
            $json = json_encode($vehicles);
        }
        echo $json;
        exit;
    }
}
