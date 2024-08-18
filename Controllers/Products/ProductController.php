<?php
/*
* author Joaquín Álvarez
* created on 29-07-2024-00h-31m
* github: https://github.com/JoacohDeveloper
*/

namespace Controllers\Products;

use MVC\Router;

class ProductController
{


    public static function vehicle(Router $router)
    {
        $router->render("/dashboard/products/vehicle", [
            "title" => "Products | Iparraguirre Motors",
            "description" => "Pagina de products del dashboard de Iparraguirre Motors",
            "styles" => ["dashboard/index", "dashboard/aside", "dashboard/products/index", "dashboard/components/buscador", "dashboard/components/index"],
            "scripts" => ["dashboard/index", "dashboard/components/buscador", "dashboard/products/index", "dashboard/components/imageUploader"],
        ]);
    }

    public static function repuestos(Router $router)
    {
        $router->render("/dashboard/products/repuestos", [
            "title" => "Products | Iparraguirre Motors",
            "description" => "Pagina de products del dashboard de Iparraguirre Motors",
            "styles" => ["dashboard/index", "dashboard/aside", "dashboard/products/index", "dashboard/components/buscador", "dashboard/components/index"],
            "scripts" => ["dashboard/index", "dashboard/components/buscador", "dashboard/products/index", "dashboard/components/imageUploader"],
        ]);
    }
}
