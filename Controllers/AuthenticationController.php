<?php


namespace Controllers;

use Models\User;
use \Router\Router;

abstract class AuthenticationController
{

    public static function login(Router $router)
    {
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
            header("location: /");
        }
        $errores = [];
        $campos = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];
            $campos = $_POST;

            $errores = User::validarCampos($email, $password);
            if (empty($errores)) {
                $usuario = User::getUser($email); {
                    if (isset($usuario)) {
                        if ($usuario->validarPassword($password)) {
                            $_SESSION["usuario"] = $usuario;
                            $_SESSION["loggedIn"] = true;
                            header("location: /");
                        }
                        $errores[] = "El usuario o contraseña son incorrectos.";
                    } else {
                        $errores[] = "El usuario o contraseña son incorrectos.";
                    }
                }
            }
        }

        $router->render("auth/login", [
            "scripts" => ["auth/index"],
            "errores" => $errores,
            "campos" => $campos
        ]);
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
        } else {
            header("location: /");
        }
    }
}
