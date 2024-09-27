<?php


namespace Controllers;

use Models\Vehicle;

abstract class VehicleRestController
{

    public static function create()
    {
        header('Content-Type: application/json;');


        if ($_SERVER["REQUEST_METHOD"] === "POST") {
        }
    }
  
    public static function vehicles()
{
    header('Content-Type: application/json;');

    try {
        $vehicleId = isset($_GET["id"]) ? intval($_GET["id"]) : null;
        $vehiclePage = isset($_GET["page"]) ? intval($_GET["page"]) : null;
        $vehicleName = isset($_GET["name"]) ? trim(strtolower($_GET["name"])) : null;

        if ($vehiclePage && $vehicleName) {
            $vehicles = Vehicle::getAllVehiclesByPage($vehiclePage, $vehicleName);
          foreach($vehicles as $vehicle) {
            if ($vehicle instanceof Vehicle) {

              $vehicle->getAllVehiclesImages();

            }
          }
            echo json_encode($vehicles);
            exit;
        } else if ($vehiclePage) {
            $vehicles = Vehicle::getAllVehiclesByPage($vehiclePage);
        } else {
            $vehicles = Vehicle::getAllVehicles();
        }
        
        
        foreach($vehicles as $vehicle) {
          if ($vehicle instanceof Vehicle) {
            
             $vehicle->getAllVehiclesImages();
            
          }
        }
        if ($vehicleId) {
            foreach ($vehicles as $vehicle) {
                if ($vehicle instanceof Vehicle) {
                    if ($vehicle->id == $vehicleId) {
                        echo json_encode($vehicle);
                        exit;
                    }
                }
            }
            echo json_encode(["message" => "404"]);
            exit;
        } else if ($vehicleName) {
            $resultado = array_filter($vehicles, function ($v) {
                $vehicleName = isset($_GET["name"]) ? trim(strtolower($_GET["name"])) : null;

                if ($v instanceof Vehicle) {
                    if (str_contains(trim(strtolower($v->nombre)), $vehicleName)) {
                        return $v;
                    }
                }
            });

            if (count($resultado) > 0)
                echo json_encode($resultado);
            else
                echo json_encode(["message" => "404"]);
            exit;
        }
       
        echo json_encode($vehicles);
    } catch (Exception $e) {
        echo json_encode(["error" => "Error en la base de datos: " . $e->getMessage()]);
    }
    exit;
}

}
