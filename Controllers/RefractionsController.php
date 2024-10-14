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

    public static function modificarRepuesto() {
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
    
            $result = $repuesto->actualizarRepuesto($_POST["id"]);
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
