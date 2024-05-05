<?php

namespace Controllers;

use Router\Router;


abstract class DashboardController
{

    public static function index(Router $router)
    {

        $router->render("dashboard/index", [
            "styles" => ["dashboard/index"]
        ]);
    }
}
