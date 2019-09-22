<?php

require_once '../datos/Conexion.clase.php';

class Tipo_suelo extends Conexion {
    
    private $codigoTipoSuelo;
    private $nombre;
    
    function getNombre() {
        return $this->nombre;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function getCodigoTipoSuelo() {
        return $this->codigoTipoSuelo;
    }

    function setCodigoTipoSuelo($codigoTipoSuelo) {
        $this->codigoTipoSuelo = $codigoTipoSuelo;
    }

    
    public function listarTipoSuelo(){
        try {
            $sql = "select * from tipo_suelo order by 1 asc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function cargarListaDatos(){
        try {
            $sql = "select * from tipo_suelo order by 1";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll();
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
            
    }
    
    public function agregar() {
        $this->dblink->beginTransaction();
        
        try {
            $sql = "select * from f_generar_correlativo('tipo_suelo') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoTipoSu = $resultado["nc"];
                $this->setCodigoTipoSuelo($nuevoCodigoTipoSu);
                
                $sql = "
                        INSERT INTO public.tipo_suelo(
                                codigo_tipo_suelo, nombre)
                        VALUES (:p_codigo_tipo_suelo, :p_nombre);

                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_tipo_suelo", $this->getCodigoTipoSuelo());
                $sentencia->bindParam(":p_nombre", $this->getNombre());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'tipo_suelo'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true; //significa que todo se ha ejecutado correctamente
                
            }else{
                throw new Exception("No se ha configurado el correlativo para la tabla tipo_suelo");
            }
            
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
            
    }
    
    public function editar() {
        $this->dblink->beginTransaction();
        
        try {
           $sql = "     
                    UPDATE public.tipo_suelo
                        SET  nombre = :p_nombre
                      WHERE codigo_tipo_suelo = :p_codigo_tipo_suelo;
               ";
           
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_nombre", $this->getNombre());
            $sentencia->bindParam(":p_codigo_tipo_suelo", $this->getCodigoTipoSuelo());

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
    
    public function leerDatos($codigoTipoSuelo) {
        try {
            $sql = "
                    select
                            *
                    from
                            tipo_suelo
                    where
                            codigo_tipo_suelo = :p_codigo_tipo_suelo
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_tipo_suelo", $codigoTipoSuelo);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function eliminar($codigoTipoSuelo){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from tipo_suelo where codigo_tipo_suelo = :p_codigo_tipo_suelo";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_tipo_suelo", $codigoTipoSuelo);
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