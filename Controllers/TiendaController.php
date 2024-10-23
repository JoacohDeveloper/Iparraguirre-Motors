<?php

namespace Controllers;

use MVC\Router;
use Models\Product;

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

    public static function vehicles(Router $router)
    {
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

    public static function view(Router $router)
    {

        $uuid = $_GET["product-id"];

        if (isset($uuid) && !is_null($uuid)) {

            $product = Product::get($uuid)[0];
            if (isset($product) && !is_null($product)) {
            } else {
                header("Location: /catalogo/vehiculos");
            }
        }

        $router->render("tienda/products/index", [
            "title" => "Iparraguirre Motors | " . $product->nombre ?? "Product",
            "scripts" => ["tienda/index", "tienda/products/index"],
            "styles" => ["tienda/index", "globals", "tienda/results", "tienda/products/index"]
        ]);
    }
}
