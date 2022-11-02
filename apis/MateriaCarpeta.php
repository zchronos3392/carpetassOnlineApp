<?php

/**
 * Representa el la estructura de las categorias
 * almacenadas en la base de datos
 */
require_once 'database.php';

class MateriaCarpeta
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
    public static function getAll($filtro)
    {
    	$filtro="";
        $consulta = "SELECT anioCurso, idCurso, idpersona, idmateria, idhoja, 
        				nrohoja, fechaCarga, nombreHoja, 
        				obsUNO, obsDOS, quienSUBE 
        			FROM curcarpetapersona";
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
    		
        $consulta = "SELECT count(*) FROM curcarpetapersona ";
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
     * @param 
     */
    public static function getById($anioCurso,$idCurso,$idpersona,$idmateria,$idhoja)
    {
        // Consulta de la carpeta de la materia del alumno X509_PURPOSE_ANY
        $consulta = "SELECT anioCurso, idCurso, idpersona, idmateria, idhoja, 
        				nrohoja, fechaCarga, nombreHoja, 
        				obsUNO, obsDOS, quienSUBE 
        				FROM curcarpetapersona
						WHERE  anioCurso=$anioCurso 
        					and idcurso=$idcurso
        						and idmateria=$idmateria
        						and idpersona= $idpersona
        						and idhoja   = $idhoja ";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($anioCurso,$idCurso,$idpersona,$idmateria,$idhoja));
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
    public static function update($anioCurso,$idCurso,$idpersona,$idmateria,$idhoja,
								    $nrohoja,$fechaCarga, $nombreHoja,$obsUNO,$obsDOS,$quienSUBE)
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE curcarpetapersona
        				SET nrohoja =$nrohoja,
							fechaCarga=$fechaCarga, nombreHoja='$nombreHoja', 	
        				obsUNO='$obsUNO', obsDOS='$obsDOS',
        				quienSUBE = $quienSUBE        				 
						WHERE  anioCurso=$anioCurso 
        					and idcurso=$idcurso
        						and idmateria=$idmateria
        						and idpersona= $idpersona
        						and idhoja   = $idhoja ";
//		echo "$consulta";
        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($anioCurso,$idCurso,$idpersona,$idmateria,$idhoja,
								    $nrohoja,$fechaCarga, $nombreHoja,$obsUNO,$obsDOS,$quienSUBE));
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
    public static function insert($anioCurso,$idCurso,$idpersona,$idmateria,$nrohoja,
    								$fechaCarga, $nombreHoja,$obsUNO,$obsDOS,$quienSUBE){
        // Sentencia INSERT
         
        $comando = "INSERT INTO curmateria (anioCurso, idCurso, idpersona, idmateria, 
        									nrohoja, fechaCarga, nombreHoja,
        									 obsUNO, obsDOS, quienSUBE)
        				VALUES ($anioCurso,$idCurso,$idpersona,$idmateria,
								    $nrohoja,$fechaCarga, $nombreHoja,$obsUNO,$obsDOS,$quienSUBE) ";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute( array$anioCurso,$idCurso,$idpersona,$idmateria,$idhoja,
								    $nrohoja,$fechaCarga, $nombreHoja,$obsUNO,$obsDOS,$quienSUBE) );
    }

	/* Eliminar el registro con el identificador especificado
     *
     * @param $idcategoria identificador de la categoria
     * @return bool Respuesta de la eliminación
     */
    public static function delete($anioCurso,$idCurso,$idpersona,$idmateria,$idhoja)
    {
        // Sentencia DELETE
        
        $comando = "DELETE ccurcarpetapersona
						WHERE  anioCurso      = $anioCurso 
        						and idcurso   = $idcurso
        						and idmateria = $idmateria
        						and idpersona = $idpersona
        						and idhoja    = $idhoja ";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($anioCurso,$idCurso,$idpersona,$idmateria,$idhoja));
    }
}

?>