<?php

namespace Models;

use Models\ActiveRecord;
use PDOException;
use PDO;
use DateTime;

class Vehicle extends ActiveRecord
{
    protected static $tabla = "vehicle";
    protected static $columnasdb = [
        "vehicle_id",
        "categoria",
        "modelo",
        "fabricante",
        "year",
        "color",
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
        "velocidad_max",
        "zero_to_houndred",
        "peso",
        "kilometros",
        "caballos_potencia"
    ];

    public $product;
    public $vehicle_id;
    public $categoria;
    public $modelo;
    public $fabricante;
    public $year;
    public $color;
    public $matricula;
    public $transmision;
    public $tipo_carroceria;
    public $frenos_abs;
    public $airbag;
    public $traccion;
    public $direccion;
    public $control_estabilidad;
    public $puertas;
    public $tipo_combustible;
    public $velocidad_max;
    public $zero_to_houndred;
    public $peso;
    public $kilometros;
    public $caballos_potencia;

    public function __construct($args = [])
    {

        $this->product = new Product($args);

        $this->vehicle_id = $args["vehicle_id"] ?? null;
        $this->categoria = $args["categoria"] ?? "";
        $this->modelo = $args["modelo"] ?? "";
        $this->fabricante = $args["fabricante"] ?? "";
        $this->year = $args["year"] ?? "";
        $this->color = $args["color"] ?? "";
        $this->matricula = $args["matricula"] ?? "";
        $this->transmision = $args["tipo_transmision"] ?? "";
        $this->tipo_carroceria = $args["tipo_carroceria"] ?? "";
        $this->frenos_abs = $args["frenos_abs"] ?? 0; // 0 o 1
        $this->airbag = $args["airbag"] ?? 0; // 0 o 1
        $this->traccion = $args["traccion"] ?? "";
        $this->direccion = $args["direccion"] ?? "";
        $this->control_estabilidad = $args["control_estabilidad"] ?? 0; // 0 o 1
        $this->puertas = $args["puertas"] ?? 0;
        $this->tipo_combustible = $args["tipo_combustible"] ?? "";
        $this->velocidad_max = $args["velocidad_max"] ?? 0.0; // Default a 0.0
        $this->zero_to_houndred = $args["zero_to_houndred"] ?? 0.0; // Default a 0.0
        $this->peso = $args["peso"] ?? 0.0; // Default a 0.0
        $this->kilometros = $args["kilometros"] ?? 0; // Default a 0
        $this->caballos_potencia = $args["caballos_fuerza"] ?? 0; // Default a 0
    }
    public $vehicleImages = [];

    public function getAllVehiclesImages()
    {
        try {
            $query = "select * from vehicle_img where vehicle_id = '" . $this->vehicle_id . "'";

            $stmt = static::$db->prepare($query);
            $stmt->execute();
            while ($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->vehicleImages[] = ["url" => $registro["url"], "alt" => $registro["alt"]];
            }
        } catch (\Throwable $th) {
            logg("Error al cargar imagenes");
        }
    }

    public static function getAllVehicles()
    {
        $vehicle = new self();
        $vehicles = $vehicle->getAll();

        $product = new Product();
        $products = $product->getAll();



        foreach ($vehicles as $vehicle) {
            // Casteamos $vehicle a la clase Vehicle
            if ($vehicle instanceof Vehicle)
                foreach ($products as $product) {
                    if ($product instanceof Product)
                        // Casteamos $product a la clase Product
                        if ($vehicle->vehicle_id == $product->product_id) {
                            $vehicle->product = $product;
                        }
                }
        }
        return $vehicles;
    }

    public function delete()
    {
        $query = "DELETE FROM Vehicle WHERE id = " . $this->vehicle_id;
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
        $query = "SELECT * FROM " . static::$tabla . " v LEFT JOIN product p on v.vehicle_id = p.product_id ORDER BY p.CreatedAt DESC LIMIT $inicio, $fin";

        if ($vehicleName) {
            $query = "SELECT * FROM " . static::$tabla . " v LEFT JOIN product p on v.vehicle_id = p.product_id WHERE p.nombre LIKE '%$vehicleName%' ORDER BY CreatedAt DESC LIMIT $inicio, $fin";
        }

        $resultado = self::consultarSQL($query);



        $product = new Product();
        $products = $product->getAll();

        foreach ($resultado as $vehicle) {
            // Casteamos $vehicle a la clase Vehicle
            if ($vehicle instanceof Vehicle)
                foreach ($products as $product) {
                    if ($product instanceof Product)
                        // Casteamos $product a la clase Product
                        if ($vehicle->vehicle_id == $product->product_id) {
                            $vehicle->product = $product;
                        }
                }
        }


        return $resultado;
    }


