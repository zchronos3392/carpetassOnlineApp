<?php

/**
 * Representa el la estructura de las categorias
 * almacenadas en la base de datos
 */
require_once 'database.php';

class EspecialistaAlumno
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
        $consulta = "SELECT idespecialista,PersEspec.nombrepersona as 'Especialista', idalumno,
        				PersAlumno.nombrepersona as 'Alumno',idrelacion, 
        				FechaIinicio, relacionObs 
        				FROM curespecialiastaalumno 
        					left join curpersona PersEspec
        						on PersEspec.idpersona=idespecialista
        					left join  curpersona PersAlumno
        						on PersAlumno.idpersona=idalumno";
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
    
    
    

    /**
     * Obtiene los campos de Relacion entre Especialista y Alumno con un identificador
     * determinado
     *
     * @param $especialista Identificador de la categoria
     * @return mixed
     */
    public static function getByIdEspecialista($especialista)
    {
        // Consulta de la categoria
        $consulta = "SELECT idespecialista,PersEspec.nombrepersona as 'Especialista', idalumno,
        				PersAlumno.nombrepersona as 'Alumno',idrelacion, 
        				FechaIinicio, relacionObs 
        				FROM curespecialiastaalumno 
        					left join curpersona PersEspec
        						on PersEspec.idpersona=idespecialista
        					left join  curpersona PersAlumno
        						on PersAlumno.idpersona=idalumno
					WHERE idespecialista=$especialista ";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($especialista));
            // Capturar primera fila del resultado
            return $comando->fetchAll(PDO::FETCH_ASSOC);
            //echo json_encode($row);

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return -1;
        }
    }


    /**
     * Obtiene los campos de Relacion entre Especialista y Alumno con un identificador
     * determinado
     *
     * @param $especialista Identificador de la categoria
     * @return mixed
     */
    public static function getByIdAlumno($alumno)
    {
        // Consulta de la categoria
        $consulta = "SELECT idespecialista,PersEspec.nombrepersona as 'Especialista', idalumno,
        				PersAlumno.nombrepersona as 'Alumno',idrelacion, 
        				FechaIinicio, relacionObs 
        				FROM curespecialiastaalumno 
        					left join curpersona PersEspec
        						on PersEspec.idpersona=idespecialista
        					left join  curpersona PersAlumno
        						on PersAlumno.idpersona=idalumno
					WHERE idalumno=$alumno ";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($alumno));
            // Capturar primera fila del resultado
	           return $comando->fetchAll(PDO::FETCH_ASSOC);
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
    public static function updateEspecialista($especialista,$alumno,$FechaRelacion,$obsrelacion)
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE curespecialiastaalumno
        				SET idalumno=$alumno,FechaIinicio=$FechaRelacion,
        					relacionObs = $obsrelacion 
        					WHERE idespecialista=$especialista";
//		echo "$consulta";
        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($especialista,$alumno,$FechaRelacion,$obsrelacion));

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
    public static function insertRelacion($idespecialista, $idalumno,$FechaIinicio, $relacionObs){
        // Sentencia INSERT
        $comando = "INSERT INTO curespecialiastaalumno (idespecialista, idalumno,FechaIinicio, relacionObs) 
        				VALUES ($idespecialista, $idalumno,$FechaIinicio, $relacionObs)";
        //echo $comando;
        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idespecialista, $idalumno,$FechaIinicio, $relacionObs));

    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idcategoria identificador de la categoria
     * @return bool Respuesta de la eliminación
     */
    public static function deleteAluFromEspec($especialista, $alumno)
    {
        // Sentencia DELETE
        
        $comando = "DELETE FROM curespecialiastaalumno 
			        WHERE idespecialista=$especialista and idalumno=$alumno";
        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($especialista, $alumno));
    }
}

?>