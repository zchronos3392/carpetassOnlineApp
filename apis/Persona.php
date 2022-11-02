<?php

/**
 * Representa el la estructura de las categorias
 * almacenadas en la base de datos
 */
require_once 'database.php';

class Persona
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
        $consulta = "SELECT curpersona.idpersona, usuariopersona, nombrepersona, tipopersona,  
         				if(curpersonacolegio.idcolegio IS NOT NULL, curcolegio.nombreColegio, if(tipopersona = 'ALUMNO','Sin Colegio aun','No necesita Colegio')  ) as 'ColegioNombre'
								FROM curpersona
								              left join curpersonacolegio
								                on curpersonacolegio.idpersona = curpersona.idpersona
								                   left join curcolegio
								                       on  curcolegio.idcolegio= curpersonacolegio.idcolegio";
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
    		
        $consulta = "SELECT count(*) FROM curpersona";
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

    public static function getAllEspecialista($idpersona)
    {
        // Consulta de la categoria
        $consulta = "SELECT curpersona.idpersona, usuariopersona, nombrepersona, tipopersona,  
         				if(curpersonacolegio.idcolegio IS NOT NULL, curcolegio.nombreColegio, if(tipopersona = 'ALUMNO','Sin Colegio aun','No necesita Colegio')  ) as 'ColegioNombre'
								FROM curpersona
								              left join curpersonacolegio
								                on curpersonacolegio.idpersona = curpersona.idpersona
								                   left join curcolegio
								                       on  curcolegio.idcolegio= curpersonacolegio.idcolegio
                            		left join curespecialiastaalumno especAlu
                            			on curpersona.idpersona = especAlu.idalumno  
                            	WHERE especAlu.idespecialista = $idpersona";
		//echo $consulta;
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idpersona));
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
     * Obtiene los campos de una categoria con un identificador
     * determinado
     *
     * @param $idcategoria Identificador de la categoria
     * @return mixed
     */
    public static function getById($idpersona)
    {
        // Consulta de la categoria
        $consulta = "SELECT curpersona.idpersona, usuariopersona, nombrepersona, tipopersona,  
         				if(curpersonacolegio.idcolegio IS NOT NULL, curcolegio.nombreColegio, if(tipopersona = 'ALUMNO','Sin Colegio aun','No necesita Colegio')  ) as 'ColegioNombre'
								FROM curpersona
								              left join curpersonacolegio
								                on curpersonacolegio.idpersona = curpersona.idpersona
								                   left join curcolegio
								                       on  curcolegio.idcolegio= curpersonacolegio.idcolegio
                            	WHERE curpersona.idpersona = $idpersona";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idpersona));
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
    public static function update($idpersona,$usuariopersona,$nombrepersona,$tipopersona )
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE curpersona 
        			SET usuariopersona='$usuariopersona',nombrepersona='$nombrepersona',
        				tipopersona='$tipopersona' WHERE 
        					idpersona = $idpersona";
//		echo "$consulta";
        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($idpersona,$usuariopersona,$nombrepersona,$tipopersona));

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
    public static function insert($usuariopersona,$nombrepersona,$tipopersona){
        // Sentencia INSERT
        $comando = "INSERT INTO curpersona
        				(usuariopersona, nombrepersona, tipopersona) 
        				VALUES ('$usuariopersona','$nombrepersona','$tipopersona') ";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(
            array($usuariopersona,$nombrepersona,$tipopersona)
        );

    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idpersona identificador de la persona
     * @return bool Respuesta de la eliminacion
     */
    public static function delete($idpersona)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM curpersona
        					WHERE idpersona = $idpersona ";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idpersona));
    }
}

?>