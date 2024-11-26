<?php

namespace Controllers;

use MVC\Router;

class InformationController{

    public static function preguntasFrecuentes(Router $router){
        $router->render("faq/index", [
            "title" => "Iparraguirre Motors | Preguntas frecuentes",
            "styles" => ["faq/index", "globals"],
            "scripts" => ["faq/index", "/index"],
            "description" => "Preguntas frecuentes de Iparraguirre-Motors"
        ]);
    }
}
