<?php

namespace Controllers;

use Router\Router;
use Models\Vehicle;

abstract class DashboardController
{

    public static function index(Router $router)
    {
        $router->render("dashboard/index", [
            "styles" => ["dashboard/index", "dashboard/aside"],
            "scripts" => ["dashboard/index"],
            "title" => "Dashboard"
        ]);
    }

    public static function productManagment(Router $router)
    {

        $router->render("dashboard/product-managment/index", [
            "styles" => ["dashboard/index", "dashboard/aside"],
            "scripts" => ["dashboard/index"],
            "title" => "Dashboard | Product Managment"
        ]);
    }

    public static function agregarVehiculo(Router $router)
    {
        $errores = [];
        $campos = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $vehicle = new Vehicle($_POST);
            $errores = $vehicle->validate();
            if (empty($errores)) {
                if ($vehicle->registrarVehicle()) {
                    header("location: /dashboard/index");
                } else {
                    $errores["register"] = "Error al registrar usuario, intenta de nuevo más tarde.";
                }
            } else {
                $campos = $_POST;
            }
        }
        $router->render("dashboard/vehicles/add-vehicle", [
            "styles" => ["dashboard/vehicles/vehicle-form", "dashboard/index", "dashboard/aside"],
            "scripts" => ["dashboard/index"],
            "title" => "Dashboard | Agregar Vehiculo",
            "description" => "Pagina de dashboard Iparraguirre Motors",
            "errors" => $errores,
        ]);
    }

    public static function userSettings(Router $router)
    {

        $uuid = $_GET["u"];
        $usuario = $_SESSION["usuario"];
        $fullName = $usuario->getFullname();
        $imagen = $usuario->getNombreImagen_Url();
        $fullNameExplode = explode(" ", $fullName);
        $firstName = $fullNameExplode[0];
        unset($fullNameExplode[0]);
        $lastName = join(" ", $fullNameExplode) ?? "";
        $email = $usuario->getEmail();

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
            "title" => "Iparraguirre Motors | Settings",
            "description" => "User settings page for admins in Iparraguirre Motors"

        ]);
    }

<<<<<<< HEAD
=======
    public static function userSettings(Router $router)
    {

        $uuid = $_GET["u"];
        $usuario = $_SESSION["usuario"];

        $fullName = $usuario->getFullname();
        $imagen = $usuario->getNombreImagen_Url();
        $fullNameExplode = explode(" ", $fullName);
        $firstName = $fullNameExplode[0];
        $lastName = $fullNameExplode[1] ?? "";
        $email = $usuario->getEmail();

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
            "title" => "Iparraguirre Motors | Settings",
            "description" => "User settings page for admins in Iparraguirre Motors"

        ]);
    }

>>>>>>> d_changes/add-settings-view
    public static function getSettingsFromUserJson()
    {
        $uuid = $_GET["u"];
        $usuario = $_SESSION["usuario"];

        $fullName = $usuario->getFullname();
        $imagen = $usuario->getNombreImagen_Url();
        $fullNameExplode = explode(" ", $fullName);
        $firstName = $fullNameExplode[0];
<<<<<<< HEAD
        unset($fullNameExplode[0]);
        $lastName = join(" ", $fullNameExplode) ?? "";
=======
        $lastName = $fullNameExplode[1] ?? "";
>>>>>>> d_changes/add-settings-view
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
