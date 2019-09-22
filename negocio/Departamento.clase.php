<?php

require_once '../datos/Conexion.clase.php';

class Departamento extends Conexion {
    
    private $codigoDepartamento;
    private $nombre;
    
    function getNombre() {
        return $this->nombre;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function getCodigoDepartamento() {
        return $this->codigoDepartamento;
    }

    function setCodigoDepartamento($codigoDepartamento) {
        $this->codigoDepartamento = $codigoDepartamento;
    }

        
    public function listarDepartamento(){
        try {
            $sql = "select * from departamento order by 1 asc";
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
            $sql = "select * from departamento order by 1";
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
            $sql = "select * from f_generar_correlativo('departamento') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoDepar = $resultado["nc"];
                $this->setCodigoDepartamento($nuevoCodigoDepar);
                
                $sql = "
                        INSERT INTO public.departamento(
                                codigo_departamento, nombre)
                        VALUES (:p_codigo_departamento, :p_nombre);
                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_departamento", $this->getCodigoDepartamento());
                $sentencia->bindParam(":p_nombre", $this->getNombre());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'departamento'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true; //significa que todo se ha ejecutado correctamente
                
            }else{
                throw new Exception("No se ha configurado el correlativo para la tabla departamento");
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
                    UPDATE public.departamento
                        SET  nombre = :p_nombre
                      WHERE codigo_departamento = :p_codigo_departamento;
               ";
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_nombre", $this->getNombre());
            $sentencia->bindParam(":p_codigo_departamento", $this->getCodigoDepartamento());

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
    
    public function leerDatos($codigoDepartamento) {
        try {
            $sql = "
                    select
                            *
                    from
                            departamento
                    where
                            codigo_departamento = :p_codigo_departamento
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_departamento", $codigoDepartamento);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function eliminar($codigoDepartamento){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from departamento where codigo_departamento = :p_codigo_departamento";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_departamento", $codigoDepartamento);
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