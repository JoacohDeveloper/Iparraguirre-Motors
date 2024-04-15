<?php
spl_autoload_register(function ($classname) {
    $file = str_replace("\\", "/", str_replace("\\includes", "/", dirname(__FILE__)) . $classname . ".php");
    if (file_exists($file)) {
        require($file);
    } else {
        echo "no existe";
    }
});
include dirname(__FILE__) . "/helpers.php";
include dirname(__FILE__) . "/config/database.php";

use \Models\ActiveRecord;

$db = dbConnection();

ActiveRecord::setdb($db);
