<?php

namespace Models;

use Models\ActiveRecord;
use JsonSerializable;

class Vehicle extends ActiveRecord implements JsonSerializable
{
    protected static $tabla = "Vehicle";
    protected static $columnasdb = [
        "id", "descripcion", "nombre", "modelo", "fabricante", "year", "color", "titulo_imagen", "imagen", "matricula", "transmision",
        "tipo_carroceria", "frenos_abs", "airbag", "traccion", "direccion", "control_estabilidad", "puertas", "tipo_combustible",
        "precio", "velocidad_max", "zero_to_houndred", "pais", "peso", "kilometros", "caballos_potencia", "createdAt", "updatedAt"
    ];

    public function jsonSerialize()
    {
        return (object) get_object_vars($this);
    }

    public $id, $nombre, $descripcion, $modelo, $fabricante, $year, $color, $titulo_imagen, $imagen, $matricula, $transmision, $tipo_carroceria, $frenos_abs,
        $airbag, $traccion, $direccion, $control_estabilidad, $puertas, $tipo_combustible, $precio, $velocidad_max, $zero_to_houndred, $pais, $peso, $kilometros,
        $caballos_potencia, $createdAt, $updatedAt;

    function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->descripcion = $args["descripcion"] ?? "";
        $this->modelo = $args["modelo"] ?? "";
        $this->fabricante = $args["fabricante"] ?? "";
        $this->year = $args["year"] ?? "";
        $this->color = $args["color"] ?? "";
        $this->titulo_imagen = $args["titulo_imagen"] ?? "";
        $this->imagen = $args["imagen"] ?? "";
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
        $this->velocidad_max = $args["velocidad_max"] ?? "";
        $this->zero_to_houndred = $args["zero_to_houndred"] ?? "";
        $this->pais = $args["pais"] ?? "";
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

    public static function getAllVehiclesByPage($page = 1, $vehicleName = null)
    {
        $inicio = 0;
        $fin = 10;
        if ($page > 1) {
            $inicio =  ($page - 1) * 10;
        }
        $query = "SELECT * FROM " . static::$tabla . " limit $inicio,$fin";

        if ($vehicleName) {
            $query = "SELECT * FROM " . static::$tabla . " WHERE nombre LIKE '%$vehicleName%' limit $inicio,$fin";
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
        if (empty($this->pais)) {
            $errors["pais"] = "El campo pais es obligatorio.";
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
        $this->frenos_abs = intval($this->frenos_abs == "abs_si");
        $this->airbag = intval($this->airbag == "airbag_si");
        $this->control_estabilidad = intval($this->control_estabilidad == "est_si");
        return $this->crear();
    }
}
