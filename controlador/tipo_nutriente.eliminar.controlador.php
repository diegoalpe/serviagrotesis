<?php

    require_once '../negocio/Tipo_nutriente.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    if (! isset($_POST["p_codigo_tipo_nutriente"])){
	Funciones::imprimeJSON(500, "Faltan parametros", "");
	exit();
    }
    
    try {
        $objTipoNu = new Tipo_nutriente();
        $codigoTipoNu = $_POST["p_codigo_tipo_nutriente"];
        $resultado = $objTipoNu->eliminar($codigoTipoNu);
        if ($resultado == true){
            //Eliminó correctamente
            Funciones::imprimeJSON(200, "El registro se ha eleiminado satisfactoriamente", "");
        }
    } catch (Exception $exc) {
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }

    