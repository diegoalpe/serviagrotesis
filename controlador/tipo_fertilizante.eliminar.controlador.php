<?php

    require_once '../negocio/Tipo_fertilizante.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    if (! isset($_POST["p_codigo_tipo_fertilizante"])){
	Funciones::imprimeJSON(500, "Faltan parametros", "");
	exit();
    }
    
    try {
        $objTipoFer = new Tipo_fertilizante();
        $codigoTipoFer = $_POST["p_codigo_tipo_fertilizante"];
        $resultado = $objTipoFer->eliminar($codigoTipoFer);
        if ($resultado == true){
            //Eliminó correctamente
            Funciones::imprimeJSON(200, "El registro se ha eleiminado satisfactoriamente", "");
        }
    } catch (Exception $exc) {
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }

    