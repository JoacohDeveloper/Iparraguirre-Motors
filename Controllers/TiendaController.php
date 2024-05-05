<?php

namespace Controllers;

use \Router\Router;


class TiendaController
{
    public static function tienda(Router $router)
    {


        $router->render("tienda/index", [
            "title" => "Iparraguirre Motors | Tienda"
        ]);
    }
}
