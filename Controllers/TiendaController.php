<?php

namespace Controllers;

use MVC\Router;


class TiendaController
{
    public static function tienda(Router $router)
    {
        $router->render("tienda/index", [
            "title" => "Iparraguirre Motors | Tienda",
            "scripts" => ["tienda/index"],
            "styles" => ["tienda/index", "globals"]
        ]);
    }

    public static function vehicles(Router $router) {
        $router->render("tienda/vehicle", [
            "title" => "Iparraguirre Motors | Catalogo de vehiculos",
            "scripts" => ["tienda/index"],
            "styles" => ["tienda/results", "globals"]
        ]);
    }

    public static function customVehicles(Router $router) {
        $router->render("tienda/customVehicle", [
            "title" => "Iparraguirre Motors | Catalogo de vehiculos",
            "scripts" => ["tienda/index"],
            "styles" => ["tienda/results", "globals"]
        ]);
    }

    public static function refraction(Router $router) {
        $router->render("tienda/refraction", [
            "title" => "Iparraguirre Motors | Catalogo de repuestos",
            "scripts" => ["tienda/index"],
            "styles" => ["tienda/results", "globals"]
        ]);
    }
}