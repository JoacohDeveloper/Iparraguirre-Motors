<?php


namespace Controllers;

use Models\Refractions;

abstract class RefractionsRestController
{

    public static function create()
    {
        header('Content-Type: application/json;');

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
        }
    }

    public static function refractions()
    {
        header('Content-Type: application/json;');

        try {
            $refractionId = isset($_GET["id"]) ? intval($_GET["id"]) : null;
            $refractionPage = isset($_GET["page"]) ? intval($_GET["page"]) : null;
            $refractionName = isset($_GET["name"]) ? trim(strtolower($_GET["name"])) : null;

            if ($refractionPage && $refractionName) {
                $refractions = Refractions::getAllrefractionsByPage($refractionPage, $refractionName);
                echo json_encode($refractions);
                exit;
            } else if ($refractionPage) {
                $refractions = Refractions::getAllrefractionsByPage($refractionPage);
            } else {
                $refractions = Refractions::getAllrefractions();
            }



            if ($refractionId) {
                foreach ($refractions as $refraction) {
                    if ($refraction instanceof Refractions) {
                        if ($refraction->product->product_id == $refractionId) {
                            echo json_encode($refraction);
                            exit;
                        }
                    }
                }
                echo json_encode(["message" => "404"]);
                exit;
            } else if ($refractionName) {
                $resultado = array_filter($refractions, function ($v) {
                    $refractionName = isset($_GET["name"]) ? trim(strtolower($_GET["name"])) : null;

                    if ($v instanceof Refractions) {
                        if (str_contains(trim(strtolower($v->product->nombre)), $refractionName)) {
                            return $v;
                        }
                    }
                });

                if (count($resultado) > 0)
                    echo json_encode($resultado);
                else
                    echo json_encode(["message" => "404"]);
                exit;
            }

            echo json_encode($refractions);
        } catch (\Exception $e) {
            echo json_encode(["error" => "Error en la base de datos: " . $e->getMessage()]);
        }
        exit;
    }
}
