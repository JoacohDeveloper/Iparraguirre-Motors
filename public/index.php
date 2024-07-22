<?php

include "../includes/app.php";
include_once "autoload.php";


// use Router\Router;

use Controllers\AuthenticationController;
use Controllers\DashboardController;
use \Controllers\HomePageController;
use Controllers\TiendaController;
use Controllers\VehiclesController;
use Controllers\CustomerController;
use Controllers\InformationController;
use \Router\Router;
use Controllers\VehicleRestController;

//echo phpinfo();

$router = new Router();


//Index
$router->get("/", [HomePageController::class, "index"]);

//ContactUs

$router->post("/contact", [InformationController::class, "contactUs"]);
$router->get("/contact", [InformationController::class, "contactUs"]);

//Customer auth
$router->get("/login", [CustomerController::class, "login"]);
$router->post("/login", [CustomerController::class, "login"]);
$router->get("/register", [CustomerController::class, "register"]);
$router->post("/register", [CustomerController::class, "register"]);

//Admin auth
$router->get("/dashboard/login", [AuthenticationController::class, "login"]);

$router->post("/dashboard/login", [AuthenticationController::class, "login"]);


$router->get("/dashboard/register", [AuthenticationController::class, "register"]);

$router->post("/dashboard/register", [AuthenticationController::class, "register"]);


$router->get("/dashboard/recuperar", [AuthenticationController::class, "recuperar"]);

$router->post("/dashboard/recuperar", [AuthenticationController::class, "recuperar"]);

$router->get("/dashboard/verificar", [AuthenticationController::class, "verificar"]);

$router->post("/dashboard/verificar", [AuthenticationController::class, "verificar"]);

$router->get("/logout", [CustomerController::class, "logout"]);
$router->get("/dashboard/logout", [AuthenticationController::class, "logout"]);

//dashboard 

$router->get("/dashboard", [DashboardController::class, "index"]);
$router->get("/dashboard/product-managment", [DashboardController::class, 'productManagment']);

$router->get("/dashboard/agregar-vehiculo", [DashboardController::class, "agregarVehiculo"]);
$router->post("/dashboard/agregar-vehiculo", [DashboardController::class, "agregarVehiculo"]);


//dashboard user settings

$router->get("/dashboard/user-settings", [DashboardController::class, "userSettings"]);

$router->get("/dashboard/user-delete", [DashboardController::class, "userDeleting"]);
$router->post("/dashboard/user-delete", [DashboardController::class, "userDeleting"]);

$router->post("/dashboard/user-settings/usuario/modificar", [AuthenticationController::class, "modificarUsuario"]);

$router->get("/dashboard/user-settings/usuario", [DashboardController::class, "getSettingsFromUserJson"]);

//tienda

$router->get("/tienda", [TiendaController::class, "tienda"]);


//Rest Vehicles

$router->get("/api/v1/vehicles", [VehicleRestController::class, "vehicles"]);



//faq

$router->get("/faq", function () {
    header("Location: /faq.html");
});








$router->comprobarRutas();
