<?php
namespace Models;
use DateTime;
use PDOException;
use PDO;

class Testdrive extends ActiveRecord {

    protected static $tabla = "testdrive";
    protected static $columnasdb = ["testID", "userUUID", "productID", "productName", "reservedDate", "createdAt"];

    protected $testID, $userUUID, $productID, $productName, $reservedDate, $createdAt;

    function __construct($args = []) {
        $this->testID = $args["testID"] ?? null;
        $this->userUUID = $args["userUUID"] ?? "";
        $this->productID = $args["productID"] ?? "";
        $this->productName = $args["productName"] ?? "";
        $this->reservedDate = new DateTime();
        $this->reservedDate =  $args["reservedDate"] ?? "";
        $this->createdAt = new DateTime();
        $this->createdAt =  $this->createdAt->format('Y-m-d H:i:s');
    }

    public function crearTestDrive() {
        try {
            $query = "INSERT INTO " . self::$tabla . " (userUUID, productID, productName, reservedDate, createdAt) 
                      VALUES (:userUUID, :productID, :productName, :reservedDate, :createdAt)";
            
            $params = [
                ':userUUID' => $this->userUUID,
                ':productID' => $this->productID,
                ':productName' => $this->productName,
                ':reservedDate' => $this->reservedDate,
                ':createdAt' => $this->createdAt
            ];
    
            $stmt = static::$db->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $th) {
            return false;
        }
    }

    public static function obtenerTestDrive($userUUID) {
        try {
            $query = "SELECT * FROM " . self::$tabla . " WHERE userUUID = :userUUID ORDER BY reservedDate ASC";
            
            $stmt = static::$db->prepare($query);
            $stmt->bindParam(':userUUID', $userUUID);
            $stmt->execute();
            
            $testDrives = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($testDrives)) {
                return [];
            }
            
            return $testDrives;
        } catch (PDOException $e) {
            error_log("Error en obtenerTestDrive: " . $e->getMessage());
            return false;
        }
    }    
}
