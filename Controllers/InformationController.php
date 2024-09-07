<?php

namespace Controllers;

use MVC\Router;


class InformationController
{

    public static function contactUs(Router $router)
    {
        $router->render("information/contact", [
            "title" => "Iparraguirre Motors | Contactanos",
            "styles" => ["information/contactUs"],
            "description" => "Informacion de contacto de Iparraguirre-Motors"
        ]);
    }

    public static function preguntasFrecuentes(Router $router){
        $router->render("information/FAQ", [
            "title" => "Iparraguirre Motors | Preguntas frecuentes",
            "styles" => ["information/faq", "globals"],
            "scripts" => ["faq/index", "/index"],
            "description" => "Preguntas frecuentes de Iparraguirre-Motors"
        ]);
    }
}
