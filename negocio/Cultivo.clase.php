<?php

require_once '../datos/Conexion.clase.php';

class Cultivo extends Conexion {
    private $codigo_cultivo;
    private $nombre;
    private $semilla;
    private $codigo_agricultor;
    
    function getCodigo_cultivo() {
        return $this->codigo_cultivo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getSemilla() {
        return $this->semilla;
    }

    function getCodigo_agricultor() {
        return $this->codigo_agricultor;
    }

    function setCodigo_cultivo($codigo_cultivo) {
        $this->codigo_cultivo = $codigo_cultivo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setSemilla($semilla) {
        $this->semilla = $semilla;
    }

    function setCodigo_agricultor($codigo_agricultor) {
        $this->codigo_agricultor = $codigo_agricultor;
    }
    
    
    public function listar($p_codigoAgricultor){
        try {
            $sql = "select * from f_listar_cultivo(:p_codigo_agricultor)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindparam(":p_codigo_agricultor", $p_codigoAgricultor);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }

        }
    
public function listar2() {
        try {
            $sql = " SELECT 
                        *
                    FROM 
                        cultivo
                    ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function cargarListaDatos($p_codigoAgricultor){
	try {
            $sql = " select * from cultivo where codigo_agricultor = :p_codigo_agricultor order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_agricultor", $p_codigoAgricultor);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function cargarListaDatosCultivo($p_codigoAgricultor){
	try {
            $sql = " select nombre from cultivo where codigo_agricultor = :p_codigo_agricultor order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_agricultor", $p_codigoAgricultor);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function leerDatos($codigoCul) {
        try {
            $sql = "
                    select
                            *
                    from
                            cultivo
                    where
                            codigo_cultivo = :p_codigo_cultivo
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_cultivo", $codigoCul);
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
                    UPDATE public.cultivo
                        SET nombre = :p_nombre, semilla = :p_semilla, codigo_agricultor = :p_codigo_agricultor
                      WHERE codigo_cultivo = :p_codigo_cultivo;

               ";
           
           //Preparar la sentencia
            $sentencia = $this->dblink->prepare($sql);

            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_nombre", $this->getNombre());
            $sentencia->bindParam(":p_semilla", $this->getSemilla());
            $sentencia->bindParam(":p_codigo_agricultor", $this->getCodigo_agricultor());
            $sentencia->bindParam(":p_codigo_cultivo", $this->getCodigo_cultivo());

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
            $sql = "select * from f_generar_correlativo('cultivo') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoCodigoCul = $resultado["nc"];
                $this->setCodigo_cultivo($nuevoCodigoCul);
                
                $sql = "
                        INSERT INTO public.cultivo(
                                codigo_cultivo, 
                                nombre, 
                                semilla,
                                codigo_agricultor)
                        VALUES (
                                :p_codigo_cultivo, 
                                :p_nombre,
                                :p_semilla,
                                :p_codigo_agricultor
                        );
                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_cultivo", $this->getCodigo_cultivo());
                $sentencia->bindParam(":p_nombre", $this->getNombre());
                $sentencia->bindParam(":p_semilla", $this->getSemilla());
                $sentencia->bindParam(":p_codigo_agricultor", $this->getCodigo_agricultor());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();
                
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'cultivo'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                $this->dblink->commit();
                
                return true; //significa que todo se ha ejecutado correctamente
                
            }else{
                throw new Exception("No se ha configurado el correlativo para la tabla cultivo");
            }
            
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
            
    }
    
    public function eliminar( $p_codigo_cultivo ){
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from cultivo where codigo_cultivo = :p_codigo_cultivo";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_cultivo", $p_codigo_cultivo);
            $sentencia->execute();
            
            $this->dblink->commit();
            
            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }
        
        return false;
    
}



public function obtenerFoto($codigoCultivo) {
        
         $foto = "../imagenes/cultivo/".$codigoCultivo;
        
        if(file_exists($foto . ".png")){
            $foto = $foto . ".png";
            
        }else if(file_exists($foto . ".PNG")){
            $foto = $foto . ".PNG";
            
        }else if(file_exists($foto . ".jpg")){
            $foto = $foto . ".jpg";
            
        }else if(file_exists($foto . ".JPG")){
            $foto = $foto . ".JPG";
            
        }else{
            $foto = "none";
        }
        
        if ($foto == "none"){
            return $foto;
        }else{
            return Funciones::$DIRECCION_WEB_SERVICE . $foto;
        }
    }
}