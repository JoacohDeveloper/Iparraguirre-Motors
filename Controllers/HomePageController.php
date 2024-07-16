<?php

namespace Controllers;

use \Router\Router;
// $user = new User();

abstract class HomePageController
{
    public static function index(Router $router)
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_bind($socket, 'localhost');

        socket_listen($socket);

        $newc = socket_accept($socket);


        $st = "Hello world";
        socket_write($newc, $st, strlen($st));

        socket_close($newc);
        socket_close($socket);
        $router->render("index", [
            "styles" => ["layout/index"]
        ]);
    }


    public static function droute()
    {
        echo "hello world from a dynamic route";
    }
}
