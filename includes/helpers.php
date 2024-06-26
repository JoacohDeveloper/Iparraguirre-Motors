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


<<<<<<< HEAD
function implementFile($url = "", $args = null)
=======
function implementFile($url = "")
>>>>>>> d_changes/add-settings-view
{
    $root = str_replace("/public", "", str_replace("\\", "/", $_SERVER["DOCUMENT_ROOT"]));

    $includeFile = $root . $url;

    return $includeFile;
}
<<<<<<< HEAD
function implementComp($url = "", $params = [])
{   

    foreach ($params as $key => $value) {
        $$key = $value;
    }
    ob_start();
=======
function implementComp($url = "")
{
>>>>>>> d_changes/add-settings-view
    $root = str_replace("/public", "/views/componentes/", str_replace("\\", "/", $_SERVER["DOCUMENT_ROOT"]));

    $includeFile = $root . $url;

<<<<<<< HEAD
    include_once $includeFile;

    echo ob_get_clean();
=======
    return $includeFile;
>>>>>>> d_changes/add-settings-view
}
