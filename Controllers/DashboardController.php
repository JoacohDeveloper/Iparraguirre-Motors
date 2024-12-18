<?php

namespace Controllers;

use MVC\Router;
use Models\Vehicle;
use Models\User;
use Models\Customer;
use Models\Interactions;

abstract class DashboardController
{

    public static function index(Router $router)
    {
        if (!isset($_SESSION["usuario"])) header("location: /dashboard/login");
        $user = $_SESSION["usuario"];
        if (!$user->isAdmin()) header("location: /noaccess");
        $isFirstLog = $user->isFirstLog();

        if($isFirstLog){
            $router->render("dashboard/accountManage/defaultAdmin", [
                "styles" => ["dashboard/index", "dashboard/settings/defaultAdmin"],
                "scripts" => ["dashboard/index", "dashboard/settings/defaultAdmin"],
                "title" => "Dashboard"
            ]);
        } else {
            $router->render("dashboard/index", [
                "styles" => ["dashboard/index", "dashboard/aside"],
                "scripts" => ["dashboard/index"],
                "nodefer" => ["https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"],
                "title" => "Dashboard"
            ]);
        }
        
    }

    public static function userSettings(Router $router)
    {
        if (!isset($_SESSION["usuario"])) header("location: /dashboard/login");
        $user = $_SESSION["usuario"];
        if (!$user->isAdmin()) header("location: /noaccess");
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
        $bio = $usuario->getBio() ?? "";
        $userType = $usuario->getUserType();
        $createdAt = $usuario->getCreated()->format('d-m-Y H:i:s');
        $updatedAt = $usuario->getUpdated()->format('d-m-Y H:i:s');
        if ($updatedAt == $createdAt) $updatedAt = "Never updated";

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
            "updatedAt" => $updatedAt,
            "userType" => $userType,
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
                        echo json_encode(["message" => "successfully"]);
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

    public static function forcedUserDeleting() {
        header('Content-Type: application/json; charset=utf-8');
        $uuid = $_GET["uuid"];
        $result = null;
    
        if (isset($uuid)) {
            $result = User::adminForceDeleting($uuid);
            if ($result) {
                echo json_encode(["message" => "successfully"]);
                exit;
            } else {
                echo json_encode(["message" => "error"]);
                exit;
            }
        } else {
            echo json_encode(["message" => "Usuario no encontrado"]);
            exit;
        }
    }

    public static function forcedUserActive() {
        header('Content-Type: application/json; charset=utf-8');
        $uuid = $_GET["uuid"];
        $result = null;
    
        if (isset($uuid)) {
            $result = User::adminForceActiving($uuid);
            if ($result) {
                echo json_encode(["message" => "successfully"]);
                exit;
            } else {
                echo json_encode(["message" => "error"]);
                exit;
            }
        } else {
            echo json_encode(["message" => "Usuario no encontrado"]);
            exit;
        }
    }
    
    public static function forcedUserChangeRol() {
        header('Content-Type: application/json; charset=utf-8');
        $uuid = $_GET["uuid"];
        $rol = $_GET["rol"];
        $result = null;
    
        if (isset($uuid)) {
            $result = User::adminForceChangeRol($uuid, $rol);
            if ($result) {
                echo json_encode(["message" => "successfully"]);
                exit;
            } else {
                echo json_encode(["message" => "error"]);
                exit;
            }
        } else {
            echo json_encode(["message" => "Usuario no encontrado"]);
            exit;
        }
    }

    public static function forcedClientDeleting() {
        header('Content-Type: application/json; charset=utf-8');
        $uuid = $_GET["uuid"];
        $result = null;
    
        if (isset($uuid)) {
            $result = Customer::adminForceDeleting($uuid);
            if ($result) {
                echo json_encode(["message" => "successfully"]);
                exit;
            } else {
                echo json_encode(["message" => "error"]);
                exit;
            }
        } else {
            echo json_encode(["message" => "Usuario no encontrado"]);
            exit;
        }
    }

    public static function forcedClientActive() {
        header('Content-Type: application/json; charset=utf-8');
        $uuid = $_GET["uuid"];
        $result = null;
    
        if (isset($uuid)) {
            $result = Customer::adminForceActiving($uuid);
            if ($result) {
                echo json_encode(["message" => "successfully"]);
                exit;
            } else {
                echo json_encode(["message" => "error"]);
                exit;
            }
        } else {
            echo json_encode(["message" => "Usuario no encontrado"]);
            exit;
        }
    }

    public static function changePassword(){
        $usuario = $_SESSION["usuario"];
        $olderPassword = $_POST["olderPassword"];
        $newPassword = $_POST["password"];
        $repeatNewPassword = $_POST["repeatPassword"];
        $result = null;
    
        if (isset($usuario)) {
            if ($usuario->validarPassword($olderPassword)) {
                if ($newPassword == $repeatNewPassword) {
                    $result = $usuario->changePassword($newPassword);
                    if ($result) {
                        $_SESSION["loggedIn"] = null;
                        $_SESSION["usuario"] = null;
                        echo json_encode(["message" => "successfully"]);
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
    
    public static function getSettingsFromUserJson(){
        $uuid = $_GET["u"];
        $usuario = $_SESSION["usuario"];

        $fullName = $usuario->getFullname();
        $imagen = $usuario->getNombreImagen_Url();
        $fullNameExplode = explode(" ", $fullName);
        $firstName = $fullNameExplode[0];
        unset($fullNameExplode[0]);
        $lastName = join(" ", $fullNameExplode) ?? "";
        $lastName = $fullNameExplode[1] ?? "";
        $bio = $usuario->getBio() ?? "";
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
            "imagen" => $imagen,
            "bio" => $bio
        ];

        echo json_encode($user);
        exit;
    }

    public static function manageAdmin(Router $router){
        if (!isset($_SESSION["usuario"])) header("location: /dashboard/login");
        $user = $_SESSION["usuario"];
        if (!$user->isAdmin()) header("location: /noaccess");

        $router->render("dashboard/accountManage/manageAdmin", [
            "styles" => ["dashboard/index", "dashboard/aside", "dashboard/accountManage/manageAdmin"],
            "scripts" => ["dashboard/index", "dashboard/accountManage/manageAdmin"],
            "title" => "Dashboard"
        ]);
    }

    public static function manageClient(Router $router){
        if (!isset($_SESSION["usuario"])) header("location: /dashboard/login");
        $user = $_SESSION["usuario"];
        if (!$user->isAdmin()) header("location: /noaccess");

        $router->render("dashboard/accountManage/manageClient", [
            "styles" => ["dashboard/index", "dashboard/aside", "dashboard/accountManage/manageClient"],
            "scripts" => ["dashboard/index", "dashboard/accountManage/manageClient"],
            "title" => "Dashboard"
        ]);
    }

    public static function getInteractionsByUser(){
        $user = $_SESSION["usuario"];
        $isEncargado = $user->isEncargado();
        $userUUID = $_GET["uuid"];
        $interaction = new Interactions();
        $response = $interaction->getInteraction($userUUID, $isEncargado);
        if($response){
            echo json_encode(["message" => "successfully", "interactions" => $response]);
        } else if (count($response) == 0){
            echo json_encode(["message" => "successfully", "interactions" => null]);
        } else {
            echo json_encode(["error" => "Ha ocurrido un error"]);
        }
        exit;
    }

    public static function deleteInteraction(){
        $id = $_GET["id"];
        $interaction = new Interactions();
        $response = $interaction->delete($id);
        if($response){
            echo json_encode(["message" => "successfully"]);
        } else if (count($response) == 0){
            echo json_encode(["message" => "successfully"]);
        } else {
            echo json_encode(["error" => "Ha ocurrido un error"]);
        }
        exit;
    }

    public static function noAccess(Router $router){
        header("HTTP/1.1 401 Unauthorized");

        $router->render("dashboard/noaccess", [
            "title" => "Acceso denegado"
        ]);
    }
}