<?php
namespace Models;
use DateTime;
use PDO;
use PDOException;

class Interactions extends ActiveRecord {

    protected static $tabla = "interactions";
    protected static $columnasdb = ["interactionID", "interactionOwner", "interactionType",
        "interactionCost", "productName", "productType", "productLink", "isPrivate", "interactionDate"];

    public $interactionID, $interactionOwner, $interactionType, $interactionCost, $productName, $productType, $productLink, $isPrivate, $interactionDate;

    function __construct() {
        $this->interactionID = null;
        $this->interactionOwner = null;
        $this->interactionType = "";
        $this->interactionCost = "";
        $this->productName = "";
        $this->productType = "";
        $this->productLink = "";
        $this->isPrivate = false;
        $this->interactionDate = new DateTime();
        $this->interactionDate = $this->interactionDate->format('Y-m-d H:i:s');
    }

    function generateID() {
        $minLength = 10;
        $maxLength = 25;
        $length = rand($minLength, $maxLength);
        $generatedID = '';
        for ($i = 0; $i < $length; $i++) {
            $generatedID .= rand(0, 9);
        }
        return $generatedID;
    }

    public function createInteraction($userUUID, $tipo, $precio, $nameOfProduct, $typeOfProduct, $private) {
        date_default_timezone_set('America/Montevideo');
        $this->interactionDate = new DateTime();
        $this->interactionDate = $this->interactionDate->format('Y-m-d H:i:s');
        $this->interactionOwner = $userUUID ?? null;
        $this->interactionType = $tipo ?? null;
        $this->interactionCost = $precio ?? 0;
        $this->productName = $nameOfProduct ?? null;
        $this->productType = $typeOfProduct ?? null;
    
        if ($typeOfProduct == "Vehicle") {
            $this->productLink = "/dashboard/products/vehicle?search=" . $nameOfProduct ?? "";
        } else if ($typeOfProduct == "Refraction") {
            $this->productLink = "/dashboard/products/refraction?search=" . $nameOfProduct ?? "";
        } else {
            $this->productLink = null;
        }
    
        $this->isPrivate = $private ? 1 : 0;
        $this->interactionID = $this->generateID();
    
        try {
            $query = "INSERT INTO ". self::$tabla ." (interactionID, interactionOwner, interactionType, interactionCost, productName, productType, productLink, isPrivate, interactionDate) 
                      VALUES (:interactionID, :interactionOwner, :interactionType, :interactionCost, :productName, :productType, :productLink, :isPrivate, :interactionDate)";
            $params = [
                ':interactionID' => $this->interactionID,
                ':interactionOwner' => $this->interactionOwner,
                ':interactionType' => $this->interactionType,
                ':interactionCost' => $this->interactionCost,
                ':productName' => $this->productName,
                ':productType' => $this->productType,
                ':productLink' => $this->productLink,
                ':isPrivate' => $this->isPrivate,
                ':interactionDate' => $this->interactionDate
            ];            
            $stmt = static::$db->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $th) {
            return $th;
        }
    }

    public function getInteraction($userUUID, $adminType) {
        $params = [':interactionOwner' => $userUUID];
    
        try {
            if ($adminType == 1) {
                $query = "SELECT * FROM ". self::$tabla ." WHERE interactionOwner = :interactionOwner";
            } else {
                $query = "SELECT * FROM ". self::$tabla ." WHERE interactionOwner = :interactionOwner AND isPrivate = 0";
            }
    
            $result = Interactions::consultarSQL($query, $params);
    
            // Formateamos la fecha de todas las interacciones que se traen.
            foreach ($result as $row) {
                // Convertimos el resultado en un array para manejarlo correctamente.
                $rowArray = get_object_vars($row);
                $datetime = new DateTime($rowArray['interactionDate']);
                $rowArray['interactionDate'] = $datetime->format('H:i:s d-m-Y');
                // Se actualiza el array con el nuevo formato de fecha.
                foreach ($rowArray as $key => $value) {
                    $row->$key = $value;
                }
            }
    
            return $result;
        } catch (PDOException $th) {
            return null;
        }
    }

    public function delete($id){
        try {
            $query = "DELETE FROM ". self::$tabla ." WHERE interactionID = :interactionID";
            $params = [
                ':interactionID' => $id
            ];
            $result = Interactions::consultarSQL($query, $params);
            return $result;
        } catch (PDOException $th) {
            return null;
        }
    }
}