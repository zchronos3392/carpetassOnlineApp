<?php

/**
 * Representa el la estructura de las categorias
 * almacenadas en la base de datos
 */
require_once 'database.php';

class Cursos
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
        $consulta = "SELECT curcursos.anioCurso, curcursos.idColegio, curcursos.idCurso, 
						curcursos.idnivel, CONCAT(nombreColegio,'_',DescripcionNivel,'_',nombreCurso) as 'nombreCompletoCurso', 
                        (select count(curmateria.idcurso)
						  from curmateria
                             where  curmateria.idcurso = curcursos.idCurso
                             and curmateria.anioCurso=curcursos.anioCurso
                        ) as 'MateriasEnCurso'
                       from curcursos 
                        inner join  curcolegio 
                            on curcolegio.idcolegio = curcursos.idColegio
                        inner join  curnivel 
                            on curnivel.idNivel = curcursos.idnivel";
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
     * Retorna en la fila especificada de la tabla 'vappCategoria'
     *
     * @param $idCategoria Identificador del registro
     * @return array Datos del registro
     */
    public static function getAllPersona($persona)
    {
    	$filtro="";
        $consulta = "SELECT curcursos.anioCurso, curcursos.idColegio, curcursos.idCurso, 
						curcursos.idnivel, 
						CONCAT(nombreColegio,'_',DescripcionNivel,'_',nombreCurso) as 'nombreCompletoCurso',
							(select count(curmateria.idcurso)
						  from curmateria
                             where  curmateria.idcurso = curcursos.idCurso 
                             and curmateria.anioCurso=curcursos.anioCurso) as 'MateriasEnCurso'	 
                             	from curcursos 
						        inner join  curcolegio 
						        	on curcolegio.idcolegio = curcursos.idColegio
						        inner join  curnivel 
						        	on curnivel.idNivel = curcursos.idnivel
						         inner JOIN curpersonamaterias
						            on curpersonamaterias.anioCurso = curcursos.anioCurso
						              and curpersonamaterias.idcolegio = curcursos.idColegio
						              and curpersonamaterias.idCurso = curcursos.idCurso
						              and curpersonamaterias.idpersona = $persona
						GROUP by curcursos.anioCurso, curcursos.idColegio, curcursos.idCurso, 
								curcursos.idnivel";
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
    		
        $consulta = "SELECT count(*) FROM curcursos ";
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
    public static function getById($anioCurso,$idColegio,$idCurso)
    {
        // Consulta de la categoria
        $consulta = "SELECT curcursos.anioCurso, curcursos.idColegio, curcursos.idCurso, 
						curcursos.idnivel, CONCAT(nombreColegio,'_',DescripcionNivel,'_',nombreCurso) as 'nombreCompletoCurso', 
                        (select count(curmateria.idcurso)
						  from curmateria
                             where  curmateria.idcurso = curcursos.idCurso
                             and curmateria.anioCurso=curcursos.anioCurso
                        ) as 'MateriasEnCurso'
                       from curcursos 
                        inner join  curcolegio 
                            on curcolegio.idcolegio = curcursos.idColegio
                        inner join  curnivel 
                            on curnivel.idNivel = curcursos.idnivel
					WHERE anioCurso=$anioCurso and idColegio=$idColegio
						   and idCurso = $idCurso ";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($anioCurso,$idColegio,$idCurso));
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
    public static function update($anioCurso,$idColegio,$idCurso,$nombreCurso)
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE curcursos
        				SET nombreCurso ='$nombreCurso' 
        					WHERE anioCurso=$anioCurso and idColegio=$idColegio
								and idCurso = $idCurso  ";
//		echo "$consulta";
        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($anioCurso,$idColegio,$idCurso,$nombreCurso));

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
    public static function insert($anioCurso,$idColegio,$idnivel,$nombreCurso){
        // Sentencia INSERT
         
        $comando = "INSERT INTO curcursos (anioCurso, idColegio, idnivel, nombreCurso) 
        				VALUES ($anioCurso,$idColegio,$idnivel,'$nombreCurso')";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(
            array($anioCurso,$idColegio,$idnivel,$nombreCurso)
        );

    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idcategoria identificador de la categoria
     * @return bool Respuesta de la eliminación
     */
    public static function delete($anioCurso, $idColegio, $idCurso)
    {
        // Sentencia DELETE
        
        $comando = "DELETE FROM curcursos 
			        WHERE anioCurso=$anioCurso and idColegio=$idColegio
						and idCurso = $idCurso ";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($anioCurso, $idColegio, $idCurso));
    }
}

?>