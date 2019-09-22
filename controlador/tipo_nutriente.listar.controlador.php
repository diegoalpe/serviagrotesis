<?php

require_once '../negocio/Tipo_nutriente.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objTipoNu = new Tipo_nutriente();
    $resultado = $objTipoNu->listarTipoNutriente();
    Funciones::imprimeJSON(200, "", $resultado);
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}