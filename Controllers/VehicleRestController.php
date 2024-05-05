<?php


namespace Controllers;

use Models\Vehicle;

abstract class VehicleRestController
{


    public static function vehicles()
    {

        $vehicleId = intval($_GET["id"]) ?? null;
        $vehicleName = $_GET["name"] ?? null;
        $vehicles = Vehicle::getAllVehicles();

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
