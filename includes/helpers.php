<?php

function logg($code)
{
    echo "<pre>";
    var_dump($code);
    echo "</pre>";
    exit;
}

function sanitize($value)
{
    return htmlspecialchars($value);
}


function implementFile($url = "", $args = null)
{
    $root = str_replace("/public", "", str_replace("\\", "/", $_SERVER["DOCUMENT_ROOT"]));

    $includeFile = $root . $url;

    return $includeFile;
}

function implementComp($url = "", $params = []) {
    $serverRoot = $_SERVER["DOCUMENT_ROOT"];
    $lastPublicPos = strrpos($serverRoot, '/public');

    if ($lastPublicPos !== false) {
        $pathWithoutLastPublic = substr($serverRoot, 0, $lastPublicPos);
    }

    foreach ($params as $key => $value) {
        $$key = $value;
    }

    ob_start();

    /* Inicio: Codigo para localhost */
    //$root = str_replace("/public", "/views/componentes/", str_replace("\\", "/", $serverRoot));
    //$includeFile = $root . $url;
    //include_once $includeFile;
    /* Inicio: Codigo para localhost */


    /* Inicio: Codigo para web */
    $root = str_replace("\\", "/", $pathWithoutLastPublic . "/views/componentes/");
    $filePath = $root . $url;
    include_once $filePath;
    /* Fin: Codigo para web */
  
    echo ob_get_clean();
}
