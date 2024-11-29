<?php

namespace Controllers\Products;

use MVC\Router;

class ProductController
{


    public static function vehicle(Router $router)
    {
        if (!isset($_SESSION["usuario"])) header("location: /dashboard/login");
        $user = $_SESSION["usuario"];
        if (!$user->isAdmin()) header("location: /noaccess");

        $router->render("/dashboard/products/vehicle", [
            "title" => "Products | Iparraguirre Motors",
            "description" => "Pagina de products del dashboard de Iparraguirre Motors",
            "styles" => ["dashboard/index", "dashboard/aside", "dashboard/products/index", "dashboard/components/buscador", "dashboard/components/index"],
            "scripts" => ["dashboard/index", "dashboard/components/buscador", "dashboard/products/vehicles", "dashboard/components/imageUploader"],
        ]);
    }

    public static function repuestos(Router $router)
    {
        if (!isset($_SESSION["usuario"])) header("location: /dashboard/login");
        $user = $_SESSION["usuario"];
        if (!$user->isAdmin()) header("location: /noaccess");

        $router->render("/dashboard/products/repuestos", [
            "title" => "Products | Iparraguirre Motors",
            "description" => "Pagina de products del dashboard de Iparraguirre Motors",
            "styles" => ["dashboard/index", "dashboard/aside", "dashboard/products/index", "dashboard/components/buscador", "dashboard/components/index"],
            "scripts" => ["dashboard/index", "dashboard/components/refractionsSearch", "dashboard/products/refractions", "dashboard/components/imageUploader"],
        ]);
    }

    public static function discountForVehicle(Router $router){
        if (!isset($_SESSION["usuario"])) header("location: /dashboard/login");
        $user = $_SESSION["usuario"];
        if (!$user->isAdmin()) header("location: /noaccess");

        $router->render("/dashboard/products/discount/vehicle", [
            "title" => "Discounts | Iparraguirre Motors",
            "description" => "Pagina de descuentos del dashboard de Iparraguirre Motors",
            "styles" => ["dashboard/index", "dashboard/aside", "dashboard/products/index", "dashboard/components/buscador", "dashboard/components/index"],
            "scripts" => ["dashboard/index", "dashboard/components/discountsSearch", "dashboard/products/vehicle_discount"],
        ]);
    }

    public static function discountForRefractions(Router $router){
        if (!isset($_SESSION["usuario"])) header("location: /dashboard/login");
        $user = $_SESSION["usuario"];
        if (!$user->isAdmin()) header("location: /noaccess");

        $router->render("/dashboard/products/discount/repuestos", [
            "title" => "Discounts | Iparraguirre Motors",
            "description" => "Pagina de descuentos del dashboard de Iparraguirre Motors",
            "styles" => ["dashboard/index", "dashboard/aside", "dashboard/products/index", "dashboard/components/buscador", "dashboard/components/index"],
            "scripts" => ["dashboard/index", "dashboard/components/discountsSearch", "dashboard/products/discounts"],
        ]);
    }
}
