<?php

require_once '../datos/Conexion.clase.php';

class Usuario extends Conexion {
    private $codigoUsuario;
    private $clave;
    private $codigoAgricultor;
    
    function getCodigoUsuario() {
        return $this->codigoUsuario;
    }

    function getClave() {
        return $this->clave;
    }

    function getCodigoAgricultor() {
        return $this->codigoAgricultor;
    }

    function setCodigoUsuario($codigoUsuario) {
        $this->codigoUsuario = $codigoUsuario;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }


    function setCodigoAgricultor($codigoAgricultor) {
        $this->codigoAgricultor = $codigoAgricultor;
    }

        
    public function listar(){
        try {
            $sql = "SELECT 
                    usuario.codigo_usuario,
                    (agricultor.apellido_paterno||' '||agricultor.apellido_materno||' '||agricultor.nombres) as nombre_completo,
                     agricultor.usuario,
                    (case when usuario.estado = 'A' then 'ACTIVO' else 'INACTIVO' end) as estado
                  FROM 
                    public.usuario, 
                    public.agricultor
                  WHERE 
                    agricultor.codigo_agricultor = usuario.codigo_agricultor;";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }


    
    public function leerDatos($codigoUsuario) {
        try {
            $sql = "
                    select
                            codigo_usuario
                    from
                            usuario
                    where
                            codigo_usuario = :p_codigo_usuario
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_usuario", $codigoUsuario);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function editar() {
        $this->dblink->beginTransaction();
        
        try {
           $sql = "     
                    UPDATE public.usuario
                        SET estado = 'I'
                      WHERE codigo_usuario = :p_codigo_usuario;
               ";
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":codigo_usuario", $this->getCodigoUsuario());

            //Ejecutar la sentencia preparada
            $sentencia->execute();
            
            
            $this->dblink->commit();
                
            return true;
            
        } catch (Exception $exc) {
           $this->dblink->rollBack();
           throw $exc;
        }
        
        return false;
            
    }
    
    public function agregar() {
        $this->dblink->beginTransaction();
        
        try {
            $sql = "select * from f_generar_correlativo('usuario') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigousuario = $resultado["nc"];
                $this->setCodigoUsuario($nuevoCodigousuario);
                
                $sql = "
                        INSERT INTO public.usuario(
                                codigo_usuario, 
                                codigo_agricultor, 
                                clave)
                        VALUES (
                                :p_codigo_usuario, 
                                :p_codigo_agricultor, 
                                :p_clave);
                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_usuario", $this->getCodigoUsuario());
                $sentencia->bindParam(":p_codigo_agricultor", $this->getCodigoAgricultor());
                $sentencia->bindParam(":p_clave", $this->getClave());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'usuario'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true; //significa que todo se ha ejecutado correctamente
                
            }else{
                throw new Exception("No se ha configurado el correlativo para la tabla usuario");
            }
            
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
            
    }
    
    public function eliminar( $p_codigo_usuario ){
        $this->dblink->beginTransaction();
        try {
            $sql = "    
                    UPDATE public.usuario
                        SET estado = 'I'
                      WHERE codigo_usuario = :p_codigo_usuario
               ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_usuario", $p_codigo_usuario);
            $sentencia->execute();
            
            $this->dblink->commit();
            
            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        
        return false;
    }
    
}
