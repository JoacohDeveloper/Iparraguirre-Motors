<?php

namespace Models;

use Models\ActiveRecord;

class Refractions extends ActiveRecord
{
    protected static $tabla = "refractions";
    protected static $columnasdb = [
        "refraction_id",   // Cambiado de "id" a "refraction_id"
        "nombre",          // Nombre de la refacción
        "descripcion",     // Descripción de la refacción
        "fabricante",      // Fabricante de la refacción
        "modelo",          // Modelo de la refacción
        "precio",          // Precio de la refacción
        "discount",        // Descuento aplicado
        "discount_type",   // Tipo de descuento
        "stock",           // Cantidad en stock
        "peso",            // Peso de la refacción
        "origen",          // País de origen
        "url_img",         // URL de la imagen
        "alt_img",         // Texto alternativo de la imagen
        "createdAt",       // Fecha de creación
        "updatedAt"        // Fecha de actualización
    ];

    public $refraction_id,  // Cambiado de "id" a "refraction_id"
        $nombre,
        $descripcion,
        $fabricante,
        $modelo,         // Agregado el modelo de la refacción
        $precio,
        $discount,       // Agregado el descuento
        $discount_type,  // Agregado el tipo de descuento
        $stock,
        $peso,
        $origen,
        $url_img,
        $alt_img,
        $createdAt,
        $updatedAt;

    function __construct($args = [])
    {
        $this->refraction_id = $args["id"] ?? null;
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

    public function registrarRefractions()
    {
        date_default_timezone_set('America/Montevideo');
        $resultado = $this->crear();
        if ($resultado) {
            $this->refraction_id = static::$db->lastInsertId();
            return ['resultado' => true, 'id' => $this->refraction_id];
        }
        return ['resultado' => false];
    }

    public function actualizarImagenes()
    {
        $query = "UPDATE " . self::$tabla . " SET url_img = :url_img, alt_img = :alt_img WHERE id = :id";
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':url_img', $this->url_img);
        $stmt->bindParam(':alt_img', $this->alt_img);
        $stmt->bindParam(':id', $this->refraction_id);

        $stmt->execute();
    }
}
