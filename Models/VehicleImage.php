<?php

namespace Models;


class VehicleImage extends ActiveRecord
{

    protected static $tabla = "vehicle_img";

    protected static $columnasdb = ["vehicle_id", "url", "alt"];

    public $vehicle_id;
    public $url;
    public $alt;

    public function __construct(
        $vehicle_id,
        $url,
        $alt
    ) {
        $this->vehicle_id = $vehicle_id;
        $this->url = $url;
        $this->alt = $alt;
    }


    public function create()
    {
        return $this->crear();
    }
}
