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
            if ($columna === 'id' || $columna === "uuid") continue;
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
}
