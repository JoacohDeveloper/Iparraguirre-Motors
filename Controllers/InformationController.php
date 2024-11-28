<?php

namespace Controllers;

use MVC\Router;

class InformationController{

    public static function preguntasFrecuentes(Router $router){
        if (isset($_SESSION["usuario"])){
            $customer = $_SESSION["usuario"];
            $fullName = $customer->getFullname();
            $email = $customer->getEmail();
            $phone = $customer->getPhone();
        }

        $router->render("faq/index", [
            "title" => "Iparraguirre Motors | Preguntas frecuentes",
            "styles" => ["faq/index", "globals"],
            "scripts" => ["faq/index", "/index"],
            "fullname" => $fullName ?? null,
            "email" => $email ?? null,
            "phone" => $phone ?? null,
            "description" => "Preguntas frecuentes de Iparraguirre-Motors"
        ]);
    }
}
