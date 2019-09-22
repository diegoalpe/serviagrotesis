<?php

require_once '../datos/Conexion.clase.php';

class Distrito extends Conexion{
    private $codigo_departamento;
    private $codigo_provincia;
    private $codigo_distrito;
    private $nombre;
    
    
    function getCodigo_departamento() {
        return $this->codigo_departamento;
    }

    function getCodigo_provincia() {
        return $this->codigo_provincia;
    }

    function getCodigo_distrito() {
        return $this->codigo_distrito;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setCodigo_departamento($codigo_departamento) {
        $this->codigo_departamento = $codigo_departamento;
    }

    function setCodigo_provincia($codigo_provincia) {
        $this->codigo_provincia = $codigo_provincia;
    }

    function setCodigo_distrito($codigo_distrito) {
        $this->codigo_distrito = $codigo_distrito;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

        
    public function listar( $p_codigo_departamento, $p_codigo_provincia) {
        try {
            $sql = "select * from f_listar_distrito(:p_codigo_departamento,:p_codigo_provincia)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_departamento", $p_codigo_departamento);
            $sentencia->bindParam(":p_codigo_provincia", $p_codigo_provincia);
            $sentencia->execute();            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);            
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function leerDatos($codigo_distrito) {
        try {
            $sql = "select * from distrito where codigo_distrito = :p_codigo_distrito";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindparam(":p_codigo_distrito",$codigo_distrito);
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
                    UPDATE public.distrito
                        SET  nombre=:p_nombre, codigo_departamento=:p_codigo_departamento, codigo_provincia=:p_codigo_provincia
                      WHERE codigo_distrito=:p_codigo_distrito
               ";
           
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_nombre", $this->getNombre());
            $sentencia->bindParam(":p_codigo_departamento", $this->getCodigo_departamento());
            $sentencia->bindParam(":p_codigo_provincia", $this->getCodigo_provincia());
            $sentencia->bindParam(":p_codigo_distrito", $this->getCodigo_distrito());

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
            $sql = "select * from f_generar_correlativo('distrito') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoDis = $resultado["nc"];
                $this->setCodigo_distrito($nuevoCodigoDis);
                
                    $sql = "
                        INSERT INTO public.distrito(
                                codigo_departamento,
                                codigo_provincia,
                                codigo_distrito,
                                nombre)
                        VALUES (                               
                                :p_codigo_departamento, 
                                :p_codigo_provincia,
                                :p_codigo_distrito,
                                :p_nombre)
                        ;
                        ";

                    //Preparar la sentencia
                    $sentencia = $this->dblink->prepare($sql);

                    //Asignar un valor a cada parametro
                    $sentencia->bindParam(":p_codigo_departamento", $this->getCodigo_departamento());
                    $sentencia->bindParam(":p_codigo_provincia", $this->getCodigo_provincia());
                    $sentencia->bindParam(":p_codigo_distrito", $this->getCodigo_distrito());
                    $sentencia->bindParam(":p_nombre", $this->getNombre());
                    //Ejecutar la sentencia preparada
                    $sentencia->execute();

                    $sql = "update correlativo set numero = numero + 1 where tabla = 'distrito'";
                    $sentencia = $this->dblink->prepare($sql);
                    $sentencia->execute();
                
                    
                    $this->dblink->commit();
                
                    return true; //significa que todo se ha ejecutado correctamente
                }else{
                throw new Exception("No se ha configurado el correlativo para la tabla distrito");
                }               
        }catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
            
    }
    
    public function eliminar($codigo_distrito){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from distrito where codigo_distrito = :p_codigo_distrito";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_distrito", $codigo_distrito);
            $sentencia->execute();
            
            $this->dblink->commit();
            
            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        
        return false;
    }
    
    public function cargarListaDatos(){
        try {
            $sql = "select * from distrito order by 1";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll();
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
            
    }
    
}