    public function validate()
    {
        $errors = [];

        // if (empty($this->product->nombre)) {
        //     $errors["nombre"] = "El campo nombre es obligatorio.";
        // }
        if ($this->categoria == "") {
            $errors["categoria"] = "El campo categoria es obligatorio.";
        }
        if (empty($this->product->descripcion)) {
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
        if (empty($this->product->precio)) {
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
        $result = $this->product->registrar();
        if ($result) {
            $this->vehicle_id = $this->product->product_id;
            if ($this->crear()) {

                $stmt = static::$db->prepare("select * from product where product_id ='" . $this->product->product_id . "'");

                $stmt->execute();
                while ($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    return $registro["product_id"];
                }
            }
            return null;
        }
    }


    public function getName()
    {
        return $this->product->nombre;
    }

    public static function getVehicle($id)
    {
        $result = null;
        try {
            $query = "SELECT * FROM vehicle WHERE vehicle_id = $id LIMIT 1";
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
        $this->product->updatedAt = new DateTime();
        $this->product->updatedAt  = $this->product->updatedAt->format('Y-m-d H:i:s');
        $vehicle = new vehicle($_POST);
        $errores = $vehicle->validate();
        if (empty($errores)) {
            $result = $vehicle->actualizarVehicle($this->vehicle_id);
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

    public function actualizarVehicle($id): mixed
    {

        $this->vehicle_id = $id;

        date_default_timezone_set('America/Montevideo');
        $this->frenos_abs = intval($this->frenos_abs == "abs_si");
        $this->airbag = intval($this->airbag == "airbag_si");
        $this->control_estabilidad = intval($this->control_estabilidad == "est_si");

        try {

            $queryProduct = "UPDATE product SET
            nombre = :nombre,
            descripcion = :descripcion,
            precio = :precio,
            updatedAt = :updatedAt 
            WHERE product_id = :product_id";

            $paramsProduct = [
                ':nombre' => $this->product->nombre,
                ':descripcion' => $this->product->descripcion,
                ':precio' => $this->product->precio,
                ':updatedAt' => $this->product->updatedAt,
                ':product_id' => $id // Asegúrate de que esta propiedad exista
            ];
            // logg($paramsProduct);
            $stmt = static::$db->prepare($queryProduct);
            $success = $stmt->execute($paramsProduct);

            // logg("no llegue aca");


            $queryVehicle = "UPDATE vehicle SET
            categoria = :categoria,
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
            velocidad_max = :velocidad_max,
            zero_to_houndred = :zero_to_houndred,
            peso = :peso,
            kilometros = :kilometros,
            caballos_potencia = :caballos_potencia
            WHERE vehicle_id = :vehicle_id";



            $paramsVehicle = [
                ':categoria' => $this->categoria,
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
                ':velocidad_max' => $this->velocidad_max,
                ':zero_to_houndred' => $this->zero_to_houndred,
                ':peso' => $this->peso,
                ':kilometros' => $this->kilometros,
                ':caballos_potencia' => $this->caballos_potencia,
                // Actualiza a la fecha actual
                ':vehicle_id' => $this->vehicle_id // Asegúrate de que esta propiedad exista
            ];

            // logg($paramsVehicle);





            $stmt3 = static::$db->prepare($queryVehicle);
            $stmt3->execute($paramsVehicle);

            $stmt2 = static::$db->prepare("DELETE FROM vehicle_img where vehicle_id = '" . $id . "'");

            $stmt2->execute();

            return $success;
        } catch (PDOException $th) {

            logg($th);
            return false;
        }
    }

    public function addDiscountVehicle()
    {
        try {
            $query = "UPDATE product SET 
                      discount = :discount, 
                      discount_type = :discount_type
                      WHERE product_id = :id";
            $params = [
                ':discount' => $this->product->discount,
                ':discount_type' => $this->product->discount_type,
                ':id' => $this->vehicle_id
            ];
            $stmt = static::$db->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $th) {
            return false;
        }
    }

    public function removeDiscountVehicle()
    {
        $this->product->discount = 0;
        $this->product->discount_type = null;
        try {
            $query = "UPDATE product SET 
                      discount = :discount, 
                      discount_type = :discount_type
                      WHERE product_id = :id";
            $params = [
                ':discount' => $this->product->discount,
                ':discount_type' => $this->product->discount_type,
                ':id' => $this->vehicle_id
            ];
            $stmt = static::$db->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $th) {
            return false;
        }
    }
}
