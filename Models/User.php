<?php

namespace Models;

use DateTime;
use PDOException;

class User extends ActiveRecord
{

    protected static $tabla = "User";
    protected static $columnasdb = ["uuid", "full_name", "username", "slug", "email", "password", "token", "verify", "createdAt", "updatedAt"];

    private $uuid;

    private $full_name;

    private $username;

    private $email;

    private $password;

    private $re_password;

    private $createdAt;

    private $updatedAt;

    private $verify;

    private $slug;

    function __construct($args = [])
    {
        $this->uuid = $args["uuid"] ?? null;
        $this->username = $args["username"] ?? "";
        $this->full_name = $args["fullname"] ?? "";
        $this->email = $args["email"] ?? "";
        $this->password = $args["password"] ?? "";
        $this->re_password = $args["re_password"] ?? "";
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->createdAt =  $this->createdAt->format('Y-m-d H:i:s');
        $this->updatedAt =  $this->updatedAt->format('Y-m-d H:i:s');
        $this->verify = 0;
        $this->slug = sanitize(str_replace(" ", "-", trim(strtolower($this->username))));
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function gen_uuid()
    { //
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


    public function validate()
    {
        $errors = [];
        if (empty($this->username)) {
            $errors["username"] = "el campo username es obligatorio.";
        }
        if (empty($this->full_name)) {
            $errors["fullname"] = "el campo nombre completo es obligatorio.";
        }
        if (empty($this->email)) {
            $errors["email"] = "el campo email es obligatorio.";
        }
        if (empty($this->password)) {
            $errors["password"] = "el campo password es obligatorio.";
        }
        if (empty($this->re_password)) {
            $errors["re_password"] = "el campo repetir password es obligatorio.";
        }
        if ($this->re_password != $this->password) {
            $errors["not_equal"] = "las contraseñas no coinciden.";
        }

        return $errors;
    }

    public function validarEmail()
    {
        $result = null;

        try {
            $query = "SELECT * FROM User WHERE email = ?";

            $result = User::consultarSQL($query, [$this->email]);
        } catch (PDOException $th) {
            logg("[MARIADB] Error al consultar.");
        }

        if (isset($result[0])) {
            return $result[0]->email ?? "";
        } else {
            return "";
        }
    }

    public function passwordHash()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearUsuario()
    {
        $this->gen_uuid();
        return $this->crear();
    }

    public function loguear($email, $password)
    {
        $errores = [];

        if (empty($email)) {
            $errors["email"] = "el campo email es obligatorio.";
        }
        if (empty($password)) {
            $errors["password"] = "el campo password es obligatorio.";
        }
        if(!password_verify($password, $this->password)){
            $errors["incorrect_password"] = "el email o contraseña son incorrectos";
        }
        return $errores;
    }
}
