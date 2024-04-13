<?php

include "../includes/app.php";
include_once "autoload.php";


// use Router\Router;
use \Controllers\HomePageController;
use \Router\Router;



$router = new Router();


$router->get("/", [HomePageController::class, "index"]);



$router->comprobarRutas();



