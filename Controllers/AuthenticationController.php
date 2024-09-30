<?php

namespace Controllers;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Models\User;
use MVC\Router;


abstract class AuthenticationController
{

    public static function login(Router $router)
    {
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) header("location: /dashboard");
        $errores = [];
        $campos = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];
            $response = ["message" => "error"];
            $errores = User::validarCampos($email, $password);
            if (empty($errores)) {
                $usuario = User::getUser($email);
                header('Content-Type: application/json; charset=utf-8');
                if (isset($usuario)) {
                    if ($usuario->validarPassword($password)) {
                        if (!$usuario->getDeleted()) {
                            if ($usuario->isAdmin()) {
                                $_SESSION["usuario"] = $usuario;
                                $_SESSION["loggedIn"] = true;
                                $response = ["message" => "succesfuly"];
                            } else {
                                $errores[] = "Ha ocurrido un error";
                                $response["errores"] = $errores;
                            }
                        } else {
                            $errores[] = "El usuario no esta registrado";
                            $response["errores"] = $errores;
                        }
                    } else {
                        $errores[] = "El usuario o contraseña son incorrectos.";
                        $response["errores"] = $errores;
                    }
                } else {
                    $errores[] = "El usuario o contraseña son incorrectos.";
                    $response["errores"] = $errores;
                }
            } else {
                $response["errores"] = $errores;
            }
            echo json_encode($response);
            exit;
        }

        $router->render("dashboard/auth/login", [
            "scripts" => ["dashboard/auth/index", "dashboard/auth/login"],
            "styles" => ["dashboard/auth/index"],
            "errores" => $errores,
            "campos" => $campos,
            "title" => "Iparraguirre Motors | Dashboard Login",
            "description" => "Ingresa en Iparraguirre Motors!"
        ]);
    }


    public static function register(Router $router)
    {
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) header("location: /dashboard");
        $errores = [];
        $campos = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = new User($_POST);
            $errores = $usuario->validate();
            if (empty($errores)) {
                $result = User::getUser($usuario->getEmail());
                if (!isset($result)) {
                    $usuario->passwordHash();
                    $usuario->gen_uuid();
                    if ($usuario->crearUsuario()) {
                        $_SESSION["usuario"] = $usuario;
                        $_SESSION["loggedIn"] = true;
                        $response = ["message" => "succesfuly"];
                    } else {
                        $errores["register"] = "Error al registrar usuario, intenta de nuevo más tarde.";
                        $response["errores"] = $errores;
                    }
                } else {
                    $errores["already_register"] = "El email ingresado ya esta registrado";
                    $response["errores"] = $errores;
                }
            } else {
                $response["errores"] = $errores;
            }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response);
            exit;
        }

        $router->render("dashboard/auth/register", [
            "scripts" => ["dashboard/auth/index", "dashboard/auth/register"],
            "styles" => ["dashboard/auth/index"],
            "errores" => $errores,
            "campos" => $campos,
            "title" => "Iparraguirre Motors | Dashboard Register",
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
            $fileExtArray = explode(".", $_FILES["image"]["name"]);
            $fileExt = $fileExtArray[count($fileExtArray) - 1];



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

                    $imagen = $usuario->getImagen();


                    if (!str_contains($imagen, "default.jpg")) {
                        unlink(str_replace("\\", "/", $_SERVER["DOCUMENT_ROOT"] . $imagen));
                    }
                    $manager = new ImageManager(new Driver());


                    $res = move_uploaded_file($_FILES["image"]["tmp_name"], $x);

                    $imagen = $manager->read($x);
                    $imagen->resize(600, 600);
                    $imagen->toWebp();
                    $imagen->save(quality: 10);

                    $_SESSION["usuario"] = $usuarioDB;
                    echo json_encode(["message" => "ok", "file_uploaded" => $res]);
                    exit;
                }
            }
        }
        echo json_encode(["message" => "error", "errores" => $errores]);

        exit;
    }

    public static function eliminarImage()
    {
        $errores = [];

        $usuario = $_SESSION["usuario"] ?? null;
        $usuarioDB = User::getUser($usuario->getEmail());

        if (!isset($usuario)) return;

        $dirname = $_SERVER["DOCUMENT_ROOT"] . "/build/src/images/users/";
        if (!file_exists($dirname)) {
            mkdir($dirname);
        }

        $errores = $usuarioDB->validate();

        if (empty($errores)) {

            $imagen = $usuario->getImagen();
            unlink(str_replace("\\", "/", $_SERVER["DOCUMENT_ROOT"] . $imagen));

            
            $usuario->defaultImage();
            $_SESSION["usuario"] = $usuario;
            echo json_encode(["message" => "successfuly"]);
            exit;
    }
        echo json_encode(["message" => "error", "errores" => $errores]);
        exit;
    }

    public static function logout()
    {
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
            $_SESSION["loggedIn"] = null;
            $_SESSION["usuario"] = null;
            header("location: /dashboard/login");
        } else {
            header("location: /dashboard/login");
        }
    }
}