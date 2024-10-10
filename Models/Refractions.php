<?php

namespace Models;

use Models\ActiveRecord;
use JsonSerializable;

class Refractions extends ActiveRecord implements JsonSerializable
{
    protected static $tabla = "Refractions";
    protected static $columnasdb = [
        "id", "nombre","descripcion","fabricante","precio","stock","peso",
        "origen","url_img","alt_img","createdAt","updatedAt"
    ];

    public function jsonSerialize()
    {
        return (object) get_object_vars($this);
    }

    public $id, $nombre, $descripcion, $fabricante, $precio, $stock,
        $peso, $origen, $url_img, $alt_img, $createdAt, $updatedAt;

    function __construct($args = []) {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->descripcion = $args["descripcion"] ?? "";
        $this->fabricante = $args["fabricante"] ?? "";
        $this->precio = $args["precio"] ?? "";
        $this->stock = $args["stock"] ?? "";
        $this->peso = $args["peso"] ?? "";
        $this->origen = $args["origen"] ?? "";
        $this->url_img = $args["url_img"] ?? "";
        $this->alt_img = $args["alt_img"] ?? "";
        $this->createdAt = $this->createdAt ? $this->createdAt->format('Y-m-d H:i:s') : date("Y-m-d H:i:s");
        $this->updatedAt = $this->updatedAt ? $this->updatedAt->format('Y-m-d H:i:s') : date("Y-m-d H:i:s");
    }

    public static function getAllRefractions()
    {
        $refraction = new self();
        return $refraction->getAll();
    }

    public static function getAllRefractionsByPage($page = 1, $refractionName = null)
    {
        $inicio = 0;
        $fin = 10;
        if ($page > 1) {
            $inicio =  ($page - 1) * 10;
        }
        $query = "SELECT * FROM " . static::$tabla . " limit $inicio,$fin";

        if ($refractionName) {
            $query = "SELECT * FROM " . static::$tabla . " WHERE nombre LIKE '%$refractionName%' limit $inicio,$fin";
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
        if (empty($this->fabricante)) {
            $errors["fabricante"] = "El campo fabricante es obligatorio.";
        }
        if (empty($this->precio)) {
            $errors["precio"] = "El campo precio es obligatorio.";
        }
        if (empty($this->stock)) {
            $errors["stock"] = "El campo stock del producto es obligatorio.";
        }
        if (empty($this->peso)) {
            $errors["peso"] = "El campo peso del producto es obligatorio.";
        }
        if (empty($this->origen)) {
            $errors["origen"] = "El campo origen del producto es obligatorio.";
        }
        return $errors;
    }

    public function registrarRefractions() {
        return $this->crear();
    }
}
