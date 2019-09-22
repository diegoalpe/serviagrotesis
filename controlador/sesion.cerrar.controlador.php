<?php

    session_name("Serviagro");
    session_start();
    
    unset($_SESSION["s_nombre_usuario"]);
    unset($_SESSION["s_cargo"]);
    unset($_SESSION["s_codigo_administrador"]);
    
    session_destroy();
    
    header("location:../vista/index.php");