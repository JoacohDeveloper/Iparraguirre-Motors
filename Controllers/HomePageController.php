<?php

namespace Controllers;
use \Router\Router;
// $user = new User();

class HomePageController
{
    public static function index(Router $router)
    {
        $router->render("index");
    }


}