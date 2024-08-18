

<?php


include_once "../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(str_replace("\public", "", __DIR__));
$dotenv->safeLoad();

include "../includes/app.php";


use Controllers\AuthenticationController;
use Controllers\DashboardController;
use Controllers\HomePageController;
use Controllers\TiendaController;
// use Controllers\VehiclesController;
use Controllers\Products\ProductController;
use Controllers\CustomerController;
use Controllers\InformationController;

use MVC\Router;
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

$router->post("/dashboard/agregar-vehiculo", [DashboardController::class, "agregarVehiculo"]);

$router->get("/dashboard/products/vehicle", [ProductController::class, "vehicle"]);
$router->get("/dashboard/products/repuestos", [ProductController::class, "repuestos"]);









//dashboard user settings

$router->get("/dashboard/user-settings", [DashboardController::class, "userSettings"]);

$router->get("/dashboard/user-delete", [DashboardController::class, "userDeleting"]);
$router->post("/dashboard/user-delete", [DashboardController::class, "userDeleting"]);

$router->post("/dashboard/user-settings/usuario/modificar", [AuthenticationController::class, "modificarUsuario"]);

$router->get("/dashboard/user-settings/usuario", [DashboardController::class, "getSettingsFromUserJson"]);

//tienda

$router->get("/tienda", [TiendaController::class, "tienda"]);

$router->get("/tienda/results", [TiendaController::class,  "results"]);


//Rest Vehicles

$router->get("/api/v1/vehicles", [VehicleRestController::class, "vehicles"]);



//faq

$router->get("/faq", function () {
    header("Location: /faq.html");
});


//Pruebas Randoms

//WebSockets

// $router->get("/wss/message", [WebSocketController::class, "index"]);


// $router->get("/wss/server", [WebSocketController::class, "ws"]);



$router->comprobarRutas();
