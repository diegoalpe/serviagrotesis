<?php

    require_once '../negocio/Usuario.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    if (! isset($_POST["p_codigo_usuario"])){
	Funciones::imprimeJSON(500, "Faltan parametros", "");
	exit();
    }
    
    try {
        $objUsuario = new Usuario();
        $codigoUsuario = $_POST["p_codigo_usuario"];
        $resultado = $objUsuario->eliminar($codigoUsuario);
        if ($resultado == true){
            //Eliminó correctamente
            Funciones::imprimeJSON(200, "El Usuario se ha dado de baja satisfactoriamente", "");
        }
    } catch (Exception $exc) {
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }

    