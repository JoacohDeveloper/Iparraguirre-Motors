<?php

//ActiveRecord es un antipatron de diseño
// O patron de arquitectura que sirve para solucionar la relacion de modelos de la base de datos y clases y objetos, en este caso lo estamos usando en php, dentro de ella creamos los metodos que van a tener todas las clases que hereden de ActiveRecord llamados Modelos al usar el patron de arquitectura general Modelo Vista Controlador.

namespace Models;

use PDO;

class ActiveRecord
{
    protected static $db;
    protected static $tabla = '';
    protected static $columnasdb = [];

    public static function setdb($database)
    {
        self::$db = $database;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    public static function consultarSQL($query, $params = [])
    {
        try {
            $stmt = static::$db->prepare($query);
            $stmt->execute($params);
        } catch (\Throwable $th) {
            logg("[MARIA BECERRA] ERROR EN LA BASE DE DATOS!");
        }

        $array = [];
        while ($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $array[] = static::crearObjeto($registro);
        }

        $stmt = null;

        return $array;
    }

    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasdb as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->quote($value);
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    public function crear()
    {

        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (";
        $query .= join(", ", array_values($atributos));
        $query .= ") ";

        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
            'resultado' =>  $resultado
        ];
    }

    public function actualizar($uuid)
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "$key=$value";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .=  join(', ', $valores);
        $query .= " WHERE uuid = '$uuid'";
        //$query .= " LIMIT 1";

        // Actualizar BD
        $resultado = self::$db->query($query);
        // $resultado = $query;
        return [
            'resultado' =>  $resultado
        ];
    }


    public function getAll($limit = null)
    {
        $query = "SELECT * FROM " . static::$tabla;
        if ($limit != null) {
            $query = "SELECT * FROM " . static::$tabla . " LIMIT $limit";
        }

        $resultado = self::consultarSQL($query);
        return $resultado;
    }


<<<<<<< HEAD
=======
    public function eliminar($uuid)
    {
        // Consulta SQL
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .=  "isDeleted = 1";
        $query .= " WHERE uuid = '$uuid'";
        //$query .= " LIMIT 1";

        // Actualizar BD
        $resultado = self::$db->query($query);
        // $resultado = $query;
        return [
            'resultado' =>  $resultado
        ];
    }

>>>>>>> origin/add-vehicle

    public function guardar()
    {
        $resultado = '';
        if (!is_null($this->uuid)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }
}
