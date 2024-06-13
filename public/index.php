<?php

include "../includes/app.php";
include_once "autoload.php";


// use Router\Router;

use Controllers\AuthenticationController;
use Controllers\DashboardController;
use \Controllers\HomePageController;
use Controllers\TiendaController;
use Controllers\VehiclesController;
use \Router\Router;
use Controllers\VehicleRestController;

//echo phpinfo();

$router = new Router();


//Index
$router->get("/", [HomePageController::class, "index"]);

//Auth
$router->get("/auth/login", [AuthenticationController::class, "login"]);

$router->post("/auth/login", [AuthenticationController::class, "login"]);


$router->get("/auth/register", [AuthenticationController::class, "register"]);

$router->post("/auth/register", [AuthenticationController::class, "register"]);


$router->get("/auth/recuperar", [AuthenticationController::class, "recuperar"]);

$router->post("/auth/recuperar", [AuthenticationController::class, "recuperar"]);

$router->get("/auth/verificar", [AuthenticationController::class, "verificar"]);

$router->post("/auth/verificar", [AuthenticationController::class, "verificar"]);

$router->get("/logout", [AuthenticationController::class, "logout"]);

//dashboard 

$router->get("/dashboard", [DashboardController::class, "index"]);
$router->get("/dashboard/product-managment", [DashboardController::class, 'productManagment']);

$router->get("/dashboard/agregar-vehiculo", [DashboardController::class, "agregarVehiculo"]);

$router->post("/dashboard/agregar-vehiculo", [DashboardController::class, "agregarVehiculo"]);


//dashboard user settings

$router->get("/dashboard/user-settings", [DashboardController::class, "userSettings"]);

$router->post("/dashboard/user-settings/usuario/modificar", [AuthenticationController::class, "modificarUsuario"]);

$router->get("/dashboard/user-settings/usuario", [DashboardController::class, "getSettingsFromUserJson"]);

//tienda

$router->get("/tienda", [TiendaController::class, "tienda"]);


//Rest Vehicles

$router->get("/api/v1/vehicles", [VehicleRestController::class, "vehicles"]);





$router->comprobarRutas();
