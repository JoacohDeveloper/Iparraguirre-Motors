<?php


namespace Controllers;

use Models\UVehicle;
use \Router\Router;

class VehiclesController
{
    public static function register(Router $router)
    {
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
            header("location: tienda/index");
        } else {
            header("location: auth/login");
        }
        $errores = [];
        $campos = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = new User($_POST);
            $errores = $usuario->validate();
            if (empty($errores)) {
                //no hay errores del servidor
                $result = User::getUser($usuario->getEmail());
                // logg($result);
                if (!isset($result)) {
                    $usuario->passwordHash();
                    $usuario->gen_uuid();
                    if ($usuario->crearUsuario()) {
                        session_start();
                        $_SESSION["usuario"] = $usuario;
                        $_SESSION["loggedIn"] = true;
                        header("location: /");
                    } else {
                        $errores["register"] = "Error al registrar usuario, intenta de nuevo más tarde.";
                    }
                } else {
                    $errores["already_register"] = "El email ingresado ya esta registrado";
                }
            } else {
                $campos = $_POST;
            }
        }
        $router->render("auth/register", [
            "scripts" => ["auth/index"],
            "errores" => $errores,
            "campos" => $campos,
            "title" => "Iparraguirre Motors | Register",
            "description" => "Registrate en Iparraguirre Motors!"
        ]);
    }
}
