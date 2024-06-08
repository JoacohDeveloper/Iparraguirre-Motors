<?php

namespace Models;

use Models\ActiveRecord;
use JsonSerializable;

class Vehicle extends ActiveRecord implements JsonSerializable
{
    protected static $tabla = "Vehicle";
    protected static $columnasdb = [
        "id", "descripcion", "nombre", "modelo", "fabricante", "year", "color", "titulo_imagen", "imagen", "matricula",
        "numero_motor", "transmision", "tipo_carroceria", "frenos_abs", "airbag", "traccion", "tipo_vidrio", "direccion", "control_estabilidad", "puertas",
        "volumen_combustible", "tipo_combustible", "voltaje", "vencimiento_seguro", "tipo_de_vehiculo", "precio", "velocidad_max", "zero_to_houndred",
        "pais", "stock", "poliza_seguro", "peso", "kilometros", "caballos_potencia", "createdAt", "updatedAt"
    ];

    public function jsonSerialize()
    {
        return (object) get_object_vars($this);
    }

    public $id, $descripcion, $nombre, $modelo, $fabricante, $year, $color, $titulo_imagen, $imagen, $matricula, $numero_motor,
        $transmision, $tipo_carroceria, $frenos_abs, $airbag, $traccion, $tipo_vidrio, $direccion, $control_estabilidad, $puertas, $volumen_combustible, $tipo_combustible,
        $voltaje, $vencimiento_seguro, $tipo_de_vehiculo, $precio, $velocidad_max, $zero_to_houndred, $pais, $stock, $poliza_seguro, $peso, $kilometros,
        $caballos_potencia, $createdAt, $updatedAt;

    function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->descripcion = $args["descripcion"] ?? "";
        $this->nombre = $args["nombre"] ?? "";
        $this->modelo = $args["modelo"] ?? "";
        $this->fabricante = $args["fabricante"] ?? "";
        $this->year = $args["year"] ?? "";
        $this->color = $args["color"] ?? "";
        $this->titulo_imagen = $args["titulo_imagen"] ?? "";
        $this->imagen = $args["imagen"] ?? "";
        $this->matricula = $args["matricula"] ?? "";
        $this->numero_motor = $args["numero_motor"] ?? "";
        $this->transmision = $args["transmision"] ?? "";
        $this->tipo_carroceria = $args["tipo_carroceria"] ?? "";
        $this->frenos_abs = $args["frenos_abs"] ?? "";
        $this->airbag = $args["airbag"] ?? "";
        $this->traccion = $args["traccion"] ?? "";
        $this->tipo_vidrio = $args["tipo_vidrio"] ?? "";
        $this->direccion = $args["direccion"] ?? "";
        $this->control_estabilidad = $args["control_estabilidad"] ?? "";
        $this->puertas = $args["puertas"] ?? "";
        $this->volumen_combustible = $args["volumen_combustible"] ?? "";
        $this->tipo_combustible = $args["tipo_combustible"] ?? "";
        $this->voltaje = $args["voltaje"] ?? "";
        $this->vencimiento_seguro = $args["vencimiento_seguro"] ?? "";
        $this->tipo_de_vehiculo = $args["tipo_de_vehiculo"] ?? "";
        $this->precio = $args["precio"] ?? "";
        $this->velocidad_max = $args["velocidad_max"] ?? "";
        $this->zero_to_houndred = $args["zero_to_houndred"] ?? "";
        $this->pais = $args["pais"] ?? "";
        $this->stock = $args["stock"] ?? "";
        $this->poliza_seguro = $args["poliza_seguro"] ?? "";
        $this->peso = $args["peso"] ?? "";
        $this->kilometros = $args["kilometros"] ?? "";
        $this->caballos_potencia = $args["caballos_potencia"] ?? "";
        $this->createdAt = $this->createdAt ? $this->createdAt->format('Y-m-d H:i:s') : null;
        $this->updatedAt = $this->updatedAt ? $this->updatedAt->format('Y-m-d H:i:s') : null;
    }

    public static function getAllVehicles()
    {
        $vehicle = new self();
        return $vehicle->getAll();
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
        if (empty($this->numero_motor)) {
            $errors["numero_motor"] = "El campo numero de motor es obligatorio.";
        }
        if ($this->transmision == "none_selected" || $this->transmision ==  null) {
            $errors["transmision"] = "El campo transmision es obligatorio.";
        }
        if ($this->tipo_carroceria == "none_selected" || $this->tipo_carroceria ==  null) {
            $errors["tipo_carroceria"] = "El campo tipo de carroceria es obligatorio.";
        }
        if ($this->frenos_abs == "none_selected" || $this->frenos_abs ==  null) {
            $errors["tipo_carroceria"] = "El campo tipo de carroceria es obligatorio.";
        }
        if ($this->airbag == "none_selected" || $this->airbag ==  null) {
            $errors["tipo_carroceria"] = "El campo tipo de carroceria es obligatorio.";
        }
        if (empty($this->traccion)) {
            $errors["traccion"] = "El campo traccion es obligatorio.";
        }
        if (empty($this->tipo_vidrio)) {
            $errors["tipo_vidrio"] = "El campo tipo de vidrio es obligatorio.";
        }
        if (empty($this->direccion)) {
            $errors["direccion"] = "El campo direccion es obligatorio.";
        }
        if ($this->control_estabilidad == "none_selected" || $this->control_estabilidad ==  null) {
            $errors["control_estabilidad"] = "El campo control de estabilidad es obligatorio.";
        }
        if (empty($this->puertas)) {
            $errors["puertas"] = "El campo numero de puertas es obligatorio.";
        }
        if (empty($this->volumen_combustible)) {
            $errors["volumen_combustible"] = "El campo volumen de combustible es obligatorio.";
        }
        if (empty($this->tipo_combustible)) {
            $errors["tipo_combustible"] = "El campo tipo de combustible es obligatorio.";
        }
        if (empty($this->fecha)) {
            $errors["fecha"] = "El campo fecha es obligatorio."; //Hay que hacer cambios con la fecha
        }
        if ($this->tipo_de_vehiculo == "none_selected" || $this->tipo_de_vehiculo ==  null) {
            $errors["tipo_de_vehiculo"] = "El campo tipo de vehiculo es obligatorio.";
        }
        if (empty($this->precio)) {
            $errors["precio"] = "El campo precio es obligatorio.";
        }
        if (empty($this->velocidad)) {
            $errors["velocidad"] = "El campo velocidad maxima es obligatorio.";
        }
        if (empty($this->zero_to_houndred)) {
            $errors["nombre"] = "El campo nombre es obligatorio.";
        }
        if (empty($this->pais)) {
            $errors["pais"] = "El campo pais es obligatorio.";
        }
        if (empty($this->stock)) {
            $errors["stock"] = "El campo stock disponible es obligatorio.";
        }
        if (empty($this->poliza_seguro)) {
            $errors["poliza_seguro"] = "El campo poliza seguro es obligatorio.";
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
        return $this->crear();
    }
}
