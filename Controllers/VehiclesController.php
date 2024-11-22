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

        // logg($_POST);
        $errores = $vehicle->validate();

        if (empty($errores)) {
            $result = $vehicle->registrarVehicle();

            if ($result) {
                // Procedo a crear las imágenes de ese vehículo
                //logg($result);
                $imagenes = [];

                // Verifica si 'imagen' existe en $_FILES
                if (isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'][0]) && $_FILES['imagen']['error'][0] === UPLOAD_ERR_OK) {
                    $totalFiles = count($_FILES['imagen']['name']);
                    for ($i = 0; $i < $totalFiles; $i++) {
                        $fileName = $_FILES['imagen']['name'][$i];
                        $fileTmpName = $_FILES['imagen']['tmp_name'][$i];

                        $dirname = $_SERVER["DOCUMENT_ROOT"] . "/build/src/images/vehicles/";
                        if (!file_exists($dirname)) {
                            mkdir($dirname, 0755, true);
                        }

                        $fileExtArray = explode(".", $fileName);
                        $fileExt = end($fileExtArray);
                        $fileHash = md5($fileName . rand(0, 50) . gmdate("d-m-Y"));
                        $nuevaImagen = $fileHash . ".$fileExt";
                        $nuevaImagen = str_replace("\\", "/", $nuevaImagen);
                        $x = str_replace("\\", "/", $dirname . $nuevaImagen);

                        $manager = new ImageManager(new Driver());

                        // Mueve el archivo subido
                        if (move_uploaded_file($fileTmpName, $x)) {
                            // Procesa la imagen
                            $imagen = $manager->read($x);
                            $imagen->resize(1280, 720);
                            $imagen->save(quality: 70);

                            $fileImg = new VehicleImage($result, $x, "vehicle img");
                            $fileImg->create();
                            $imagenes[] = $fileImg;
                        } else {
                            $errores[] = "Error al mover el archivo: $fileName";
                        }
                    }
                }

                if (!empty($errores)) {
                    echo json_encode(["status" => "error", "message" => "Ha ocurrido un error", "detalles" => $errores]);
                } else {
                    echo json_encode(["status" => "success", "message" => "Las imágenes se han subido exitosamente."]);
                }
            } else {
                $vehicle->delete();
                echo json_encode(["status" => "error", "message" => "Error al registrar el vehículo"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Errores de validación", "errores" => $errores]);
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
            $success = $vehicle->actualizarVehicle($_POST["id"]);
            if ($success) {
                if (isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'][0]) && $_FILES['imagen']['error'][0] === UPLOAD_ERR_OK) {
                    $totalFiles = count($_FILES['imagen']['name']);
                    for ($i = 0; $i < $totalFiles; $i++) {
                        $fileName = $_FILES['imagen']['name'][$i];
                        $fileTmpName = $_FILES['imagen']['tmp_name'][$i];

                        $dirname = $_SERVER["DOCUMENT_ROOT"] . "/build/src/images/vehicles/";
                        if (!file_exists($dirname)) {
                            mkdir($dirname, 0755, true);
                        }

                        $fileExtArray = explode(".", $fileName);
                        $fileExt = end($fileExtArray);
                        $fileHash = md5($fileName . rand(0, 50) . gmdate("d-m-Y"));
                        $nuevaImagen = $fileHash . ".$fileExt";
                        $nuevaImagen = str_replace("\\", "/", $nuevaImagen);
                        $x = str_replace("\\", "/", $dirname . $nuevaImagen);

                        $manager = new ImageManager(new Driver());

                        // Mueve el archivo subido
                        if (move_uploaded_file($fileTmpName, $x)) {
                            // Procesa la imagen
                            $imagen = $manager->read($x);
                            $imagen->resize(1280, 720);
                            $imagen->save(quality: 70);

                            $fileImg = new VehicleImage($vehicle->vehicle_id, $x, "vehicle img");
                            $fileImg->create();
                            $imagenes[] = $fileImg;
                        } else {
                            $errores[] = "Error al mover el archivo: $fileName";
                        }
                    }
                }

                echo json_encode(["message" => "successfully"]);
            } else {
                echo json_encode(["error" => "Ha ocurrido un error"]);
            }
        } else {
            echo json_encode(["message" => "error", "errores" => $errores]);
        }
        exit;
    }

    public static function discountVehicle()
    {
        $errores = [];
        header('Content-Type: application/json; charset=utf-8');
        $vehicle = new vehicle($_POST);
        if (empty($errores)) {
            $result = $vehicle->addDiscountVehicle();
            if ($result) {
                echo json_encode(["message" => "successfully"]);
            } else {
                echo json_encode(["error" => "Ha ocurrido un error"]);
            }
        } else {
            echo json_encode(["message" => "error", "errores" => $errores]);
        }
        exit;
    }

    public static function removeDiscountVehicle()
    {
        $errores = [];
        header('Content-Type: application/json; charset=utf-8');
        $vehicle = new vehicle($_POST);
        if (empty($errores)) {
            $result = $vehicle->removeDiscountVehicle();
            if ($result) {
                echo json_encode(["message" => "successfully"]);
            } else {
                echo json_encode(["error" => "Ha ocurrido un error"]);
            }
        } else {
            echo json_encode(["message" => "error", "errores" => $errores]);
        }
        exit;
    }
}
