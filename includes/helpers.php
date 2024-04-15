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
