<?php


namespace Controllers;

use Models\Refractions;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class RefractionsController{

    public static function agregarRepuesto() {
        $errores = [];
        header('Content-Type: application/json; charset=utf-8');
    
        $repuesto = new Refractions($_POST);
        $errores = $repuesto->validate();
    
        if (empty($errores)) {
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'][0] === UPLOAD_ERR_OK) {
                $fileName = $_FILES['imagen']['name'][0];
                $fileTmpName = $_FILES['imagen']['tmp_name'][0];
                $dirname = $_SERVER["DOCUMENT_ROOT"] . "/build/src/images/Refractions/";
    
                if (!file_exists($dirname)) {
                    mkdir($dirname, 0755, true);
                }
    
                $fileExtArray = explode(".", $fileName);
                $fileExt = end($fileExtArray);
                $fileHash = md5($fileName . rand(0, 50) . gmdate("d-m-Y"));
                $nuevaImagen = $fileHash . ".$fileExt";
                $nuevaImagen = str_replace("\\", "/", $nuevaImagen);
                $x = str_replace("\\", "/", $dirname . $nuevaImagen);
    
                if (move_uploaded_file($fileTmpName, $x)) {
                    $manager = new ImageManager(new Driver());
                    $imagen = $manager->read($x);
                    $imagen->resize(1280, 720);
                    $imagen->save($x, 70);
    
                    $repuesto->url_img = "/build/src/images/Refractions/" . $nuevaImagen;
                    $repuesto->alt_img = "Imagen del repuesto " . $repuesto->nombre;
                } else {
                    $errores[] = "Error al mover el archivo: $fileName";
                    echo json_encode(["status" => "error", "message" => "Ha ocurrido un error al mover la imagen", "detalles" => $errores]);
                    exit;
                }
            } else {
                $repuesto->url_img = null;
                $repuesto->alt_img = null;
            }
    
            $result = $repuesto->registrarRefractions();
            if ($result['resultado']) {
                echo json_encode(["status" => "success", "message" => "El repuesto y la imagen se han subido exitosamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al registrar el repuesto"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Errores de validación", "errores" => $errores]);
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

                            $fileImg = new VehicleImage($vehicle->id, $x, "vehicle img");
                            $fileImg->create();
                            $imagenes[] = $fileImg;
                        } else {
                            $errores[] = "Error al mover el archivo: $fileName";
                        }
                    }
                }

                echo json_encode(["message" => "successfuly"]);
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
                echo json_encode(["message" => "successfuly"]);
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
