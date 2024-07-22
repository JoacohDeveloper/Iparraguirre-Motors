<?php

putenv('PORT=3307');
putenv('DB_NAME=db_utu2024');

function dbConnection()
{
    $db = null;
    $port = getenv("PORT");
    $dbname = getenv("DB_NAME");
    $host =  "localhost";
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4;port=$port";
    $options = [
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    $user = "root";
    $password = "";

    try {
        $db = new PDO($dsn, $user, $password, $options);
    } catch (PDOException $th) {
        logg("[MARIADB] ERROR AL CONECTAR LA BASE DE DATOS.");
    } catch (Throwable $th) {
        logg("NO, ERROR.");
    }
    return $db;
}
