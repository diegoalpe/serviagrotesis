<?php

require_once '../datos/Conexion.clase.php';

/**
 * Description of Sesion
 *
 * @author laboratorio_computo
 */
class Sesion extends Conexion{
    private $email;
    private $clave;
    private $recordarUsuario;
    
    function getRecordarUsuario() {
        return $this->recordarUsuario;
    }

    function setRecordarUsuario($recordarUsuario) {
        $this->recordarUsuario = $recordarUsuario;
    }

        
    function getEmail() {
        return $this->email;
    }

    function getClave() {
        return $this->clave;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }
    
    public function validarSesion() {
        try {
            $sql = "select * from f_validar_sesion(:p_email,:p_clave)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_email", $this->getEmail());
            $sentencia->bindParam(":p_clave", $this->getClave());
            $sentencia->execute();
            return $sentencia->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function obtenerFoto($codigo_agricultor) {
        $foto = "../imagenes-usuario/" . $codigo_agricultor;
        if (file_exists($foto . ".png")) {
            $foto = $foto . ".png";
        }else if (file_exists($foto . ".jpg")) {
            $foto = $foto . ".jpg";
        }else{
            $foto = "none";
        }
        if ($foto == "none"){
            return $foto;
        }  else {
            return Funciones::$DIRECCION_WEB_SERVICE.$foto;
        }
    }
    
    public function iniciarSesion() {
        try {
            $sql = "
                select
                        a.apellido_paterno,
                        a.apellido_materno,
                        a.nombres,
                        a.clave,
                        a.estado,
                        a.codigo_administrador,
                        a.cargo
                from
                        administrador a 
                where
                        a.email = :p_email
                ";
            
            
            //Creamos una sentencia
            $sentencia = $this->dblink->prepare($sql);
            
            //Vincular el parametro1 p_email con el valor del atribito usuario;
            $sentencia->bindParam(":p_email", $this->getEmail());
            
            //ejecutar la sentencia
            $sentencia->execute();
            
            //Capturar el resultado que devuelve la sentencia
            $resultado = $sentencia->fetch();
            
            if ($resultado["clave"] ==  md5( $this->getClave() ) ){
                if ($resultado["estado"] == "I"){
                    //Usuario inactivo, NO puede ingresar a la app
                    return 0;
                }else{
                    //Usuario activo, Si puede ingresar a la app
                    session_name("Serviagro");
                    session_start();
                    
                    $_SESSION["s_nombre_usuario"] = $resultado["apellido_paterno"]." ".$resultado["apellido_materno"].", ".$resultado["nombres"];
                    $_SESSION["s_cargo"] = $resultado["cargo"];
                    $_SESSION["s_codigo_administrador"] = $resultado["codigo_administrador"];
                    
                    if ($this->getRecordarUsuario()=="S"){
                        //El usuario ha marcado el Check
                        setcookie("loginusuario", $this->getEmail(), 0, "/");
                    }else{
                        setcookie("loginusuario", "", 0, "/");
                    }
                    
                    return 1;
                    
                }
                
            }else{
                //La clave ingresada por el usuario es diferente a la que esta grabada en la BD
                return 2;
            }
        
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }

}
