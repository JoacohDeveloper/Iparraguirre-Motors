<?php

namespace Models;

use DateTime;
use PDOException;
use PDO;
//Este es un modelo que hereda a ActiveRecord dentro de este modelo se especifica el nombre de la tabla SQL y las columnas. Es importante que cuando agreguemos datos a columnasdb al momento de hacer una operacion de Active Record se utilicen todos los campos, sin haber ningun dato vacío.


class User extends ActiveRecord
{

    protected static $tabla = "user";

    protected static $columnasdb = ["uuid", "full_name", "username", "slug", "bio", "email", "password", "titulo_imagen", "imagen", "token", "userType", "isFirstLog", "isDeleted", "verify", "createdAt", "updatedAt"];

    protected $uuid;

    protected $full_name;

    protected $username;

    protected $bio;

    protected $email;

    protected $token;

    protected $password;

    protected $re_password;

    protected $titulo_imagen;

    protected $imagen;

    protected $userType;

    protected $isFirstLog;

    protected $isDeleted;

    protected $createdAt;

    protected $updatedAt;

    protected $verify;

    protected $slug;

    function __construct($args = [])
    {
        $this->uuid = $args["uuid"] ?? null;
        $this->username = $args["username"] ?? "";
        $this->full_name = $args["full_name"] ?? "";
        $this->bio = $args["bio"] ?? "";
        $this->email = $args["email"] ?? "";
        $this->password = $args["password"] ?? "";
        $this->re_password = $args["re_password"] ?? "";
        date_default_timezone_set('America/Montevideo');
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->createdAt =  $this->createdAt->format('Y-m-d H:i:s');
        $this->updatedAt =  $this->updatedAt->format('Y-m-d H:i:s');
        $this->verify = 0;
        $this->userType = $args["userType"] ?? "Empleado";
        $this->isFirstLog = $args["isFirstLog"] ?? 1;
        $this->isDeleted = $args["isDeleted"] ?? 0;
        $this->token = null;
        $this->titulo_imagen = "imagen default de usuario";
        $this->imagen = $args["imagen"] ?? "\build\src\images\users\default.jpg";
        $this->slug = sanitize(str_replace(" ", "-", trim(strtolower($this->username))));
    }

    public function getEmail()
    {
        return $this->email;
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
        if (empty($this->email)) {
            $errors["email"] = "el campo email es obligatorio.";
        } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "formato de email invalido";
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "formato de email invalido";
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

        if ($this->imagen) {
            $fileExtArray = explode(".", $this->imagen);
            $fileExt = $fileExtArray[count($fileExtArray) - 1];

            $extensiones = ["jpg", "png", "webp", "jpeg"];

            if (!in_array($fileExt, $extensiones)) {
                $errors["tipo_imagen"] = "el archivo no es de formato imagen";
            }
        }

        return $errors;
    }

    public static function getUser($dato) //dato puede ser email o username
    {
        $result = null;
        try {
            $query = "SELECT * FROM ". self::$tabla ." WHERE email = ? or username = ? LIMIT 1";
            $result = User::consultarSQL($query, [$dato, $dato]);
        } catch (PDOException $th) {
            logg("[MARIADB] Error al consultar.");
        }

        return $result[0] ?? null;
    }

    public function passwordHash()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    public function defaultPasswordHash($defaultPassword)
    {
        $this->password = password_hash($defaultPassword, PASSWORD_BCRYPT);
    }
    public function defaultEmail($defaultEmail)
    {
        $this->email = $defaultEmail;
    }

    public function crearUsuario()
    {
        $this->gen_uuid();
        return $this->crear();
    }

