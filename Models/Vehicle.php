<?php

namespace Models;

use Models\ActiveRecord;
use JsonSerializable;
use PDOException;
use PDO;
use DateTime;

class Vehicle extends ActiveRecord
{
    protected static $tabla = "Vehicle";
    protected static $columnasdb = [
        "id",
        "descripcion",
        "nombre",
        "categoria",
        "modelo",
        "fabricante",
        "year",
        "color",
        /*"url_img",
        "description_img",*/
        "matricula",
        "transmision",
        "tipo_carroceria",
        "frenos_abs",
        "airbag",
        "traccion",
        "direccion",
        "control_estabilidad",
        "puertas",
        "tipo_combustible",
        "precio",
        "discount",
        "discount_type",
        "velocidad_max",
        "zero_to_houndred",
        "peso",
        "kilometros",
        "caballos_potencia",
        "createdAt",
        "updatedAt"
    ];

    // public function jsonSerialize()
    // {
    //     return (object) get_object_vars($this);
    // }

    public $id, $nombre, $categoria, $descripcion, $modelo, $fabricante, $year, $color, /*$url_img, $description_img,*/ $matricula, $transmision, $tipo_carroceria, $frenos_abs,
        $airbag, $traccion, $direccion, $control_estabilidad, $puertas, $tipo_combustible, $precio, $discount, $discount_type, $velocidad_max, $zero_to_houndred,
        $peso, $kilometros, $caballos_potencia, $createdAt, $updatedAt;


    public $vehicleImages = [];


    public function getAllVehiclesImages()
    {
        try {
            $query = "select * from vehicle_img where vehicle_id = " . $this->id;
            $stmt = static::$db->prepare($query);
            $stmt->execute();

            while ($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->vehicleImages[] = ["url" => $registro["url"], "alt" => $registro["alt"]];
            }
        } catch (\Throwable $th) {
            logg("Error al cargar imagenes");
        }
    }

