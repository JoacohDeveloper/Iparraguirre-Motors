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
        $rutasProtegidas = ["/admin/panel"];

        $method = $_SERVER["REQUEST_METHOD"];
        $urlActual = $_SERVER["PATH_INFO"] ?? "/";


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
