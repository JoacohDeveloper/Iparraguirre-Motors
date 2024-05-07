<?php

namespace Models;

use Models\ActiveRecord;
use JsonSerializable;

class Vehicle extends ActiveRecord implements JsonSerializable
{
    protected static $tabla = "Vehicle";
    protected static $columnasdb = [
        "id", "id_unidad", "descripcion", "nombre", "modelo", "fabricante", "year", "color", "titulo_imagen", "imagen", "matricula",
        "numero_motor", "transmision", "tipo_carroceria", "frenos_abs", "airbag", "traccion", "tipo_vidrio", "direccion", "control_estabilidad", "puertas",
        "volumen_combustible", "tipo_combustible", "base_combustible", "voltaje", "vencimiento_seguro", "tipo_de_vehiculo", "precio", "velocidad_max", "zero_to_houndred",
        "pais", "stock", "poliza_seguro", "peso", "kilometros", "caballos_potencia", "createdAt", "updatedAt"
    ];

    public function jsonSerialize()
    {
        return (object) get_object_vars($this);
    }

    public $id, $id_unidad, $descripcion, $nombre, $modelo, $fabricante, $year, $color, $titulo_imagen, $imagen, $matricula, $numero_motor,
        $transmision, $tipo_carroceria, $frenos_abs, $airbag, $traccion, $tipo_vidrio, $direccion, $control_estabilidad, $puertas, $volumen_combustible, $tipo_combustible,
        $base_combustible, $voltaje, $vencimiento_seguro, $tipo_de_vehiculo, $precio, $velocidad_max, $zero_to_houndred, $pais, $stock, $poliza_seguro, $peso, $kilometros,
        $caballos_potencia, $createdAt, $updatedAt;

    function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->id_unidad = $args["id_unidad"] ?? "";
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
        $this->base_combustible = $args["base_combustible"] ?? "";
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


    public static function validarCampos()
    {
        $errors = [];
    }
}
