<?php

namespace Models;
class User extends ActiveRecord {
    
    private $tabla;
    private $columnasdb = ["uuid", "nombre", "username", "password", "email"];
    function __construct() {
        
    }
    public $id = "hello world";
}