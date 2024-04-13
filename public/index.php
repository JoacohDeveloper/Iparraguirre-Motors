<?php

include_once "autoload.php";

use \Models\User;
use Controllers\Layout;

$user = new User();

echo "<pre>";
var_dump($_SERVER);
echo "</pre>";

echo $user->id;


