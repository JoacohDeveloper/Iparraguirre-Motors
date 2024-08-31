<?php

namespace Controllers;

use MVC\Router;
use Models\Vehicle;
use Models\User;

abstract class DashboardController
{

    public static function index(Router $router)
    {
        if (!isset($_SESSION["usuario"])) header("location: /dashboard/login");
        $user = $_SESSION["usuario"];
        if (!$user->isAdmin()) {
            header("location: /");
        }

        $router->render("dashboard/index", [
            "styles" => ["dashboard/index", "dashboard/aside"],
            "scripts" => ["dashboard/index"],
            "nodefer" => ["https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"],
            "title" => "Dashboard"
        ]);
    }

    public static function productManagment(Router $router)
    {
        if (!isset($_SESSION["usuario"])) header("location: /dashboard/login");
        $user = $_SESSION["usuario"];
        if (!$user->isAdmin()) {
            header("location: /");
        }

        $router->render("dashboard/product-managment/index", [
            "styles" => ["dashboard/index", "dashboard/aside"],
            "scripts" => ["dashboard/index"],
            "title" => "Dashboard | Product Managment"
        ]);
    }

    public static function userSettings(Router $router)
    {
        if (!isset($_SESSION["usuario"])) header("location: /dashboard/login");
        $uuid = $_GET["u"];
        $usuario = $_SESSION["usuario"];
        if (!$usuario->isAdmin()) {
            header("location: /");
        }

        $fullName = $usuario->getFullname();
        $imagen = $usuario->getNombreImagen_Url();
        $fullNameExplode = explode(" ", $fullName);
        $firstName = $fullNameExplode[0];
        $lastName = $fullNameExplode[1] ?? "";
        $email = $usuario->getEmail();
        $bio = "Soy backend y me encanta programar en HTML";
        $createdAt = $usuario->getCreated()->format('d-m-Y H:i');

        if (!isset($uuid)) {
            header("Location: /dashboard");
        } else if (!isset($usuario)) {
            header("Location: /");
        } else if ($uuid != $usuario->getUUID()) header("Location: /dashboard");

        $router->render("/dashboard/settings/index", [
            "styles" => ["dashboard/index", "dashboard/aside", "dashboard/settings/index"],
            "scripts" => ["dashboard/index", "dashboard/settings/index"],
            "username" => $usuario->getUsername(),
            "fullname" => $fullName,
            "firstname" => $firstName,
            "lastname" => $lastName,
            "email" => $email,
            "imagen" => $imagen,
            "bio" => $bio,
            "createdAt" => $createdAt,
            "title" => "Iparraguirre Motors | Settings",
            "description" => "User settings page for admins in Iparraguirre Motors"

        ]);
    }

    public static function userDeleting(){
        $usuario = $_SESSION["usuario"];
        $result = null;
    
        if (isset($usuario)) {
            if ($usuario->getFullName() == $_POST["Nombre"]) {
                if ($usuario->validarPassword($_POST["Password"])) {
                    $result = $usuario->deleteUser();
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
    
    public static function getSettingsFromUserJson()
    {
        $uuid = $_GET["u"];
        $usuario = $_SESSION["usuario"];

        $fullName = $usuario->getFullname();
        $imagen = $usuario->getNombreImagen_Url();
        $fullNameExplode = explode(" ", $fullName);
        $firstName = $fullNameExplode[0];
        unset($fullNameExplode[0]);
        $lastName = join(" ", $fullNameExplode) ?? "";
        $lastName = $fullNameExplode[1] ?? "";
        $email = $usuario->getEmail();

        if (!isset($uuid)) {
            echo json_encode(["error" => "Unauthorized"]);
            exit;
        } else if (!isset($usuario)) {
            echo json_encode(["error" => "Unauthorized"]);
            exit;
        } else if ($uuid != $usuario->getUUID()) {
            echo json_encode(["error" => "Unauthorized"]);
            exit;
        }

        $user = [
            "username" => $usuario->getUsername(),
            "fullname" => $fullName,
            "firstname" => $firstName,
            "lastname" => $lastName,
            "email" => $email,
            "imagen" => $imagen
        ];

        echo json_encode($user);
        exit;
    }
}
