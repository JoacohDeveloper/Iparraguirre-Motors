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


function implementFile($url = "")
{
    $root = str_replace("/public", "", str_replace("\\", "/", $_SERVER["DOCUMENT_ROOT"]));

    $includeFile = $root . $url;

    return $includeFile;
}
function implementComp($url = "")
{
    $root = str_replace("/public", "/views/componentes/", str_replace("\\", "/", $_SERVER["DOCUMENT_ROOT"]));

    $includeFile = $root . $url;

    return $includeFile;
}
