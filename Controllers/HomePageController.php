<?php

namespace Controllers;

use \Router\Router;
// $user = new User();

abstract class HomePageController
{
    public static function index(Router $router)
    {
        $router->render("index", [
            "styles" => ["layout/index"]
        ]);
    }


    public static function droute()
    {
        echo "hello world from a dynamic route";
    }
}
