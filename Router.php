<?php

namespace MVC;


class Router {


    private $GetRoutes = array();
    private $PostRoutes = array();

    function post($url) {
        $this->PostRoutes[] = $url;
    }

    function get($url) {
        $this->GetRoutes[] = $url;
    }
    public function comprobarRutas() {

        $method = $_SERVER["REQUEST_METHOD"];
        $urlActual = $_SERVER["REQUEST_URI"] ?? "/";

        
        if($method == "GET") {
            $this->GetRoutes[] = $urlActual;
        }

    }
}