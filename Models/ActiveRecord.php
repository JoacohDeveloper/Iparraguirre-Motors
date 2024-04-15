<?php


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
        $stmt = static::$db->prepare($query);
        $stmt->execute($params);

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


        // logg($query);
        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
            'resultado' =>  $resultado,
            'uuid' => self::$db->insert_id
        ];
    }

    public function guardar()
    {
        $resultado = '';
        if (!is_null($this->uuid)) {
            // actualizar
            // $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro

            $resultado = $this->crear();
        }
        return $resultado;
    }
}
