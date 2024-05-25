<?php

namespace Controllers;

use Router\Router;
use Models\Vehicle;

abstract class DashboardController
{

    public static function index(Router $router)
    {
        $router->render("dashboard/index", [
            "styles" => ["dashboard/index", "dashboard/aside"],
            "scripts" => ["dashboard/index"],
            "title" => "Dashboard"
        ]);
    }

    public static function agregarVehiculo(Router $router)
    {
        $errores = [];
        $campos = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $vehicle = new Vehicle($_POST);
            $errores = $Vehicle->validate();
            if (empty($errores)) {
                if ($vehicle->ingresarVehicle()) {

                    header("location: /dashboard/index");
                } else {
                    $errores["register"] = "Error al registrar usuario, intenta de nuevo más tarde.";
                }
            } else {
                $campos = $_POST;
            }

            $router->render("dashboard/vehicles/add-vehicle", [
                "styles" => ["dashboard/vehicles/vehicle-form"],
                "title" => "Dashboard | Agregar Vehiculo",
                "description" => "Pagina de dashboard Iparraguirre Motors",
                "errors" => $errores,

            ]);
        }
    }
}
