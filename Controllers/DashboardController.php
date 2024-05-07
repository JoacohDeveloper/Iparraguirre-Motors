<?php

namespace Controllers;

use Router\Router;


abstract class DashboardController
{

    public static function index(Router $router)
    {

        $router->render("dashboard/index", [
            "styles" => ["dashboard/index"],
            "title" => "Dashboard"
        ]);
    }

    public static function agregarVehiculo(Router $router)
    {






        $router->render("dashboard/vehicles/add-vehicle", [
            "styles" => ["dashboard/vehicles/vehicle-form"],
            "title" => "Dashboard | Agregar Vehiculo",
            "description" => "Pagina de dashboard Iparraguirre Motors",
            "scripts" => ["lol"]
        ]);
    }
}
