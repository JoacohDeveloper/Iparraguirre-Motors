<?php

namespace Models;

use Ramsey\Uuid\Uuid;


class Product extends ActiveRecord
{

    protected static $tabla = "product";

    protected static $columnasdb = [ "product_id", "nombre", "descripcion", "categoria", "precio", "modelo", "fabricante", "discount", "discount_type", "createdAt", "updatedAt" ];

    public $product_id, $nombre, $descripcion, $categoria, $modelo, $fabricante, $precio, $discount, $discount_type, $stock, $peso, $createdAt, $updatedAt;

    public function __construct($args = [])
    {
        $this->product_id = $args["product_id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->descripcion = $args["descripcion"] ?? "";
        $this->precio = $args["precio"] ?? "";
        $this->discount = isset($args["discount"]) && is_numeric($args["discount"]) ? $args["discount"] : 0;
        $this->discount_type = $args["discount_type"] ?? "";
        $this->stock = $args["stock"] ?? 1;
        $this->peso = $args["peso"] ?? "";
        $this->createdAt = date("Y-m-d H:i:s");
        $this->updatedAt = date("Y-m-d H:i:s");
        $this->categoria = $args["categoria"] ?? "";
        $this->modelo = $args["modelo"] ?? "";
        $this->fabricante = $args["fabricante"] ?? "";
        $this->peso = $args["peso"] ?? 0.0;
        $this->nombre = $this->fabricante . " " . $this->modelo;
    }


    public function genUUID()
    {
        $this->product_id = Uuid::uuid4()->toString();
    }


    public function registrar()
    {
        $this->genUUID();
        return $this->crear();
    }


    public static function get($uuid)
    {
        $product = null;
        try {
            $product = self::consultarSQL("SELECT * FROM " . self::$tabla . " where product_id = '" . $uuid . "'");
        } catch (\PDOException) {
            return "Error al consultar su producto.";
        } catch (\Exception) {
            return "Ocurrio un error, intenta de nuevo más tarde.";
        }

        return $product;
    }
}
