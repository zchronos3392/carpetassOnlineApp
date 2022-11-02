<?php

/**
 * Representa el la estructura de las categorias
 * almacenadas en la base de datos
 */
require_once 'database.php';

class Materias
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
        $consulta = "SELECT curmateria.anioCurso, curmateria.idColegio, curmateria.idcurso, 
						idmateria, nombreMateria ,curcursos.nombreCurso,curcolegio.nombreColegio
							FROM curmateria 
                            inner join curcursos
								on curcursos.anioCurso = curmateria.anioCurso
                                 and curcursos.idColegio = curmateria.idColegio
                                 and curcursos.idCurso = curmateria.idcurso
                            inner join curcolegio
                                 on curcolegio.idColegio = curmateria.idColegio";
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
    
    public static function getAnioCurso($anioCurso,$cursomateria){
        $consulta = "SELECT curcursos.aniocurso,curcolegio.idcolegio,curcursos.idcurso,idmateria ,
        			nombremateria ,curcursos.nombrecurso, curcolegio.nombrecolegio
				  FROM  curmateria 
				     right join curcursos 
				          on curcursos.anioCurso = curmateria.anioCurso 
				         and curcursos.idColegio = curmateria.idColegio
				         and curcursos.idCurso = curmateria.idcurso
					inner join curcolegio 
						on curcolegio.idColegio = curmateria.idColegio 
				  WHERE curmateria.idcurso = $cursomateria 
				    and curmateria.anioCurso=$anioCurso ";
        //echo "$consulta";
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

    public static function getAllPersona($personaid,$ianio)
    {
    	$filtro="";
        $consulta = "SELECT curmateria.anioCurso, curmateria.idColegio, curmateria.idcurso, curmateria.idmateria, nombreMateria ,curcursos.nombreCurso, curcolegio.nombreColegio,curpersona.usuariopersona, curpersona.nombrepersona, curpersona.tipopersona 
						FROM curpersonamaterias
						     right join curcursos 
						          on curcursos.anioCurso = curpersonamaterias.anioCurso 
						         and curcursos.idColegio = curpersonamaterias.idColegio
						         and curcursos.idCurso = curpersonamaterias.idcurso
						      inner join curcolegio 
						          on curcolegio.idColegio = curpersonamaterias.idColegio 
						      join  curmateria  
						          on curmateria.anioCurso = curpersonamaterias.anioCurso  
						         and curmateria.idColegio = curpersonamaterias.idcolegio  
						         and curmateria.idcurso   = curpersonamaterias.idCurso  
								 and curmateria.idmateria   = curpersonamaterias.idMateria	         
						      join curpersona 
						           on curpersona.idpersona = curpersonamaterias.idpersona
						WHERE   curpersonamaterias.idpersona = $personaid 
								AND curpersonamaterias.anioCurso=$ianio";
        //echo "<br> $consulta <br> ";
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
            return ("<br> $consulta <br> ");
        }
    }
    
    public static function getAllPersonaCurso($personaid,$ianio,$cursoid)
    {
    	$filtro="";
        $consulta = "SELECT curmateria.aniocurso, curmateria.idcolegio, curmateria.idcurso, curmateria.idmateria, nombremateria ,curcursos.nombrecurso, curcolegio.nombrecolegio,curpersona.usuariopersona, curpersona.nombrepersona, curpersona.tipopersona 
						FROM curpersonamaterias
						     right join curcursos 
						          on curcursos.anioCurso = curpersonamaterias.anioCurso 
						         and curcursos.idColegio = curpersonamaterias.idColegio
						         and curcursos.idCurso = curpersonamaterias.idcurso
						      inner join curcolegio 
						          on curcolegio.idColegio = curpersonamaterias.idColegio 
						      join  curmateria  
						          on curmateria.anioCurso = curpersonamaterias.anioCurso  
						         and curmateria.idColegio = curpersonamaterias.idcolegio  
						         and curmateria.idcurso   = curpersonamaterias.idCurso  
								 and curmateria.idmateria   = curpersonamaterias.idMateria	         
						      join curpersona 
						           on curpersona.idpersona = curpersonamaterias.idpersona
						WHERE   (curpersonamaterias.idpersona = $personaid )
								AND curpersonamaterias.anioCurso=$ianio
								and curpersonamaterias.idCurso=$cursoid";
        //echo "<br> $consulta <br> ";
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
            return ("<br> $consulta <br> ");
        }
    }    
    
   public static function contar()
    {
    		
        $consulta = "SELECT count(*) FROM curmateria ";
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
    public static function getById($anioCurso,$idColegio,$idCurso,$idmateria)
    {
        // Consulta de la categoria
        $consulta = "SELECT anioCurso, idColegio, idcurso, idmateria, nombreMateria 
						FROM curmateria
							WHERE  anioCurso=$anioCurso 
        							and idColegio=$idColegio
        							and idcurso=$idCurso
        							and idmateria=$idmateria";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($anioCurso,$idColegio,$idCurso,$idmateria));
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
    public static function update($anioCurso,$idColegio,$idCurso,$idmateria,$nombreMateria)
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE curmateria
        				SET nombreMateria ='$nombreMateria' 
							WHERE  anioCurso=$anioCurso 
        							and idColegio=$idColegio
        							and idcurso=$idcurso
        							and idmateria=$idmateria";
//		echo "$consulta";
        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($anioCurso,$idColegio,$idCurso,$idmateria,$nombreMateria));

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
    public static function insert($anioCurso,$idColegio,$idCurso,$nombreMateria){
        // Sentencia INSERT
         
        $comando = "INSERT INTO curmateria (anioCurso, idColegio, idcurso, nombreMateria) 
        				VALUES ($anioCurso,$idColegio,$idCurso,'$nombreMateria') ";

		//echo "<br> $comando <br>";
        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute( array($anioCurso,$idColegio,$idCurso,$nombreMateria) );
    }

    /**
     * Insertar un nuevo categoria
     *
     * @param $idcategoria      titulo del nuevo registro
     * @param $nombre descripción del nuevo registro
     * @return PDOStatement
     */
    public static function insertMateriasPersona($anioCurso,$idcolegio,$cursomateria,$idMateria,$persona){
        // Sentencia INSERT
	$comando = "INSERT INTO curpersonamaterias 
				values ($anioCurso,$idcolegio,$cursomateria,$idMateria,$persona)";
		//echo "$comando";
        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($anioCurso,$idcolegio,$cursomateria,$idMateria,$persona));

    }


    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idcategoria identificador de la categoria
     * @return bool Respuesta de la eliminación
     */
    public static function delete($idmateria)
    {
        // Sentencia DELETE
        
        $comando = "DELETE FROM curmateria
							WHERE  idmateria=$idmateria";

		echo "<br> $comando <br>";
        // Preparar la sentencia
        //$sentencia = Database::getInstance()->getDb()->prepare($comando);

        //return $sentencia->execute(array($anioCurso, $idColegio, $idCurso,$idmateria));
    }

    public static function deleteMateriasPersona($anioCurso,$idcolegio,$cursomateria,$idMateria,$persona){
        // Sentencia INSERT
	$comando = "DELETE from curpersonamaterias 
					where anioCurso = $anioCurso
					and idcolegio = $idcolegio
					and idCurso = $cursomateria
					and idMateria = $idMateria
					and idpersona = $persona ";
		//echo "$comando";
        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($anioCurso,$idcolegio,$cursomateria,$idMateria,$persona));

    }


}

?>