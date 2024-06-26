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
            $response = ["message" => "error"];
            $errores = User::validarCampos($email, $password);

            if (empty($errores)) {

                $usuario = User::getUser($email);
                if (isset($usuario)) {
                    if ($usuario->validarPassword($password)) {
                        $_SESSION["usuario"] = $usuario;
                        $_SESSION["loggedIn"] = true;
                        $response = ["message" => "succesfuly"];
                        header('Content-Type: application/json; charset=utf-8');
                        echo json_encode($response);
                    } else {
                        $errores[] = "El usuario o contraseña son incorrectos.";
                        $response["errores"] = $errores;
                        header('Content-Type: application/json; charset=utf-8');
                        echo json_encode($response);
                    }
                } else {
                    $errores[] = "El usuario o contraseña son incorrectos.";
                    $response["errores"] = $errores;
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode($response);
                }
            } else {
                $response["errores"] = $errores;
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($response);
            }
            exit;
        }


        $router->render("auth/login", [
            "scripts" => ["auth/index", "auth/login"],
            "styles" => ["auth/index"],
            "errores" => $errores,
            "campos" => $campos,
            "title" => "Iparraguirre Motors | Login",
            "description" => "Ingresa en Iparraguirre Motors!"
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
                if (!isset($result)) {

                    $usuario->passwordHash();
                    $usuario->gen_uuid();
                    if ($usuario->crearUsuario()) {
                        $_SESSION["usuario"] = $usuario;
                        $_SESSION["loggedIn"] = true;
                        $response = ["message" => "succesfuly"];
                        // header('Content-Type: application/json; charset=utf-8');

                    } else {
                        $errores["register"] = "Error al registrar usuario, intenta de nuevo más tarde.";
                        $response["errores"] = $errores;
                        // header('Content-Type: application/json; charset=utf-8');
                        //echo json_encode($response);
                    }
                } else {
                    $errores["already_register"] = "El email ingresado ya esta registrado";
                    $response["errores"] = $errores;
                    // header('Content-Type: application/json; charset=utf-8');
                    //echo json_encode($response);
                }
            } else {
                $response["errores"] = $errores;
                // header('Content-Type: application/json; charset=utf-8');
                //echo json_encode($response);
            }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response);
            exit;
        }

        $router->render("auth/register", [
            "scripts" => ["auth/index", "auth/register"],
            "styles" => ["auth/index"],
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


    public static function modificarUsuario()
    {
<<<<<<< HEAD
        $errores = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $usuario = $_SESSION["usuario"] ?? null;
            $usuarioDB = User::getUser($usuario->getEmail());

            if (!isset($usuario)) return;

            $dirname = $_SERVER["DOCUMENT_ROOT"] . "/build/src/images/users/";
            if (!file_exists($dirname)) {
                mkdir($dirname);
            }

            $filename = $_FILES["image"]["name"];
            $fileExt = explode(".", $_FILES["image"]["name"])[1];
            $fileHash = md5($filename . rand(0, 50) . gmdate("dd-MM-YYYY"));


            $nuevaImagen = $fileHash . ".$fileExt";
            $nuevaImagen = str_replace("\\", "/", $nuevaImagen);
            $x = str_replace("\\", "/", $dirname . $nuevaImagen);
            $_POST["imagen"] = "/build/src/images/users/" . $nuevaImagen;
            $usuarioDB->sincronizar($_POST);

            $errores = $usuarioDB->validate();


            if (empty($errores)) {
                //no hay errores del servidor
                $resultado = $usuarioDB->actualizarUsuario();
                if ($resultado) {

                    unlink(str_replace("\\", "/", $_SERVER["DOCUMENT_ROOT"] . $usuario->getImagen()));

                    $res = move_uploaded_file($_FILES["image"]["tmp_name"], $x);

                    $_SESSION["usuario"] = $usuarioDB;
                    echo json_encode(["message" => "ok", "file_uploaded" => $res]);
                    exit;
                }
            }
        }
        echo json_encode(["message" => "error", "errores" => $errores]);

        exit;
    }





=======
    }

>>>>>>> d_changes/add-settings-view
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
