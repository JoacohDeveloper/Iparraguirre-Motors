<?php

namespace Models;

use Models\ActiveRecord;
use PDO;

class Refractions extends ActiveRecord
{
    protected static $tabla = "refractions";
    protected static $columnasdb = [
        "refraction_id",   // Cambiado de "id" a "refraction_id"
        "tipo_repuesto",    // Tipo del repuesto
        "origen",          // Origen del producto
        "peso",            // Peso del paquete
        "stock",           // Cantidad de stock
        "url_img",         // URL de la imagen
        "alt_img",         // Texto alternativo de la imagen
    ];


    public
        $product,
        $refraction_id,  // Cambiado de "id" a "refraction_id"
        $tipo_repuesto,
        $origen,
        $peso,
        $stock,
        $url_img,
        $alt_img;

    function __construct($args = [])
    {
        $this->product = new Product($args);
        $this->origen = $args["origen"] ?? "";
        $this->product->categoria = "Repuesto";
        $this->tipo_repuesto = $args["tipo_repuesto"] ?? "";
        $this->peso = $args["peso"] ?? null;
        $this->stock = $args["stock"] ?? null;
        $this->refraction_id = $args["refraction_id"] ?? null;
        $this->url_img = $args["url_img"] ?? "";
        $this->alt_img = $args["alt_img"] ?? "";
    }




    public static function getAllRefractions()
    {
        $refraction = new self();
        $refractions = $refraction->getAll();

        $product = new Product();
        $products = $product->getAll();

        foreach ($refractions as $ref) {
            // Casteamos $vehicle a la clase Vehicle
            if ($ref instanceof Refractions)
                foreach ($products as $product) {
                    if ($product instanceof Product)
                        // Casteamos $product a la clase Product
                        if ($ref->refraction_id == $product->product_id) {
                            $ref->product = $product;
                        }
                }
        }
        return $refractions;
    }

    public static function getAllRefractionsByPage($page = 1, $refractionName = null)
    {
        $inicio = 0;
        $fin = 10;
        if ($page > 1) {
            $inicio =  ($page - 1) * 10;
        }
        $query = "SELECT * FROM " . static::$tabla . " R INNER JOIN product P on R.refraction_id = P.product_id limit $inicio,$fin";

        if ($refractionName) {
            $query = "SELECT * FROM " . static::$tabla . " R INNER JOIN product P on R.refraction_id = P.product_id WHERE P.nombre LIKE '%$refractionName%' limit $inicio,$fin";
        }

        $resultado = self::consultarSQL($query);



        $product = new Product();
        $products = $product->getAll();

        foreach ($resultado as $ref) {
            // Casteamos $vehicle a la clase Vehicle
            if ($ref instanceof Refractions)
                foreach ($products as $product) {
                    if ($product instanceof Product)
                        // Casteamos $product a la clase Product
                        if ($ref->refraction_id == $product->product_id) {
                            $ref->product = $product;
                        }
                }
        }


        return $resultado;
    }


    public function validate()
    {
        $errors = [];

        if (empty($this->product->nombre)) {
            $errors["nombre"] = "El campo nombre es obligatorio.";
        }
        if (empty($this->tipo_repuesto)) {
            $errors["tipo_repuesto"] = "El campo tipo de repuesto es obligatorio.";
        }
        if (empty($this->product->descripcion)) {
            $errors["descripcion"] = "El campo descripcion es obligatorio.";
        }
        if (empty($this->product->fabricante)) {
            $errors["fabricante"] = "El campo fabricante es obligatorio.";
        }
        if (empty($this->product->modelo)) {
            $errors["modelo"] = "El campo modelo es obligatorio.";
        }
        if (empty($this->product->precio)) {
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
        $resultado = $this->product->registrar();
        if ($resultado) {
            $this->refraction_id = $this->product->product_id;
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

    public function actualizarImagenes()
    {
        $query = "UPDATE " . self::$tabla . " SET url_img = :url_img, alt_img = :alt_img WHERE id = :id";
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':url_img', $this->url_img);
        $stmt->bindParam(':alt_img', $this->alt_img);
        $stmt->bindParam(':id', $this->refraction_id);

        $stmt->execute();
    }

    public function actualizarRepuesto($id) {
        $this->id = $id;
        date_default_timezone_set('America/Montevideo');
        try {
            $query = "UPDATE " . self::$tabla . " SET
                nombre = :nombre,
                descripcion = :descripcion,
                fabricante = :fabricante,
                modelo = :modelo,
                tipo = :tipo,
                precio = :precio,
                stock = :stock,
                peso = :peso,
                origen = :origen,
                url_img = :url_img,
                alt_img = :alt_img,
                updatedAt = :updatedAt
                WHERE id = :id";
            $params = [
                ':nombre' => $this->nombre,
                ':descripcion' => $this->descripcion,
                ':fabricante' => $this->fabricante,
                ':modelo' => $this->modelo,
                ':tipo' => $this->tipo,
                ':precio' => $this->precio,
                ':stock' => $this->stock,
                ':peso' => $this->peso,
                ':origen' => $this->origen,
                ':url_img' => $this->url_img,
                ':alt_img' => $this->alt_img,
                ':updatedAt' => date("Y-m-d H:i:s"),
                ':id' => $this->id
            ];
            $stmt = static::$db->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $th) {
            return false;
        }
    }
    
}
