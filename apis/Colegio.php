<?php

/**
 * Representa el la estructura de las categorias
 * almacenadas en la base de datos
 */
require_once 'database.php';

class Colegio
{
    function __construct()
    {
    }

    /**
     * Retorna en la fila especificada de la tabla 'vappCategoria'
     *
     * @param $idCategoria Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll()
    {
    	$filtro="";
        $consulta = "SELECT idcolegio, nombreColegio, CreaColegio FROM curcolegio ";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
			// no se estaba devolviendl el resultado en formato JSON
			// con esta linea se logro...
			// usar en vez de return echo, aunque no se si funcionara con ANDROID
            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return ($e->getMessage());
        }
    }
    
    
   public static function contar()
    {
    		
        $consulta = "SELECT count(*) from curcolegio";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return $e;
        }
    }


    /**
     * Obtiene los campos de una categoria con un identificador
     * determinado
     *
     * @param $idcategoria Identificador de la categoria
     * @return mixed
     */
    public static function getById($idcolegio)
    {
        // Consulta de la categoria
        $consulta = "SELECT idcolegio, nombreColegio, CreaColegio FROM curcolegio WHERE idcolegio = $idcolegio";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idcolegio));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
            //echo json_encode($row);

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return -1;
        }
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     *
     * @param $idcategoria      identificador
     * @param $nombre      nuevo titulo
     * 
     */
    public static function update($idcolegio, $nombreColegio, $CreaColegio )
    {
        // Creando consulta UPDATE
         
        $consulta = "UPDATE curcolegio  
        				SET nombreColegio='$nombreColegio' ,
        				CreaColegio = '$CreaColegio'
        					WHERE idcolegio= $idcolegio";
//		echo "$consulta";
        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($idcolegio, $nombreColegio, $CreaColegio));

        //return $cmd;
		echo json_encode($cmd);
    }

    /**
     * Insertar un nuevo categoria
     *
     * @param $idcategoria      titulo del nuevo registro
     * @param $nombre descripción del nuevo registro
     * @return PDOStatement
     */
    public static function insert($nombreColegio,$CreaColegio){
        // Sentencia INSERT
        
        $comando = "INSERT INTO curcolegio(nombreColegio, CreaColegio) 
        				VALUES ('$nombreColegio',$CreaColegio)";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(
            array($nombreColegio,$CreaColegio)
        );

    }

    /**
     * Insertar un nuevo categoria
     *
     * @param $idcategoria      titulo del nuevo registro
     * @param $nombre descripción del nuevo registro
     * @return PDOStatement
     */
    public static function insertPersona($colegiopersona,$personaid,$CreaColegioPersona){
        // Sentencia INSERT
        
        $comando = "INSERT INTO curpersonacolegio(idcolegio, idpersona, FechaIngreso) 
        			VALUES ($colegiopersona,$personaid,$CreaColegioPersona)";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(
            array($colegiopersona,$personaid,$CreaColegioPersona)
        );

    }


    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idcategoria identificador de la categoria
     * @return bool Respuesta de la eliminación
     */
    public static function delete($idcolegio)
    {
        // Sentencia DELETE
        
        $comando = "DELETE FROM curcolegio WHERE idcolegio = $idcolegio";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idcolegio));
    }
}

?>