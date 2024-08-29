<?php

namespace Controllers;

use Models\Customer;
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

    public static function login(Router $router)
    {
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
    }


    public static function register(Router $router)
    {
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

    public static function logout()
    {
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
            $_SESSION["loggedIn"] = null;
            $_SESSION["usuario"] = null;
            header("location: /auth");
        } else {
            header("location: /auth");
        }
    }
}
