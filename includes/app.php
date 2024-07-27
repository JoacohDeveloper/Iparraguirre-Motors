<?php

include dirname(__FILE__) . "/helpers.php";
include dirname(__FILE__) . "/config/database.php";
include_once "../vendor/autoload.php";

use \Models\ActiveRecord;

$db = dbConnection();

ActiveRecord::setdb($db);
