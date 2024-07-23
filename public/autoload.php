<?php



define("ROOT", str_replace("\\public", "/", dirname(__FILE__)));

spl_autoload_register(function ($className) {

    $file = str_replace("\\", "/", ROOT . str_replace("\\", "/", $className) . ".php");
    if (file_exists($file)) {
        require $file;
    } else {
        echo "error al importar $className";
    }
});
