<?php

namespace Models;

use DateTime;
use PDOException;

class Cart extends ActiveRecord
{

    protected static $tabla = "Cart";
    protected static $columnasdb = ["cart_id", "customer_uuid", "item_id", "cantidad", "addedAt"];

    protected $cart_id, $customer_uuid, $item_id, $cantidad, $addedAt;

    function __construct($args = [])
    {
        $this->cart_id = $args[""] ?? null;
        $this->customer_uuid = $args[""] ?? "";
        $this->item_id = $args[""] ?? "";
        $this->cantidad = $args[""] ?? "";
        $this->addedAt = new DateTime();
        $this->addedAt =  $this->updatedAt->format('Y-m-d H:i:s');
    }
}
