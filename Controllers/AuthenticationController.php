<?php

namespace Controllers;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Models\Customer;
use Models\User;
use Models\Interactions;
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
                                $response = ["message" => "successfully"];
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

    public static function adminRegister()
    {
        $errores = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            header('Content-Type: application/json; charset=utf-8');

            $username = $_POST['username'];
            $usuario = new User($_POST);

            $defaultPassword = "imotorsadmin" . $username;
            $defaultEmail = $username . "@default.com";
            if (empty($errores)) {
                $result = $usuario->usernameRepeat($username);
                if (!$result) {
                    $usuario->defaultPasswordHash($defaultPassword);
                    $usuario->defaultEmail($defaultEmail);
                    $usuario->gen_uuid();
                    if ($usuario->crearUsuario()) {
                        $response = ["message" => "successfully"];
                        echo json_encode($response);
                        exit;
                    } else {
                        $errores["register"] = "Error al registrar usuario, intenta de nuevo más tarde.";
                        $response["errores"] = $errores;
                    }
                } else {
                    $errores["already_register"] = "Ese numero de documento ya se encuentra registrado";
                    $response["errores"] = $errores;
                }
            } else {
                $response["errores"] = $errores;
            }
            echo json_encode($response);
            exit;
        }
    }

    public static function rootRegist()
    {
        header('Content-Type: application/json; charset=utf-8');
        $masterAccount = new User();
        $result = $masterAccount->masterAccount();

        if ($result) {
            $response = ["message" => "successfully"];
            logg("Todo okey");
        } else {
            $response = ["error" => "Ha ocurrido un error"];
            logg("Ocurrio un error");
        }
        exit;
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

    public static function modificarUsuarioDefault()
    {
        $errores = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = $_SESSION["usuario"] ?? null;
            if (!isset($usuario)) return;

            $usuarioDB = User::getUser($usuario->getEmail());
            $usuarioDB->sincronizar($_POST);

            $errores = $usuarioDB->validate();
            if (empty($errores)) {
                $newPassword = $_POST["password"];
                $resultado = $usuarioDB->actualizarUsuarioDefault($newPassword);
                if ($resultado) {
                    $_SESSION["usuario"] = $usuarioDB;
                    echo json_encode(["message" => "successfully"]);
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
            echo json_encode(["message" => "successfully"]);
            exit;
        }
        echo json_encode(["message" => "error", "errores" => $errores]);
        exit;
    }

    public static function getAdmins()
    {
        $result = User::getAllAdmins();
        if (!empty($result)) {
            echo json_encode($result);
        } else {
            echo json_encode(["message" => "Ha ocurrido un error"]);
        }
        exit;
    }

    public static function getOtherAdmin(Router $router)
    {
        header('Content-Type: application/json; charset=utf-8');
        $email = $_GET["email"];
        $usuario = User::getUser($email);
        $myUser = $_SESSION["usuario"] ?? null;

        if ($myUser == $usuario) {
            $response = ["response" => "MyUser"];
            echo json_encode($response);
        } else {
            $usuarioArray = (array) $usuario;

            if ($usuarioArray) {
                $response = ["response" => $usuarioArray];
                echo json_encode($response);
            } else {
                $response = ["response" => "error"];
                echo json_encode($response);
            }
        }
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


    public static function getSessionLoggedUuid()
    {
        header('Content-Type: application/json; charset=utf-8');
        $usuario = $_SESSION["usuario"];

        if (!$usuario || !isset($usuario) || is_null($usuario)) {
            echo json_encode(["message" => "Unauthorized"]);
        } else {
            if ($usuario instanceof User) {
                echo json_encode(["session_uuid" => $usuario->getUUID()]);
            } else if ($usuario instanceof Customer) {
                echo json_encode(["session_uuid" => $usuario->getUUID()]);
            }
        }
        exit;
    }
}
