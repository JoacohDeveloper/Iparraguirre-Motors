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

    public static function results(Router $router)
    {

        $busqueda = $_GET["search"] ?? null;

        $router->render("tienda/results", [
            "title" => "Iparraguirre Motors | $busqueda",
            "scripts" => ["tienda/index"],
            "styles" => ["tienda/index", "globals", "tienda/results"]
        ]);
    }
}
