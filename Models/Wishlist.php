<?php
namespace Models;
use DateTime;
use PDOException;

class Wishlist extends ActiveRecord {

    protected static $tabla = "Wishlist";
    protected static $columnasdb = ["wish_id", "customer_uuid", "item_id", "addedAt"];

    protected $wish_id, $customer_uuid, $item_id, $addedAt;

    function __construct($args = []) {
        $this->wish_id = $args[""] ?? null;
        $this->customer_uuid = $args[""] ?? "";
        $this->item_id = $args[""] ?? "";
        $this->addedAt = new DateTime();
        $this->addedAt =  $this->addedAt->format('Y-m-d H:i:s');
    }
}
