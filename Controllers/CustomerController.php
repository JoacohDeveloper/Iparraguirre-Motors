<?php

namespace Controllers;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Models\Customer;
use Models\Interactions;
use MVC\Router;

abstract class CustomerController
{

    public static function auth(Router $router){
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) header("location: /");


        $router->render("auth/index", [
            "scripts" => ["auth/index"],
            "styles" => ["auth/index"],
            "title" => "Iparraguirre Motors | Authentication",
            "description" => "Ingresa en Iparraguirre Motors!"
        ]);
    }

    public static function login(Router $router){
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) header("location: /");
        $errores = [];
        $campos = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];
            $response = ["message" => "error"];
            $errores = Customer::validarCampos($email, $password);
            if (empty($errores)) {
                $customer = Customer::getCustomer($email);
                header('Content-Type: application/json; charset=utf-8');
                if (isset($customer)) {
                    if ($customer->validarPassword($password)) {
                        if (!$customer->getDeleted()) {
                            if (!$customer->isAdmin()) {
                                $_SESSION["usuario"] = $customer;
                                $_SESSION["loggedIn"] = true;

                                //Creamos una interaccion para notificar el inicio de sesion.
                                $interaction = new Interactions();
                                $interactionResponse = $interaction->createInteraction($customer->getUUID(), "Log In", null, null, null, false);

                                $response = ["message" => "succesfuly", "interaction" => $interactionResponse];
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
    }


    public static function register(Router $router){
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) header("location: /");
        $errores = [];
        $campos = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $customer = new Customer($_POST);
            header('Content-Type: application/json; charset=utf-8');
            $errores = $customer->validate();
            if (empty($errores)) {
                $result = Customer::getCustomer($customer->getEmail());
                if (!isset($result)) {
                    $customer->passwordHash();
                    $customer->gen_uuid();
                    if ($customer->crearCustomer()) {
                        $_SESSION["usuario"] = $customer;
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
            echo json_encode($response);
            exit;
        }
    }

    public static function logout(){
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
            $_SESSION["loggedIn"] = null;
            $_SESSION["usuario"] = null;
            header("location: /auth");
        } else {
            header("location: /auth");
        }
    }

    public static function modificarUsuario()
    {
        $errores = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $customer = $_SESSION["usuario"] ?? null;
            $customerDB = Customer::getCustomer($customer->getEmail());

            if (!isset($customer)) return;

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
            $customerDB->sincronizar($_POST);

            $errores = $customerDB->validate();


            if (empty($errores)) {
                //no hay errores del servidor
                $resultado = $customerDB->actualizarUsuario();
                if ($resultado) {

                    $imagen = $customer->getImagen();


                    if (!str_contains($imagen, "default.jpg")) {
                        unlink(str_replace("\\", "/", $_SERVER["DOCUMENT_ROOT"] . $imagen));
                    }
                    $manager = new ImageManager(new Driver());


                    $res = move_uploaded_file($_FILES["image"]["tmp_name"], $x);

                    $imagen = $manager->read($x);
                    $imagen->resize(600, 600);
                    $imagen->toWebp();
                    $imagen->save(quality: 10);

                    $_SESSION["usuario"] = $customerDB;

                    //Creamos una interaccion para notificar el cambio de datos del perfil
                    $interaction = new Interactions();
                    $interactionResponse = $interaction->createInteraction($customer->getUUID(), "Porfile modification", null, null, null, false);
                    
                    echo json_encode(["message" => "successfuly", "file_uploaded" => $res]);
                    exit;
                }
            }
        }
        echo json_encode(["message" => "error", "errores" => $errores]);

        exit;
    }

    public static function getClients() {
        $result = Customer::getAllCustomers();
        if (!empty($result)) {
            echo json_encode($result);
        } else {
            echo json_encode(["message" => "Ha ocurrido un error"]);
        }
        exit;
    }

    public static function getOtherClient() {
        header('Content-Type: application/json; charset=utf-8');
        $email = $_GET["email"];
        $usuario = Customer::getCustomer($email);

        $usuarioArray = (array) $usuario;

        if ($usuarioArray) {
            $response = ["response" => $usuarioArray];
            echo json_encode($response);
        } else {
            $response = ["response" => "error"];
            echo json_encode($response);
        }
        exit;
    }
}