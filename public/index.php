<?php

include_once "../vendor/autoload.php";

/* Inicio: Codigo para web */

// $lastPublicPos = strrpos(__DIR__, '/public');
// if ($lastPublicPos !== false) {
//     $pathWithoutLastPublic = substr(__DIR__, 0, $lastPublicPos);
// }
// $dotenv = Dotenv\Dotenv::createImmutable($pathWithoutLastPublic);
// $dotenv->safeLoad();

/* Fin: Codigo para web */


/* Inicio: Codigo para localhost */

$dotenv = Dotenv\Dotenv::createImmutable(str_replace("\public", "", __DIR__));
$dotenv->safeLoad();

/* Fin: Codigo para localhost */

include "../includes/app.php";


use Controllers\AuthenticationController;
use Controllers\DashboardController;
use Controllers\HomePageController;
use Controllers\TiendaController;
use Controllers\VehiclesController;
use Controllers\Products\ProductController;
use Controllers\CustomerController;
use Controllers\InformationController;
use Controllers\RefractionsController;

use MVC\Router;
use Controllers\VehicleRestController;
use Controllers\RefractionsRestController;

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

$router->get("/dashboard/user/getAll", [AuthenticationController::class, "getAdmins"]);
$router->get("/dashboard/client/getAll", [CustomerController::class, "getClients"]);

$router->get("/dashboard/manageClient", [DashboardController::class, "manageClient"]); 
$router->get("/dashboard/manageClient/getOtherClient", [CustomerController::class, "getOtherClient"]);
$router->get("/dashboard/manageClient/forceDelete", [DashboardController::class, "forcedClientDeleting"]);
$router->get("/dashboard/manageClient/forceActive", [DashboardController::class, "forcedClientActive"]);
$router->get("/dashboard/manageClient/getInteractions", [DashboardController::class, "getInteractionsByUser"]);
$router->get("/dashboard/manageClient/deleteInteraction", [DashboardController::class, "deleteInteraction"]);

$router->get("/dashboard/manageEmployee", [DashboardController::class, "manageAdmin"]); 
$router->post("/dashboard/registAdmin/regist", [AuthenticationController::class, "adminRegister"]);
$router->get("/dashboard/manageEmployee/getOtherAdmin", [AuthenticationController::class, "getOtherAdmin"]);
$router->get("/dashboard/manageEmployee/forceDelete", [DashboardController::class, "forcedUserDeleting"]);
$router->get("/dashboard/manageEmployee/forceActive", [DashboardController::class, "forcedUserActive"]);
$router->get("/dashboard/manageEmployee/forceChangeRol", [DashboardController::class, "forcedUserChangeRol"]); 

$router->post("/customer/user-newPassword", [HomePageController::class, "changePassword"]);
$router->post("/dashboard/user-newPassword", [DashboardController::class, "changePassword"]);

$router->get("/dashboard/user-default-image", [AuthenticationController::class, "eliminarImage"]);
$router->get("/customer/user-default-image", [CustomerController::class, "eliminarImage"]);

$router->get("/settings", [HomePageController::class, "userSettings"]);
$router->post("/settings", [HomePageController::class, "userSettings"]);
$router->get("/logout", [CustomerController::class, "logout"]);
$router->get("/dashboard/logout", [AuthenticationController::class, "logout"]);
$router->get("/dashboard/noaccess", [DashboardController::class, "noAccess"]);

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


$router->get("/dashboard/products/vehicle/preview", [ProductController::class, "vehiclePreview"]);


$router->post("/dashboard/agregar-repuesto", [RefractionsController::class, "agregarRepuesto"]); 
$router->post("/dashboard/modificar-repuesto", [RefractionsController::class, "modificarRepuesto"]); 


//dashboard user settings

$router->get("/dashboard/user-settings", [DashboardController::class, "userSettings"]);

$router->post("/customer/user-delete", [HomePageController::class, "userDeleting"]);
$router->post("/dashboard/user-delete", [DashboardController::class, "userDeleting"]);

$router->post("/customer/customer-settings/customer/modificar", [CustomerController::class, "modificarUsuario"]);
$router->post("/dashboard/user-settings/usuario/modificar", [AuthenticationController::class, "modificarUsuario"]);
$router->post("/dashboard/user-settings/usuario/modificarDefault", [AuthenticationController::class, "modificarUsuarioDefault"]);


$router->get("/customer/user-settings/usuario", [HomePageController::class, "getSettingsFromUserJson"]);
$router->get("/dashboard/user-settings/usuario", [DashboardController::class, "getSettingsFromUserJson"]);

//tienda

$router->get("/catalogo", [TiendaController::class, "tienda"]);
$router->get("/catalogo/vehiculos", [TiendaController::class, "vehicles"]);
$router->get("/catalogo/vehiculosModificados", [TiendaController::class, "customVehicles"]);
$router->get("/catalogo/refraction", [TiendaController::class, "refraction"]);

//Rest Vehicles

$router->get("/api/v1/vehicles", [VehicleRestController::class, "vehicles"]);
$router->get("/api/v1/refractions", [RefractionsRestController::class, "refractions"]);

//faq

$router->get("/faq", function () {
    header("Location: /faq.html");
});


$router->get("/catalogo/product/view", [TiendaController::class, "view"]);

//Pruebas Randoms

//WebSockets

// $router->get("/wss/message", [WebSocketController::class, "index"]);


// $router->get("/wss/server", [WebSocketController::class, "ws"]);



$router->comprobarRutas();
