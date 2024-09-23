

<?php


include_once "../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(str_replace("\public", "", __DIR__));
$dotenv->safeLoad();

include "../includes/app.php";


use Controllers\AuthenticationController;
use Controllers\DashboardController;
use Controllers\HomePageController;
use Controllers\TiendaController;
use Controllers\VehiclesController;
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
// $router->post("/faq", [InformationController::class, "preguntasFrecuentes"]);
// $router->get("/faq", [InformationController::class, "preguntasFrecuentes"]);

//Customer auth
$router->get("/auth", [CustomerController::class, "auth"]);

$router->post("/auth/login", [CustomerController::class, "login"]);
$router->post("/auth/register", [CustomerController::class, "register"]);

//Admin auth
$router->get("/dashboard/login", [AuthenticationController::class, "login"]);

$router->post("/dashboard/login", [AuthenticationController::class, "login"]);


$router->get("/dashboard/register", [AuthenticationController::class, "register"]);

$router->post("/dashboard/register", [AuthenticationController::class, "register"]);


$router->get("/dashboard/recuperar", [AuthenticationController::class, "recuperar"]);

$router->post("/dashboard/recuperar", [AuthenticationController::class, "recuperar"]);

$router->get("/dashboard/verificar", [AuthenticationController::class, "verificar"]);

$router->post("/dashboard/verificar", [AuthenticationController::class, "verificar"]);

$router->post("/dashboard/user-newPassword", [DashboardController::class, "changePassword"]);

$router->get("/settings", [HomePageController::class, "userSettings"]);
$router->post("/settings", [HomePageController::class, "userSettings"]);
$router->get("/logout", [CustomerController::class, "logout"]);
$router->get("/dashboard/logout", [AuthenticationController::class, "logout"]);

//dashboard 

$router->get("/dashboard", [DashboardController::class, "index"]);

$router->post("/dashboard/agregar-vehiculo", [VehiclesController::class, "agregarVehiculo"]);
$router->post("/dashboard/obtener-vehiculo", [VehiclesController::class, "getOneVehicle"]);
$router->post("/dashboard/modificar-vehiculo", [VehiclesController::class, "modificarVehicle"]); 
$router->post("/dashboard/discount-vehiculo", [VehiclesController::class, "discountVehicle"]); 
$router->post("/dashboard/delete-discount-vehiculo", [VehiclesController::class, "removeDiscountVehicle"]);

$router->get("/dashboard/products/vehicle", [ProductController::class, "vehicle"]);
$router->get("/dashboard/products/repuestos", [ProductController::class, "repuestos"]);
$router->get("/dashboard/discounts/vehicle", [ProductController::class, "discountForVehicle"]);
$router->get("/dashboard/discounts/refractions", [ProductController::class, "discountForRefractions"]);


//dashboard user settings

$router->get("/dashboard/user-settings", [DashboardController::class, "userSettings"]);

$router->post("/dashboard/user-delete", [DashboardController::class, "userDeleting"]);

$router->post("/dashboard/user-settings/usuario/modificar", [AuthenticationController::class, "modificarUsuario"]);

$router->get("/dashboard/user-settings/usuario", [DashboardController::class, "getSettingsFromUserJson"]);

//tienda

$router->get("/tienda", [TiendaController::class, "tienda"]);
$router->get("/catalogo/vehiculos", [TiendaController::class, "vehicles"]);


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
