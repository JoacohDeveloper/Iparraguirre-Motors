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

// echo phpinfo();

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

$router->post("/dashboard/addvehicles", [DashboardController::class, "vehicle"]);
$router->get("/dashboard/addvehicles", [DashboardController::class, "vehicle"]);


//tienda

$router->get("/tienda", [TiendaController::class, "tienda"]);


//Rest Vehicles

$router->get("/api/v1/vehicles", [VehicleRestController::class, "vehicles"]);


$router->comprobarRutas();
