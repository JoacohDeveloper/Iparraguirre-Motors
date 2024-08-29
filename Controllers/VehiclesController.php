<?php


namespace Controllers;

use Models\Vehicle;

class VehiclesController{

    public static function agregarVehiculo(){
        $errores = [];
        header('Content-Type: application/json; charset=utf-8');
        $vehicle = new vehicle($_POST);
        $errores = $vehicle->validate();
        if (empty($errores)) {
            $result = $vehicle->registrarVehicle();
            if ($result) {
                echo json_encode(["message" => "succesfuly"]);
            } else {
                echo json_encode(["error" => "Ha ocurrido un error"]);
            }
        } else {
            echo json_encode(["message" => "error", "errores" => $errores]);
        }
        exit;
    }

    public static function getOneVehicle(){
        $vehiculoID = $_POST['id'] ?? null;
        header('Content-Type: application/json');
        if ($vehiculoID) {
            $vehiculo = Vehicle::getVehicle($vehiculoID);
            if ($vehiculo) {
                echo json_encode($vehiculo);
            } else {
                echo json_encode(["Error" => "No se ha encontrado el vehiculo"]);
            }
        } else {
            echo json_encode(["Error" => "No se ha proporcionado un ID"]);
        }
        exit;
    }

    public static function modificarVehicle() {
        $errores = [];
        header('Content-Type: application/json; charset=utf-8');
        $vehicle = new vehicle($_POST);
        $errores = $vehicle->validate();
        if (empty($errores)) {
            $success = $vehicle->actualizarVehicle();
            if ($success) {
                echo json_encode(["message" => "successfuly"]);
            } else {
                echo json_encode(["error" => "Ha ocurrido un error"]);
            }
        } else {
            echo json_encode(["message" => "error", "errores" => $errores]);
        }
        exit;
    }
}
