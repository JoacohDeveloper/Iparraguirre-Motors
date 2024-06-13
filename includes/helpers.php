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
function implementComp($url = "", $params = [])
{   

    foreach ($params as $key => $value) {
        $$key = $value;
    }
    ob_start();
    $root = str_replace("/public", "/views/componentes/", str_replace("\\", "/", $_SERVER["DOCUMENT_ROOT"]));

    $includeFile = $root . $url;

    include_once $includeFile;

    echo ob_get_clean();
}
