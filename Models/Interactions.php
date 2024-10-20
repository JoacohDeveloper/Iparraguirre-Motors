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
        $this->interactionDate = $this->interactionDate->format('H:i:s d-m-Y');
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
        $this->interactionDate = $this->interactionDate->format('H:i:s d-m-Y');
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
            $query = "INSERT INTO interactions (interactionID, interactionOwner, interactionType, interactionCost, productName, productType, productLink, isPrivate, interactionDate) 
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
            return $null;
        }
    }

    public function getInteraction($userUUID){
        try {
            $query = "SELECT * FROM interactions WHERE interactionOwner = :interactionOwner";
            $params = [
                ':interactionOwner' => $userUUID
            ];
            $result = Interactions::consultarSQL($query, $params);
            return $result;
        } catch (PDOException $th) {
            return null;
        }
    }

    public function delete($id){
        try {
            $query = "DELETE FROM interactions WHERE interactionID = :interactionID";
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