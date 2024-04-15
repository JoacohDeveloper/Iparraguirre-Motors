<?php


namespace Controllers;

use Models\User;
use \Router\Router;

class AuthenticationController
{

    public static function login(Router $router)
    {
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
            header("location: /");
        }

        $router->render("auth/login");
    }

    public static function register(Router $router)
    {
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
            header("location: /");
        }
        $errores = [];
        $campos = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = new User($_POST);
            $errores = $usuario->validate();

            if (empty($errores)) {
                //no hay errores del servidor
                $result = $usuario->validarEmail();
                if ($usuario->getEmail() == $result) {
                    $errores["already_register"] = "el email ingresado ya fue registrado";
                } else {
                    session_start();
                    $_SESSION["usuario"] = $usuario;
                    $_SESSION["loggedIn"] = true;
                    header("location: /");
                }
            } else {
                $campos = $_POST;
            }
        }

        $router->render("auth/register", [
            "scripts" => ["auth/index"],
            "errores" => $errores,
            "campos" => $campos
        ]);
    }

    public static function recuperar(Router $router)
    {
        //acá el usuario recupera su cuenta en caso de olvidar contraseña.

        $router->render("auth/recuperar");
    }

    public static function verificar(Router $router)
    {
        //acá verificamos el correo electronico del usuario

        $router->render("auth/verificar");
    }

    public static function logout()
    {
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
            $_SESSION["loggedIn"] = null;
            $_SESSION["usuario"] = null;
            header("location: /");
        }
    }
}
