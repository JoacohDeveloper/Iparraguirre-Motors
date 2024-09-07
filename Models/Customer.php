<?php

namespace Models;

use DateTime;
use PDOException;

class Customer extends ActiveRecord
{

    protected static $tabla = "Customer";
    protected static $columnasdb = [
        "uuid",
        "full_name",
        "username",
        "slug",
        "email",
        "phone",
        "password",
        "token",
        "isAdmin",
        "isDeleted",
        "verify",
        "titulo_imagen",
        "imagen",
        "createdAt",
        "updatedAt"
    ];

    protected $uuid, $full_name, $username, $slug, $email, $phone, $password, $re_password, $token, $isAdmin, $isDeleted, $verify, $titulo_imagen, $imagen, $createdAt, $updatedAt;

    function __construct($args = [])
    {
        $this->uuid = $args["uuid"] ?? null;
        $this->full_name = $args["full_name"] ?? "";
        $this->username = $args["username"] ?? "";
        $this->slug = sanitize(str_replace(" ", "-", trim(strtolower($this->username))));
        $this->email = $args["email"] ?? "";
        $this->phone = $args["phone"] ?? "";
        $this->password = $args["password"] ?? "";
        $this->re_password = $args["re_password"] ?? "";
        $this->token = null;
        $this->isAdmin = 0;
        $this->isDeleted = $args["isDeleted"] ?? 0;
        $this->verify = 0;
        $this->titulo_imagen = "imagen default de usuario";
        $this->imagen = $args["imagen"] ?? "\build\src\images\users\default.jpg";
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->createdAt =  $this->createdAt->format('Y-m-d H:i:s');
        $this->updatedAt =  $this->updatedAt->format('Y-m-d H:i:s');
    }

    public function gen_uuid()
    {
        $uuid = array(
            'time_low' => 0,
            'time_mid' => 0,
            'time_hi' => 0,
            'clock_seq_hi' => 0,
            'clock_seq_low' => 0,
            'node' => array()
        );

        $uuid['time_low'] = mt_rand(0, 0xffff) + (mt_rand(0, 0xffff) << 16);
        $uuid['time_mid'] = mt_rand(0, 0xffff);
        $uuid['time_hi'] = (4 << 12) | (mt_rand(0, 0x1000));
        $uuid['clock_seq_hi'] = (1 << 7) | (mt_rand(0, 128));
        $uuid['clock_seq_low'] = mt_rand(0, 255);

        for ($i = 0; $i < 6; $i++) {
            $uuid['node'][$i] = mt_rand(0, 255);
        }

        $uuid = sprintf(
            '%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x',
            $uuid['time_low'],
            $uuid['time_mid'],
            $uuid['time_hi'],
            $uuid['clock_seq_hi'],
            $uuid['clock_seq_low'],
            $uuid['node'][0],
            $uuid['node'][1],
            $uuid['node'][2],
            $uuid['node'][3],
            $uuid['node'][4],
            $uuid['node'][5]
        );

        $this->uuid = $uuid;
    }


    public function getUUID()
    {
        return $this->uuid;
    }

    public function validate()
    {
        $errors = [];
        if (empty($this->username)) {
            $errors["username"] = "Debes ingresar un usuario.";
        } else if (strlen($this->username) <= 4) {
            $errors["username"] = "El usuario debe tener minimo 5 caracteres.";
        }
        if (empty($this->full_name)) {
            $errors["full_name"] = "el campo nombre completo es obligatorio.";
        }
        if (strpos($this->full_name, ' ') == false) {
            $errors["full_name"] = "debes ingresar nombre y apellido.";
        }
        if (empty($this->email)) {
            $errors["email"] = "el campo email es obligatorio.";
        } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "formato de email invalido";
        }
        if (empty($this->phone)) {
            $errors["phone"] = "el campo numero de celular es obligatorio.";
        } else if (strlen($this->phone) != 9) {
            $errors["phone"] = "ingrese un numero de celular valido.";
        }
        if (empty($this->password)) {
            $errors["password"] = "el campo password es obligatorio.";
        }

        if (!isset($this->uuid)) {
            if (empty($this->re_password)) {
                $errors["re_password"] = "el campo repetir password es obligatorio.";
            }
            if ($this->re_password != $this->password) {
                $errors["not_equal"] = "las contraseñas no coinciden.";
            }
        }

        return $errors;
    }

    public static function validarCampos($email, $password)
    {
        $errores = [];
        if (empty($email)) {
            $errores["email"] = "el campo email es obligatorio.";
        }
        if (empty($password)) {
            $errores["password"] = "el campo password es obligatorio.";
        }
        return $errores;
    }

    public function passwordHash()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearCustomer()
    {
        $this->gen_uuid();
        return $this->crear();
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function getNombreImagen()
    {
        return $this->titulo_imagen;
    }

    public function getNombreImagen_Url()
    {
        return ["url" => $this->getImagen(), "alt" => $this->getNombreImagen()];
    }

    public static function getCustomer($dato)
    {
        $result = null;
        try {
            $query = "SELECT * FROM Customer WHERE email = ? or username = ? LIMIT 1";
            $result = Customer::consultarSQL($query, [$dato, $dato]);
        } catch (PDOException $th) {
            logg("[MARIADB] Error al consultar.");
        }

        return $result[0] ?? null;
    }

    public function validarPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function isAdmin()
    {
        return boolval($this->isAdmin);
    }

    public function getDeleted()
    {
        return boolval($this->isDeleted);
    }
}
