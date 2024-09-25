<?php


namespace Controllers;

use Models\Vehicle;
use Models\VehicleImage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class VehiclesController
{

    public static function agregarVehiculo()
    {
        $errores = [];
        header('Content-Type: application/json; charset=utf-8');

        $vehicle = new vehicle($_POST);
        $errores = $vehicle->validate();
        if (empty($errores)) {
            $result = $vehicle->registrarVehicle();
            if ($result) {
                //procedo a crear las imagenes de ese vehiculo
                $imagenes = [];

                if (!is_null($_FILES['imagen']['name'])) {
                    $totalFiles = count($_FILES['imagen']['name']);
                    for ($i = 0; $i < $totalFiles; $i++) {
                        $fileName = $_FILES['imagen']['name'][$i];
                        $fileTmpName = $_FILES['imagen']['tmp_name'][$i];


                        $dirname = $_SERVER["DOCUMENT_ROOT"] . "/build/src/images/vehicles/";
                        if (!file_exists($dirname)) {
                            mkdir($dirname);
                        }

                        $fileExtArray = explode(".", $fileName);
                        $fileExt = $fileExtArray[count($fileExtArray) - 1];


                        $fileHash = md5($fileName . rand(0, 50) . gmdate("dd-MM-YYYY"));

                        $nuevaImagen = $fileHash . ".$fileExt";

                        $nuevaImagen = str_replace("\\", "/", $nuevaImagen);


                        $x = str_replace("\\", "/", $dirname . $nuevaImagen);


                        $manager = new ImageManager(new Driver());


                        $res = move_uploaded_file($fileTmpName, $x);

                        $imagen = $manager->read($x);
                        $imagen->resize(1280, 720);
                        $imagen->save(quality: 70);

                        $fileImg = new VehicleImage($result, $x, "vehicle img");

                        $fileImg->create();

                        $imagenes[] = $fileImg;
                    }
                }
                echo json_encode(["message" => "succesfuly"]);
            } else {
                $vehicle->delete();
                echo json_encode(["error" => "Ha ocurrido un error"]);
            }
        } else {
            echo json_encode(["message" => "error", "errores" => $errores]);
        }
        exit;
    }

    public static function getOneVehicle()
    {
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

    public static function modificarVehicle()
    {
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

    public static function discountVehicle() {
        $errores = [];
        header('Content-Type: application/json; charset=utf-8');
        $vehicle = new vehicle($_POST);
        if (empty($errores)) {
            $result = $vehicle->addDiscountVehicle();
            if ($result) {
                echo json_encode(["message" => "successfuly"]);
            } else {
                echo json_encode(["error" => "Ha ocurrido un error"]);
            }
        } else {
            echo json_encode(["message" => "error", "errores" => $errores]);
        }
        exit;
    }

    public static function removeDiscountVehicle() {
        $errores = [];
        header('Content-Type: application/json; charset=utf-8');
        $vehicle = new vehicle($_POST);
        if (empty($errores)) {
            $result = $vehicle->removeDiscountVehicle();
            if ($result) {
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
