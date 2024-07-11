<?php

namespace Controllers;

use \Router\Router;


class InformationController {

    public static function contactUs(Router $router) {
        $router->render("information/contact", [
            "title" => "Iparraguirre Motors | Contactanos",
            "styles" => ["information/contactUs"],
            "description" => "Informacion de contacto de Iparraguirre-Motors"
        ]);
    }

}