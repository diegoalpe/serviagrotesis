<?php

require_once '../negocio/Cliente.clase.php';
require_once 'token.validar.php';
require_once '../util/funciones/Funciones.clase.php';

if (!isset($_POST["token"])) {
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}

$token = $_POST["token"];


try {
    if (validarToken($token)) { //token valido
        $obj = new Cliente();
        $resultado = $obj->listar();

        Funciones::imprimeJSON(200, "", $resultado);
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}