<?php

namespace Router;

class Router
{

    private $GetRoutes = array();
    private $PostRoutes = array();

    function post($url, $fn)
    {
        $this->PostRoutes[$url] = $fn;
    }

    function get($url, $fn)
    {
        $this->GetRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {


        session_start();
        $rutasProtegidas = ["/dashboard", "/dashboard/user-settings", "/dashboard/user-settings/usuario/modificar", "/dashboard/user-settings/usuario"];
        $adminRoutes = [];
        $apiRoutes = ["/api/v1/vehicles"];

        $method = $_SERVER["REQUEST_METHOD"];
        $urlActual = $_SERVER["PATH_INFO"] ?? "/";

        if (str_ends_with($urlActual, "/") && $urlActual != "/") {
            $urlActual = rtrim($urlActual, "/");
        }

        //validar si el usuario se encuentra en una ruta protegida para ver si esta logeado
        if (in_array($urlActual, $rutasProtegidas)) {

            $loggedIn = $_SESSION["loggedIn"] ?? null;

            if (!isset($loggedIn) || !$loggedIn) {
                //devuelve el usuario a la pagina de inicio con codigo 'Unauthorized'
                header("HTTP/1.1 401 Unauthorized");
                header("location: /");
            }
        } else if (in_array($urlActual, $adminRoutes)) {
            $user = $_SESSION["usuario"] ?? null;
            if (isset($user) && get_class($user) == "User" && !$user->isAdmin) {
                header("HTTP/1.1 401 Unauthorized");
                header("location: /");
            }
        } else if (in_array($urlActual, $apiRoutes)) {
            $token = $_GET["token"] ?? "";
            if ($token != "") {
                if ($token != "9fd4e0080bc6edc9f3c3853b5b1b6ecf") {
                    header("HTTP/1.1 401 Unauthorized");
                    echo json_encode(["message" => "Unathorized"]);
                    exit;
                }
            } else {
                header("HTTP/1.1 401 Unauthorized");
                echo json_encode(["message" => "Unathorized"]);
                exit;
            }
        }

        if ($method == "GET") {
            $fn = $this->GetRoutes[$urlActual] ?? null;
        } else {
            $fn = $this->PostRoutes[$urlActual] ?? null;
        }
        if ($fn) {
            call_user_func($fn, $this);
        } else {
            http_response_code(404);
            return $this->not_found();
        }
    }

    public function render($view, $params = [])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once str_replace("\\Router", "/", __DIR__ . "/views/$view.php");
        $contenido = ob_get_clean();
        include_once str_replace("\\Router", "/", __DIR__ . "/views/layout.php");
    }

    public function not_found()
    {
        ob_start();
        $title = "404 | NOT FOUND";
        include_once str_replace("\\Router", "/", __DIR__ . "/views/not-found.php");
        $contenido = ob_get_clean();
        include_once str_replace("\\Router", "/", __DIR__ . "/views/layout.php");
    }
}
