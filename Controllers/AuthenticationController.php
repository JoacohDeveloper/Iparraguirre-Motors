<?php

namespace Controllers;

use Models\Mail;
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
            header('Content-Type: application/json; charset=utf-8');
            $codigo = substr(md5(rand(rand(10000, 1000000000), rand(10000, 1000000000)) . strtotime(date("dd-mm-YYYY"))), 0, 10);
            $_POST["token"] = $codigo;
            $usuario = new User($_POST);
            $errores = $usuario->validate();
            if (empty($errores)) {
                $result = User::getUser($usuario->getEmail());
                if (!isset($result)) {
                    $usuario->passwordHash();
                    $usuario->gen_uuid();

                    if ($usuario->crearUsuario()) {
                        $body = "
                            <h2>Hola " . $usuario->getFullName() . ".</h2>
                            <p>Gracias por registrarte en Iparraguirre Motors!</p>
                            <h3>Tu código de verificación es <strong>$codigo</strong></h3>
                        ";

                        $mail = new Mail(
                            "contact@iparraguirremotors.com",
                            "Iparraguirre Founder",
                            $usuario->getEmail(),
                            "Verificacion de Correo",
                            $body,
                            "auth"
                        );

                        $mailSend = $mail->send();

                        if (!$mailSend) {
                            $errores["register"] = "Error, correo de verificacion no enviado.";
                            $response["errores"] = $errores;

                            echo json_encode($response);
                            exit;
                        }

                        $_SESSION["usuario"] = $usuario;
                        $_SESSION["loggedIn"] = true;
                        exit;
                    } else {
                        $errores["register"] = "Error al registrar usuario, intenta de nuevo más tarde.";
                        $response["errores"] = $errores;
                        echo json_encode($response);
                        exit;
                    }
                } else {
                    $errores["already_register"] = "El email ingresado ya esta registrado";
                    $response["errores"] = $errores;
                    echo json_encode($response);
                    exit;
                }
            } else {
                $response["errores"] = $errores;
                echo json_encode($response);
                exit;
            }
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
        $user = $_SESSION["usuario"] ?? null;
        if ($user && $user->isVerified()) {
            header("Location: /");
        }
        //acá verificamos el correo electronico del usuario
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            header('Content-Type: application/json; charset=utf-8');



            $userDB = User::getUser($user->getEmail());


            if ($userDB) {

                $codigo = $_POST["codigo"] ?? null;

                if (!$codigo) {
                    echo json_encode(["error" => "el codigo es un campo obligatorio."]);
                    exit;
                }

                if ($userDB->getToken() === $codigo) {

                    $userDB->setToken("");
                    $userDB->setVerified(true);


                    if ($userDB->actualizar($userDB->getUUID())) {
                        $_SESSION["usuario"] = $userDB;
                        echo json_encode(["successfully" => true]);
                        exit;
                    } else {
                        echo json_encode(["successfully" => false]);
                        exit;
                    }
                } else {
                    echo json_encode(["error" => "El codigo de verificacion no es correcto."]);
                    exit;
                }
            } else {
                header("HTTP/1.1 401 Unauthorized");
                echo json_encode(["error" => "unauthorized"]);
                exit;
            }
        }
        $router->render("auth/verification", [
            "title" => "Verificar Cuenta | Iparraguirre Motors",
            "description" => "Pagina para verificar el correo electronico de los usuarios de Iparraguirre Motors.",
            "styles" => ["dashboard/auth/verificar"],
            "scripts" => ["dashboard/auth/verificar"]
        ]);
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
