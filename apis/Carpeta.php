<?php

/**
 * Representa el la estructura de las categorias
 * almacenadas en la base de datos
 */
require_once 'database.php';

class HojasCarpeta
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
    public static function getAllPersonaAnioCurso($personaid,$ianio,$icurso)
    {
    	$filtro="";
   	
        $consulta = "SELECT anioCurso, idCurso, idpersona, idMateria, hojaId, 
							nrohoja,fechaEnHoja,fechaCarga, nombreHoja, obsUNO, obsDOS, 
							quienSube, vistael 
					FROM curpermatcarpeta 
					where anioCurso=$ianio and  idCurso=$icurso and  idpersona=$personaid ";
        
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
			// no se estaba devolviendl el resultado en formato JSON
			// con esta linea se logro...
			// usar en vez de return echo, aunque no se si funcionara con ANDROID
            return $comando->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $e)
             {
            		return ($e->getMessage());
            }
		
	}


    /**
     * OBTIENE TODAS LAS HOJAS CARGADAS EN UNA CARPETA POR A?O, PERSONA, MATERIA
     *
     * @param 
     */
    public static function getByMateria($personaid,$ianio,$icurso,$imateria,$filtroFechaCarga,$filtroTemas)
    {
        // Consulta de la categoria
        // clave: anioCurso, idCurso, idpersona, idMateria, hojaId(autonum)
    	$filtro="";
		$MasfiltroTemas = " ) ";
		if($filtroTemas != '') $MasfiltroTemas =" or obsuno like '%$filtroTemas%')" ;
		
		switch($filtroFechaCarga)
		{
			case "ESTASEMANA": 
								$FechaCargaHoy = date('Y-m-d H:i:s');
								//resto 7 días
								$FechaCargaHoyTexto = date('Y-m-d H:i:s',strtotime($FechaCargaHoy."- 7 days")); 
								$FechaCargaHoyTexto = "'".$FechaCargaHoyTexto."'";
								$filtro=" and (fechaEnHoja >= $FechaCargaHoyTexto $MasfiltroTemas";
								break;
			case "ESTAQUINCENA":
								$FechaCargaHoy = date('Y-m-d H:i:s');
								//resto 7 días
								$FechaCargaHoyTexto = date('Y-m-d H:i:s',strtotime($FechaCargaHoy."- 2 weeks")); 
								$FechaCargaHoyTexto = "'".$FechaCargaHoyTexto."'";
								$filtro=" and (fechaEnHoja >= $FechaCargaHoyTexto $MasfiltroTemas ";
								 break;
			case "ESTAMES": 
								$FechaCargaHoy = date('Y-m-d H:i:s');
								//resto 7 días
								$FechaCargaHoyTexto = date('Y-m-d H:i:s',strtotime($FechaCargaHoy."- 1 month")); 
								$FechaCargaHoyTexto = "'".$FechaCargaHoyTexto."'";
								$filtro=" and (fechaEnHoja >= $FechaCargaHoyTexto $MasfiltroTemas";
								break;
			case "ESTATRESM": 
								$FechaCargaHoy = date('Y-m-d H:i:s');
								//resto 7 días
								$FechaCargaHoyTexto = date('Y-m-d H:i:s',strtotime($FechaCargaHoy."- 3 months")); 
								$FechaCargaHoyTexto = "'".$FechaCargaHoyTexto."'";
								$filtro=" and (fechaEnHoja >= $FechaCargaHoyTexto $MasfiltroTemas";
								 break;
			case "ESTASEISM": 
								$FechaCargaHoy = date('Y-m-d H:i:s');
								//resto 7 días
								$FechaCargaHoyTexto = date('Y-m-d H:i:s',strtotime($FechaCargaHoy."- 6 months")); 
								$FechaCargaHoyTexto = "'".$FechaCargaHoyTexto."'";
								$filtro=" and (fechaEnHoja >= $FechaCargaHoyTexto $MasfiltroTemas";
								 break;
			case "ESTAANIO": 
								$FechaCargaHoy = date('Y-m-d H:i:s');
								//resto 7 días
								$FechaCargaHoyTexto = date('Y-m-d H:i:s',strtotime($FechaCargaHoy."- 1 year")); 
								$FechaCargaHoyTexto = "'".$FechaCargaHoyTexto."'";
								$filtro=" and (fechaEnHoja >= $FechaCargaHoyTexto $MasfiltroTemas";
								 break;
		}
		

        $consulta = "SELECT anioCurso, idCurso, curpermatcarpeta.idpersona, idMateria, hojaId, 
							nrohoja,fechaEnHoja, fechaCarga, nombreHoja, obsUNO, obsDOS, 
							quienSube,curpersona.usuariopersona, vistael 
					FROM curpermatcarpeta 
                    inner join curpersona
					    on curpersona.idpersona = $personaid 
					where anioCurso=$ianio 
					and  idCurso=$icurso 
					and  curpermatcarpeta.idpersona=$personaid 
					and  idMateria=$imateria
					   $filtro
					   order by fechaEnHoja DESC ";
       // echo "$consulta";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($personaid,$ianio,$icurso,$imateria,$filtroFechaCarga,$filtroTemas));
            // Capturar primera fila del resultado
            //ESTO DEVUELVE UN VECTOR NUMERADO DE VALORES..
            return $comando->fetchAll(PDO::FETCH_ASSOC);
            //echo json_encode($row);
        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return ($e->getMessage());
        }
    }

    public static function getStats1()
    {
        // Consulta de la categoria
        // clave: anioCurso, idCurso, idpersona, idMateria, hojaId(autonum)
		$FechaCargaHoy = date('Y-m-d H:i:s');
		//resto 7 días
		$FechaCargaHoyTexto = date('Y-m-d H:i:s',strtotime($FechaCargaHoy."- 2 weeks")); 
		$FechaCargaHoyTexto = "'".$FechaCargaHoyTexto."'";
		
        $consulta = "select fechaCarga as 'CargadoEl',per.usuariopersona as 'sube',
        			materias.nombreMateria 'Materia',count(carp.nombreHoja) as 'CantidadHojas'
						from curpermatcarpeta carp
							left join curpersona per
				               on per.idpersona = carp.quienSube
				            left join curmateria materias 
				                on materias.anioCurso = carp.anioCurso
				                and materias.idcurso   = carp.idCurso
				                and materias.idmateria = carp.idMateria
					 where fechaCarga >= $FechaCargaHoyTexto
					 group by fechaCarga,carp.quienSube,carp.idMateria
					 order by fechaCarga desc,carp.quienSube,carp.idMateria  limit 20";
       // echo "$consulta";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array());
            // Capturar primera fila del resultado
            //ESTO DEVUELVE UN VECTOR NUMERADO DE VALORES..
            return $comando->fetchAll(PDO::FETCH_ASSOC);
            //echo json_encode($row);
        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return ($e->getMessage()."<br>query: ".$consulta);
        }
    }


    public static function getStats2upd($personaid,$ianio)
    {
		$consulta = "SELECT	curpersona.nombrepersona, fechaEnHoja, 
					 curmateria.nombreMateria,curmateria.materiaAbr ,
					 obsuno, count(obsuno) as 'Hojas'
					 FROM curpermatcarpeta 
					 left join curpersona ON
					    curpersona.idpersona = curpermatcarpeta.idpersona 
					 left join curmateria ON
					    curmateria.anioCurso = curpermatcarpeta.anioCurso
                        and curmateria.idcurso = curpermatcarpeta.idCurso
                       and curmateria.idmateria = curpermatcarpeta.idMateria
					WHERE curpermatcarpeta.aniocurso =$ianio
					   and curpermatcarpeta.idpersona=$personaid
					  GROUP by obsuno
					  order by fechaenhoja desc
					  limit 10;";
       // echo "$consulta";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($personaid,$ianio));
            // Capturar primera fila del resultado
            //ESTO DEVUELVE UN VECTOR NUMERADO DE VALORES..
            return $comando->fetchAll(PDO::FETCH_ASSOC);
            //echo json_encode($row);
        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return ($e->getMessage()."<br>query: ".$consulta);
        }
    }

    public static function getStats2updTema($temaBuscardo)
    {
    	$filtro="";
    	$limite=0;
    	if($temaBuscardo != ""){
	    	$filtro= " WHERE curpermatcarpeta.obsuno like '%$temaBuscardo%'";
			$limite  = 10;		
		}
	
		$consulta = "SELECT	curpersona.nombrepersona, fechaEnHoja, 
					 curmateria.nombreMateria,curmateria.materiaAbr ,
					 obsuno, count(obsuno) as 'Hojas'
					 FROM curpermatcarpeta 
					 left join curpersona ON
					    curpersona.idpersona = curpermatcarpeta.idpersona 
					 left join curmateria ON
					    curmateria.anioCurso = curpermatcarpeta.anioCurso
                        and curmateria.idcurso = curpermatcarpeta.idCurso
                       and curmateria.idmateria = curpermatcarpeta.idMateria
						$filtro
					  GROUP by obsuno
					  order by fechaenhoja desc
					  limit $limite;";
        //echo "$consulta";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($temaBuscardo));
            // Capturar primera fila del resultado
            //ESTO DEVUELVE UN VECTOR NUMERADO DE VALORES..
            return $comando->fetchAll(PDO::FETCH_ASSOC);
            //echo json_encode($row);
        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return ($e->getMessage()."<br>query: ".$consulta);
        }		
	}

    /**
     * OBTIENE TODAS LAS HOJAS CARGADAS EN UNA CARPETA POR A?O, PERSONA, MATERIA
     *
     * @param 
     */
    public static function getUltimoNroHojaByMateria($personaid,$ianio,$icurso,$imateria)
    {
        // Consulta de la categoria
        // clave: anioCurso, idCurso, idpersona, idMateria, hojaId(autonum)
    	$filtro="";
   	
        $consulta = "SELECT nrohoja
					FROM curpermatcarpeta 
					where anioCurso=$ianio 
					and  idCurso=$icurso 
					and  idpersona=$personaid 
					and  idMateria=$imateria
					order by anioCurso, idCurso, idpersona, idMateria, hojaId, nrohoja desc limit 1";
        
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($personaid,$ianio,$icurso,$imateria));
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

    public static function getHojaByID($personaid,$ianio,$icurso,$imateria,$idhoja)
    {
        // Consulta de la categoria
        // clave: anioCurso, idCurso, idpersona, idMateria, hojaId(autonum)
    	$filtro="";
   	
        $consulta = "SELECT *
					FROM curpermatcarpeta 
					where anioCurso=$ianio 
					and  idCurso=$icurso 
					and  idpersona=$personaid 
					and  idMateria=$imateria
					and hojaId = $idhoja";
        
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($personaid,$ianio,$icurso,$imateria,$idhoja));
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
    public static function updateFechaVisto($personaid,$ianio,$icurso,$imateria,$hojaId,$vistael)
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE curpermatcarpeta 
        				SET vistael = $vistael
						where anioCurso=$ianio 
						and  idCurso=$icurso 
						and  idpersona=$personaid 
						and  idMateria=$imateria
						and  hojaId   = $hojaId";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($personaid,$ianio,$icurso,$imateria,$hojaId,$vistael));
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
    public static function insert($anioCurso, $idCurso, $idpersona, $idMateria, 
								  $nrohoja,$fechaEnHoja, $fechaCarga, $nombreHoja, $obsUNO,
								   $obsDOS, $quienSube )
    {
	// Sentencia INSERT
	$comando = "INSERT INTO curpermatcarpeta
				 (anioCurso, idCurso, idpersona, idMateria, 
					nrohoja,fechaEnHoja, fechaCarga, nombreHoja, obsUNO, obsDOS, 
					quienSube ) 
				VALUES ($anioCurso, $idCurso, $idpersona, $idMateria, 
							$nrohoja,$fechaEnHoja, $fechaCarga, $nombreHoja, $obsUNO, $obsDOS, 
								$quienSube) ";
        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute( array($anioCurso, $idCurso, $idpersona, $idMateria, 
								  $nrohoja,$fechaEnHoja, $fechaCarga, $nombreHoja, $obsUNO,
								   $obsDOS, $quienSube) );
    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idcategoria identificador de la categoria
     * @return bool Respuesta de la eliminación
     */
    public static function delete($ianio,$icurso,$personaid,$imateria,$hojaId)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM curpermatcarpeta
						where anioCurso=$ianio 
						and  idCurso=$icurso 
						and  idpersona=$personaid 
						and  idMateria=$imateria
						and  hojaId   = $hojaId";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($ianio,$icurso,$personaid,$imateria,$hojaId));
    }
}

?>