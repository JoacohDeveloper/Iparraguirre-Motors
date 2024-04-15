<?php

include "../includes/app.php";
include_once "autoload.php";


// use Router\Router;

use Controllers\AuthenticationController;
use \Controllers\HomePageController;
use Controllers\VehiclesController;
use \Router\Router;


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

$router->get("/api/vehicles", [VehiclesController::class, "listado"]);


$router->comprobarRutas();
