<?php

namespace Controllers;

use MVC\Router;
// $user = new User();

abstract class HomePageController
{
    public static function index(Router $router)
    {

        $router->render("index", [
            "styles" => ["layout/index"]
        ]);
    }


    public static function droute()
    {
        echo "hello world from a dynamic route";
    }

    public static function userSettings(Router $router){
        if (!isset($_SESSION["usuario"])) header("location: /auth");
        $customer = $_SESSION["usuario"];

        $uuid = $customer->getUUID();
        $fullName = $customer->getFullname();
        $imagen = $customer->getNombreImagen_Url();
        $fullNameExplode = explode(" ", $fullName);
        $firstName = $fullNameExplode[0];
        $lastName = $fullNameExplode[1] ?? "";
        $email = $customer->getEmail();
        $createdAt = $customer->getCreated()->format('d-m-Y H:i:s');
        $updatedAt = $customer->getUpdated()->format('d-m-Y H:i:s');
        if ($updatedAt == $createdAt) $updatedAt = "Never updated";

        if (!isset($uuid)) {
            header("Location: /");
        } else if (!isset($customer)) {
            header("Location: /");
        } else if ($uuid != $customer->getUUID()) header("Location: /");
        
        $router->render("/customerSettings/settings", [
            "styles" => ["customerSettings/index", "globals"],
            "scripts" => ["index", "customerSettings/index"],
            "username" => $customer->getUsername(),
            "fullname" => $fullName,
            "firstname" => $firstName,
            "lastname" => $lastName,
            "email" => $email,
            "imagen" => $imagen,
            "createdAt" => $createdAt,
            "updatedAt" => $updatedAt,
            "title" => "Iparraguirre Motors | Settings",
            "description" => "User settings page for admins in Iparraguirre Motors"
        ]);
    }

    public static function getSettingsFromUserJson(){
        $uuid = $_GET["u"];
        $customer = $_SESSION["usuario"];
        if (!$customer->isAdmin()) {
            $fullName = $customer->getFullname();
            $imagen = $customer->getNombreImagen_Url();
            $fullNameExplode = explode(" ", $fullName);
            $firstName = $fullNameExplode[0];
            unset($fullNameExplode[0]);
            $lastName = join(" ", $fullNameExplode) ?? "";
            $lastName = $fullNameExplode[1] ?? "";
            $email = $customer->getEmail();

            if (!isset($uuid)) {
                echo json_encode(["error" => "Unauthorized"]);
                exit;
            } else if (!isset($customer)) {
                echo json_encode(["error" => "Unauthorized"]);
                exit;
            } else if ($uuid != $customer->getUUID()) {
                echo json_encode(["error" => "Unauthorized"]);
                exit;
            }

            $customer = [
                "username" => $customer->getUsername(),
                "fullname" => $fullName,
                "firstname" => $firstName,
                "lastname" => $lastName,
                "email" => $email,
                "imagen" => $imagen
            ];
            echo json_encode($customer);
        }
        exit;
    }

    public static function userDeleting(){
        $customer = $_SESSION["usuario"];
        $result = null;
    
        if (isset($customer)) {
            if ($customer->getFullName() == $_POST["Nombre"]) {
                if ($customer->validarPassword($_POST["Password"])) {
                    $result = $customer->deleteUser();
                    if ($result) {
                        $_SESSION["loggedIn"] = null;
                        $_SESSION["usuario"] = null;
                        echo json_encode(["message" => "successfuly"]);
                    } else {
                        echo json_encode(["message" => "Ha ocurrido un error"]);
                    }
                } else {
                    echo json_encode(["message" => "La contraseña es incorrecta"]);
                }
            } else {
                echo json_encode(["message" => "El nombre no coincide"]);
            }
        } else {
            echo json_encode(["message" => "Usuario no encontrado"]);
        }
        exit;
    }

    public static function changePassword(){
        $customer = $_SESSION["usuario"];
        $olderPassword = $_POST["olderPassword"];
        $newPassword = $_POST["password"];
        $repeatNewPassword = $_POST["repeatPassword"];
        $result = null;
    
        if (isset($customer)) {
            if ($customer->validarPassword($olderPassword)) {
                if ($newPassword == $repeatNewPassword) {
                    $result = $customer->changePassword($newPassword);
                    if ($result) {
                        $_SESSION["loggedIn"] = null;
                        $_SESSION["usuario"] = null;
                        echo json_encode(["message" => "successfuly"]);
                    } else {
                        echo json_encode(["error" => "Ha ocurrido un error"]);
                    }
                } else {
                    echo json_encode(["error" => "La nueva contraseña no coincide"]);
                }
            } else {
                echo json_encode(["error" => "La contraseña es incorrecta"]);
            }
        } else {
            echo json_encode(["error" => "Usuario no encontrado"]);
        }
        exit;
    }
}