    function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->categoria = $args["categoria"] ?? "";
        $this->descripcion = $args["descripcion"] ?? "";
        $this->modelo = $args["modelo"] ?? "";
        $this->fabricante = $args["fabricante"] ?? "";
        $this->year = $args["year"] ?? "";
        $this->color = $args["color"] ?? "";
        $this->vehicleImages = $args["imagen"] ?? [];
        $this->matricula = $args["matricula"] ?? "";
        $this->transmision = $args["tipo_transmision"] ?? "";
        $this->tipo_carroceria = $args["tipo_carroceria"] ?? "";
        $this->frenos_abs = $args["frenos_abs"] ?? "";
        $this->airbag = $args["airbag"] ?? "";
        $this->traccion = $args["traccion"] ?? "";
        $this->direccion = $args["direccion"] ?? "";
        $this->control_estabilidad = $args["control_estabilidad"] ?? "";
        $this->puertas = $args["puertas"] ?? "";
        $this->tipo_combustible = $args["tipo_combustible"] ?? "";
        $this->precio = $args["precio"] ?? "";
        $this->discount = isset($args["descuento"]) && is_numeric($args["descuento"]) ? $args["descuento"] : 0;
        $this->discount_type = $args["type"] ?? "";
        $this->velocidad_max = $args["velocidad_max"] ?? "";
        $this->zero_to_houndred = $args["zero_to_houndred"] ?? "";
        $this->peso = $args["peso"] ?? "";
        $this->kilometros = $args["kilometros"] ?? "";
        $this->caballos_potencia = $args["caballos_fuerza"] ?? "";
        $this->createdAt = $this->createdAt ? $this->createdAt->format('Y-m-d H:i:s') : date("Y-m-d H:i:s");
        $this->updatedAt = $this->updatedAt ? $this->updatedAt->format('Y-m-d H:i:s') : date("Y-m-d H:i:s");
    }

    public static function getAllVehicles()
    {
        $vehicle = new self();
        return $vehicle->getAll();
    }

    public function delete()
    {
        $query = "DELETE FROM Vehicle WHERE id = " . $this->id;
        $result = self::consultarSQL($query);

        if ($result) return 1;
        return 0;
    }

    public static function getAllVehiclesByPage($page = 1, $vehicleName = null)
    {
        $inicio = 0;
        $fin = 10;
        if ($page > 1) {
            $inicio =  ($page - 1) * 10;
        }
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY CreatedAt DESC LIMIT $inicio, $fin";

        if ($vehicleName) {
            $query = "SELECT * FROM " . static::$tabla . " WHERE nombre LIKE '%$vehicleName%' ORDER BY CreatedAt DESC LIMIT $inicio, $fin";
        }

        $resultado = self::consultarSQL($query);

        return $resultado;
    }


    public function validate()
    {
        $errors = [];

        if (empty($this->nombre)) {
            $errors["nombre"] = "El campo nombre es obligatorio.";
        }
        if ($this->categoria == "") {
            $errors["categoria"] = "El campo categoria es obligatorio.";
        }
        if (empty($this->descripcion)) {
            $errors["descripcion"] = "El campo descripcion es obligatorio.";
        }
        if (empty($this->modelo)) {
            $errors["modelo"] = "El campo modelo es obligatorio.";
        }
        if (empty($this->fabricante)) {
            $errors["fabricante"] = "El campo fabricante es obligatorio.";
        }
        if (empty($this->year)) {
            $errors["year"] = "El campo año es obligatorio.";
        }
        if (empty($this->color)) {
            $errors["color"] = "El campo color es obligatorio.";
        }
        if (empty($this->matricula)) {
            $errors["matricula"] = "El campo matricula es obligatorio.";
        }
        if ($this->transmision == "") {
            $errors["transmision"] = "El campo transmision es obligatorio.";
        }
        if ($this->tipo_carroceria == "") {
            $errors["tipo_carroceria"] = "El campo tipo de carroceria es obligatorio.";
        }
        if ($this->frenos_abs == "") {
            $errors["frenos_abs"] = "El campo tipo de carroceria es obligatorio.";
        }
        if ($this->airbag == "") {
            $errors["airbag"] = "El campo tipo de carroceria es obligatorio.";
        }
        if (empty($this->traccion)) {
            $errors["traccion"] = "El campo traccion es obligatorio.";
        }
        if (empty($this->direccion)) {
            $errors["direccion"] = "El campo direccion es obligatorio.";
        }
        if ($this->control_estabilidad == "") {
            $errors["control_estabilidad"] = "El campo control de estabilidad es obligatorio.";
        }
        if (empty($this->puertas)) {
            $errors["puertas"] = "El campo numero de puertas es obligatorio.";
        }
        if (empty($this->tipo_combustible)) {
            $errors["tipo_combustible"] = "El campo tipo de combustible es obligatorio.";
        }
        if (empty($this->precio)) {
            $errors["precio"] = "El campo precio es obligatorio.";
        }
        if (empty($this->velocidad_max)) {
            $errors["velocidad"] = "El campo velocidad maxima es obligatorio.";
        }
        if (empty($this->zero_to_houndred)) {
            $errors["nombre"] = "El campo nombre es obligatorio.";
        }
        if (empty($this->peso)) {
            $errors["peso"] = "El campo peso del vehiculo es obligatorio.";
        }
        if (empty($this->kilometros)) {
            $errors["kilometros"] = "El campo kilometraje es obligatorio.";
        }
        if (empty($this->caballos_potencia)) {
            $errors["caballos_potencia"] = "El campo caballos de fuerza es obligatorio.";
        }
        return $errors;
    }

    public function registrarVehicle()
    {
        date_default_timezone_set('America/Montevideo');
        $this->frenos_abs = intval($this->frenos_abs == "abs_si");
        $this->airbag = intval($this->airbag == "airbag_si");
        $this->control_estabilidad = intval($this->control_estabilidad == "est_si");

        if ($this->crear()) {
            $stmt = static::$db->prepare("select * from Vehicle where id = LAST_INSERT_ID()");

            $stmt->execute();
            while ($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
                return $registro["id"];
            }
        }
        return null;
    }

    public static function getVehicle($id)
    {
        $result = null;
        try {
            $query = "SELECT * FROM Vehicle WHERE id = $id LIMIT 1";
            $result = self::consultarSQL($query);

            if ($result) {
                $vehiculo = $result[0];
                $vehiculo->frenos_abs = $vehiculo->frenos_abs ? "abs_si" : "abs_no";
                $vehiculo->airbag = $vehiculo->airbag ? "airbag_si" : "airbag_no";
                $vehiculo->control_estabilidad = $vehiculo->control_estabilidad ? "est_si" : "est_no";
                return $vehiculo;
            }
        } catch (PDOException $th) {
            logg("[MARIADB] Error al consultar.");
        }
        return null;
    }

    public function modificarVehicle()
    {
        $errores = [];
        header('Content-Type: application/json; charset=utf-8');
        date_default_timezone_set('America/Montevideo');
        $this->updatedAt = new DateTime();
        $this->updatedAt = $this->updatedAt->format('Y-m-d H:i:s');
        $vehicle = new vehicle($_POST);
        $errores = $vehicle->validate();
        if (empty($errores)) {
            $result = $vehicle->actualizarVehicle();
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

    public function actualizarVehicle()
    {
        date_default_timezone_set('America/Montevideo');
        $this->frenos_abs = intval($this->frenos_abs == "abs_si");
        $this->airbag = intval($this->airbag == "airbag_si");
        $this->control_estabilidad = intval($this->control_estabilidad == "est_si");
        try {
            $query = "UPDATE Vehicle SET
            nombre = :nombre,
            categoria = :categoria,
            descripcion = :descripcion,
            modelo = :modelo,
            fabricante = :fabricante,
            year = :year,
            color = :color,
            matricula = :matricula,
            transmision = :transmision,
            tipo_carroceria = :tipo_carroceria,
            frenos_abs = :frenos_abs,
            airbag = :airbag,
            traccion = :traccion,
            direccion = :direccion,
            control_estabilidad = :control_estabilidad,
            puertas = :puertas,
            tipo_combustible = :tipo_combustible,
            precio = :precio,
            velocidad_max = :velocidad_max,
            zero_to_houndred = :zero_to_houndred,
            peso = :peso,
            kilometros = :kilometros,
            caballos_potencia = :caballos_potencia,
            updatedAt = :updatedAt WHERE id = :id";
            $params = [
                ':nombre' => $this->nombre,
                ':categoria' => $this->categoria,
                ':descripcion' => $this->descripcion,
                ':modelo' => $this->modelo,
                ':fabricante' => $this->fabricante,
                ':year' => $this->year,
                ':color' => $this->color,
                ':matricula' => $this->matricula,
                ':transmision' => $this->transmision,
                ':tipo_carroceria' => $this->tipo_carroceria,
                ':frenos_abs' => $this->frenos_abs,
                ':airbag' => $this->airbag,
                ':traccion' => $this->traccion,
                ':direccion' => $this->direccion,
                ':control_estabilidad' => $this->control_estabilidad,
                ':puertas' => $this->puertas,
                ':tipo_combustible' => $this->tipo_combustible,
                ':precio' => $this->precio,
                ':velocidad_max' => $this->velocidad_max,
                ':zero_to_houndred' => $this->zero_to_houndred,
                ':peso' => $this->peso,
                ':kilometros' => $this->kilometros,
                ':caballos_potencia' => $this->caballos_potencia,
                ':updatedAt' => $this->updatedAt,
                ':id' => $this->id
            ];
            $stmt = static::$db->prepare($query);
            $success = $stmt->execute($params);
            return $success;
        } catch (PDOException $th) {
            return false;
        }
    }

    public function addDiscountVehicle()
    {
        try {
            $query = "UPDATE Vehicle SET 
                      discount = :discount, 
                      discount_type = :discount_type
                      WHERE id = :id";
            $params = [
                ':discount' => $this->discount,
                ':discount_type' => $this->discount_type,
                ':id' => $this->id
            ];
            $stmt = static::$db->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $th) {
            return false;
        }
    }

    public function removeDiscountVehicle()
    {
        $this->discount = 0;
        $this->discount_type = null;
        try {
            $query = "UPDATE Vehicle SET 
                      discount = :discount, 
                      discount_type = :discount_type
                      WHERE id = :id";
            $params = [
                ':discount' => $this->discount,
                ':discount_type' => $this->discount_type,
                ':id' => $this->id
            ];
            $stmt = static::$db->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $th) {
            return false;
        }
    }
}