    public static function getAllAdmins() {
        try {
            $query = "SELECT * FROM ". self::$tabla;
            $stmt = static::$db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function usernameRepeat($dato)
    {
        $result = null;
        try {
            $query = "SELECT * FROM  ". self::$tabla ."
                      WHERE username = :dato";
            $params = [
                ':dato' => $dato
            ];
            $stmt = static::$db->prepare($query);
            $stmt->execute($params);
            $result = ($stmt->fetch(PDO::FETCH_ASSOC));
            return isset( $result["uuid"]) ? $result : false;
        } catch (PDOException $th) {
            return $result;
        }
    }

    public function actualizarUsuario()
    {
        date_default_timezone_set('America/Montevideo');
        $this->updatedAt = new DateTime();
        $this->updatedAt = $this->updatedAt->format('Y-m-d H:i:s');
        $this->isFirstLog = 0; //Se da por hecho que si actualizo el usuario, no es su primer log
        return $this->actualizar($this->uuid);
    }

    public function actualizarUsuarioDefault($new_password){
        date_default_timezone_set('America/Montevideo');
        $this->updatedAt = new DateTime();
        $this->updatedAt = $this->updatedAt->format('Y-m-d H:i:s');
        $this->isFirstLog = 0;
        $this->password = password_hash($new_password, PASSWORD_BCRYPT);
        return $this->actualizar($this->uuid);
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

    public function validarPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function deleteUser(){
        $result = null;
        try {
            $result = $this->eliminar($this->uuid);
        } catch (PDOException $th) {
            logg("[MARIADB] Error al consultar.");
        }
        return $result;
    }

    public function masterAccount(){
        if(self::getUser("iparraguirremotors@contact.shop") == null){
            date_default_timezone_set('America/Montevideo');
            $this->createdAt = new DateTime();
            $this->updatedAt = new DateTime();
            $this->createdAt =  $this->createdAt->format('Y-m-d H:i:s');
            $this->updatedAt =  $this->updatedAt->format('Y-m-d H:i:s');
            self::gen_uuid();
            self::defaultPasswordHash("alvaromotors775");
            try {
                $query = "INSERT INTO ". self::$tabla ." (uuid, full_name, username, slug, bio, email, password, titulo_imagen, imagen, token, userType, isFirstLog, isDeleted, verify, createdAt, updatedAt) 
                        VALUES (:uuid, :full_name, :username, :slug, :bio, :email, :password, :titulo_imagen, :imagen, :token, :userType, :isFirstLog, :isDeleted, :verify, :createdAt, :updatedAt)";
                $params = [
                    ':uuid' => $this->uuid,
                    ':full_name' => 'Alvaro Iparraguirre',
                    ':username' => 'IparraguirreMotors',
                    ':slug' => 'iparraguirremotors',
                    ':bio' => 'Cuenta principal de IparraguirreMotors',
                    ':email' => 'iparraguirremotors@contact.shop',
                    ':password' => $this->password,
                    ':titulo_imagen' => 'Imagen de IparraguirreMotors',
                    ':imagen' => '/build/src/images/LOGO2.png',
                    ':token' => '',
                    ':userType' => 'Root',
                    ':isFirstLog' => 0,
                    ':isDeleted' => 0,
                    ':verify' => 1,
                    ':createdAt' => $this->createdAt, 
                    ':updatedAt' => $this->updatedAt
                ];
                $stmt = static::$db->prepare($query);
                return $stmt->execute($params);
            } catch (PDOException $th) {
                // Manejo de errores
                //return "Error al registrar el usuario: " . $th->getMessage();
                return $params;
            }
        } else {
            return "La cuenta maestra ya fue registrada";
        }
    }

    public static function adminForceDeleting($recivedUUID) {
        $result = null;
        try {
            $query = "UPDATE ". self::$tabla ." SET isDeleted = 1 WHERE uuid = :uuid";
            $params = [':uuid' => $recivedUUID];
            $stmt = static::$db->prepare($query);
            $result = $stmt->execute($params);
        } catch (PDOException $th) {
            logg("[MARIADB] Error al consultar: " . $th->getMessage());
            return false;
        }
        return $result;
    }

    public static function adminForceActiving($recivedUUID) {
        $result = null;
        try {
            $query = "UPDATE ". self::$tabla ." SET isDeleted = 0 WHERE uuid = :uuid";
            $params = [':uuid' => $recivedUUID];
            $stmt = static::$db->prepare($query);
            $result = $stmt->execute($params);
        } catch (PDOException $th) {
            logg("[MARIADB] Error al consultar: " . $th->getMessage());
            return false;
        }
        return $result;
    }

    public static function adminForceChangeRol($recivedUUID, $newRol) {
        $result = null;
        try {
            $query = "UPDATE " . self::$tabla . " SET userType = :newRol WHERE uuid = :uuid";
            $params = [
                ':uuid' => $recivedUUID,
                ':newRol' => $newRol
            ];
            $stmt = static::$db->prepare($query);
            $result = $stmt->execute($params);
        } catch (PDOException $th) {
            logg("[MARIADB] Error al consultar: " . $th->getMessage());
            return false;
        }
        return $result;
    }    
    
    public function changePassword($new_password){
        $result = null;
        $this->password = password_hash($new_password, PASSWORD_BCRYPT);
        try {
            return $this->actualizar($this->uuid);
        } catch (PDOException $th) {
            logg("[MARIADB] Error al consultar.");
        }
        return $result;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getDeleted()
    {
        return boolval($this->isDeleted);
    }

    public function getCreated(){
        if ($this->createdAt instanceof \DateTime) {
            return $this->createdAt;
        } else {
            return new \DateTime($this->createdAt);
        }
    }
    public function getUpdated(){
        if ($this->updatedAt instanceof \DateTime) {
            return $this->updatedAt;
        } else {
            return new \DateTime($this->updatedAt);
        }
    }

    public function getFullName()
    {
        return $this->full_name;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function getBio(){
        return $this->bio;
    }

    public function getNombreImagen()
    {
        return $this->titulo_imagen;
    }

    public function getNombreImagen_Url()
    {
        return ["url" => $this->getImagen(), "alt" => $this->getNombreImagen()];
    }

    public function isAdmin(){
        if($this->userType == "Empleado" || $this->userType == "Encargado" || $this->userType == "Root") return true;
        return false;
    }

    public function isEncargado(){
        if($this->userType == "Encargado" || $this->userType == "Root") return true;
        return false;
    }

    public function isFirstLog(){
        return boolval($this->isFirstLog);
    }

    public function defaultImage()
    {
        $result = null;
        $this->imagen = "\build\src\images\users\default.jpg";
        try { 
            $query = "UPDATE  ". self::$tabla ." SET 
                      imagen = :imagen
                      WHERE uuid = :uuid";
            $params = [
                ':imagen' => $this->imagen,
                ':uuid' => $this->uuid
            ];
            $stmt = static::$db->prepare($query);
            $result = $stmt->execute($params);
            return $result;
        } catch (PDOException $th) {
            return null;
        }
    }
}
