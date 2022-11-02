<?php
session_start();
define('__ROOT__', dirname(dirname(__FILE__)));
require_once('Materia.php');
require_once('Carpeta.php');

	$llamador ="";
     if(isset($_GET['llamador']))  $llamador = $_GET['llamador'];
     if(isset($_POST['llamador']))  $llamador = $_POST['llamador'];

	 $funcion=""; // en cero no hace nada, en 1 achica la lista
     if(isset($_GET['funcion']))  $funcion = $_GET['funcion'];
     if(isset($_POST['funcion']))  $funcion = $_POST['funcion'];

switch($funcion){
		case "eliminarCarpeta":
								$carpeta = "";
								if(isset($_POST['carpetasfs']))  $carpeta = $_POST['carpetasfs'];
									rmdir($carpeta);
								break;
	   case "eliminarHoja": // en cero no hace nada, en 1 achica la lista
								require_once('Carpeta.php');
								$ianio  = 0;
								if(isset($_GET['ianio']))
									$ianio  = $_GET['ianio'];
								$icurso = 0;
								if(isset($_GET['icurso']))
									$icurso = $_GET['icurso'];
								$ipersona=0;
								if(isset($_GET['ipersona']))
									$ipersona = $_GET['ipersona'];
								$imateria=0;
								if(isset($_GET['imateria']))
									$imateria = $_GET['imateria'];
								$ihojaNroId=0;
								if(isset($_GET['ihojaNroId']))
									$ihojaNroId = $_GET['ihojaNroId'];
								//eliminamos la hoja de la tabla y del FS
								$carpeta = pathMateria($ipersona,$imateria,$ianio);
								//necesito el nombre la de imagen :
															
								$hojaCarpeta =	HojasCarpeta::getHojaByID($ipersona,$ianio,$icurso,$imateria,$ihojaNroId);
									//print_r($hojaCarpeta);
									$nombreimagen = $hojaCarpeta['nombreHoja'];
									$mensaje= "eliminando la hoja $ihojaNroId, nombre: $nombreimagen<br>";
									$mensaje.= "borrando archivo : ".$carpeta.$nombreimagen;
									$file_pointer = $carpeta.$nombreimagen; 
										// Use unlink() function to delete a file 
										if (!unlink($file_pointer)) { 
										    $mensaje.= "$file_pointer cannot be deleted due to an error"; 
										} 
										else { 
										    $mensaje.= "$file_pointer has been deleted"; 
										} 
										
									$retorno=0;
									$retorno =	HojasCarpeta::delete($ianio,$icurso,$ipersona,$imateria,$ihojaNroId);
									echo json_encode("Se elimino la hoja (retorno delete: $retorno),<br> $mensaje");	
																	
								break;
								
		case "CarDirectorios":
						//Si es un directorio
						$carpeta = __ROOT__."/uploads/";

						if(is_dir($carpeta)) {
							    //Escaneamos el directorio
							    //echo "El directorio fue detectado como Directorio";
							    $algo = @scandir($carpeta);
							    //echo "contenido $algo <br> ";
							    If($algo != ""){
								    //Miramos si existen archivos
								    if (count($algo) > 2){
								        //echo 'El directorio tiene archivos..mostrando:';
											$padre="/";
											$nivel=-1;
											$archivos=array();
											$archivos_V2=array();
											//listadoSubDirectorio($carpeta,$padre,$nivel, $archivos);
											listadoSubDirectoriov2($carpeta,$padre,$nivel, $archivos_V2);

											$datos["estado"] = 1;
											$datos["Carpetas"] = $archivos_V2;//es un array
											echo json_encode($datos);

								    }else
								    {
								        $datos["estado"] = 2;
	        							$datos["Carpetas"] = '<br>El directorio está vacío';//es un array
								    		print json_encode($datos); 	
								    }
								}
								else
								{
								        $datos["estado"] = 22;
	        							$datos["Carpetas"] = "<br>El directorio $carpeta está vacío";//es un array
											print json_encode($datos); 	
								}
						}
						else 
						{
						    echo '<br>El directorio no existe.';
						}	

						break;
	case "CrearDirectorioPersona":
								 $idpersona=0; // en cero no hace nada, en 1 achica la lista
							     if(isset($_GET['persona']))  $idpersona = $_GET['persona'];
							     if(isset($_POST['persona'])) $idpersona = $_POST['persona'];
								 $anio=0;
									if(isset($_GET['ianio'])) $anio = $_GET['ianio'];
									//chequear que la persona tenga:
									// materias asignadas (curpersonamaterias):
										//anioCurso,idColegio,idCurso,idMateria para idpersona
										// Si tiene todo eso creamos:
											//sino existe, creo el año:
											// AÑO/PERSONA/COLEGIO/CURSO/MATERIA
											require_once('Materia.php');
												$MateriasPersona = Materias::getAllPersona($idpersona,$anio);
											//print_r($MateriasPersona);
											$carpetaOrigen = __ROOT__."/uploads/";
											//echo $resultado." anio: $anio ";
											if($anio == 0 ) exit;
											else 
												{
												  $parcial=$anio;
												  if (!file_exists($carpetaOrigen.$anio."/"))
														$resultado = mkdir($carpetaOrigen.$anio, 0755); 
												}
	
											//nombreMateria ,usuariopersona,curcursos.nombreCurso,curcolegio.nombreColegio	
											    for ($i = 0; $i < count($MateriasPersona); $i++) {
													$usuarioFolder= $MateriasPersona[$i]['usuariopersona'];
													  if (!file_exists($carpetaOrigen.$anio."/".$usuarioFolder."/") && $i==0)
														mkdir($carpetaOrigen.$anio."/".$usuarioFolder, 0755); 
													$nombreColegioFolder= $MateriasPersona[$i]['nombreColegio']; 
													  if (!file_exists($carpetaOrigen.$anio."/".$usuarioFolder."/".$nombreColegioFolder."/") && $i==0)
														mkdir($carpetaOrigen.$anio."/".$usuarioFolder."/".$nombreColegioFolder, 0755); 														

													$CursoFolder= $MateriasPersona[$i]['nombreCurso']; 
													  if (!file_exists($carpetaOrigen.$anio."/".$usuarioFolder."/".$nombreColegioFolder."/".$CursoFolder."/") && $i==0)
														mkdir($carpetaOrigen.$anio."/".$usuarioFolder."/".$nombreColegioFolder."/".$CursoFolder, 0755); 														

													$MateriaFolder= $MateriasPersona[$i]['nombreMateria']; 
													  if (!file_exists($carpetaOrigen.$anio."/".$usuarioFolder."/".$nombreColegioFolder."/".$CursoFolder."/".$MateriaFolder."/"))
														mkdir($carpetaOrigen.$anio."/".$usuarioFolder."/".$nombreColegioFolder."/".$CursoFolder."/".$MateriaFolder, 0755); 
											    }
										echo json_encode("Se crearon los directorios del usuario $usuarioFolder");
									break;
	case "novedadesIndex":
		 $FechaCarga=""; // en cero no hace nada, en 1 achica la lista
	     if(isset($_GET['FechaCarga']))  $FechaCarga = $_GET['FechaCarga'];
	     if(isset($_POST['FechaCarga']))  $FechaCarga = $_POST['FechaCarga'];
				$stats = HojasCarpeta::getStats1();

		        $datos["estado"] = 1;
		        $datos["Novedades1"] = $stats;//
					print json_encode($datos); 	
			break;								
	case "UploadHojasCarpeta":
		//DATOS DE LA CARPETA
		$anioCurso  = 	$_POST['aniocurso'];
		$idCurso    = 	$_POST['idcurso'];
		$idalumno   = 	$_POST['idalumno'];
		$materiaid  = 	$_POST['idmateriaid'];
		
		$fechaEnHoja = 	$_POST['FechaEnHoja'];
		$obs1        = 	$_POST['Observaciones1'];

		$carpeta = pathMateria($idalumno,$materiaid,$anioCurso);
		
		if($carpeta !="NO")
		{
			$mensajes = "<br> Clave de la tabla carpetas: ANIOCURSO $anioCurso CURSO ID $idCurso ALUMNO: $idalumno MATERIA: $materiaid  <br>";
			$mensajes .= "se guardaran en la materia: $carpeta <br>";
		//	$mensajes .= "error que vino con el file: ".$_FILES['miHojas']['error'];
			if( isset($_FILES['miHojas']) )
			{
				// and !$_FILES['miHojas']['error'] 
				$mensajes .= "<br> Llegaron hojas de carpeta sin errores.";
				$nombresArchivos  = $_FILES['miHojas']['name'];
				$tiposArchivos    = $_FILES['miHojas']['type'];
				$erroresArchivos  = $_FILES['miHojas']['error'];
				$tamaniosArchivos = $_FILES['miHojas']['size'];
				$temporalArchivo  = $_FILES['miHojas']['tmp_name'];
				 
				for($i=0;$i<count($nombresArchivos);$i++)
				{
					$nombreArchivo     = strtolower($nombresArchivos[$i]);
					$nombreTemporal    = strtolower($temporalArchivo[$i]);
					$tamanioIndividual = $tamaniosArchivos[$i];
					$tipoArchivo    = strtolower($tiposArchivos[$i]);
					$errorIndividual   = $erroresArchivos[$i];

				    $uploadedFile = '';
				    if(!$errorIndividual)
				    {
				    	$ultimoIdCargado = 0;
				    	$mensajes .= "<br> cargando archivo en variable ";

				        $valid_extensions = array("jpeg", "jpg", "png");
				        $extensionFile = explode(".", $nombreArchivo);
				        $file_extension = end($extensionFile);
				        if((($tipoArchivo == "image/png") || ($tipoArchivo == "image/jpg") || ($tipoArchivo == "image/jpeg")) && in_array($file_extension, $valid_extensions))
				        {
				        	$mensajes .= "<br> reconociendo extension correcta ";
				            //$tipoArchivo =  $_FILES['miHojas']['type'];
							$mensajes .= "nombre: $nombreArchivo,tipo $tipoArchivo nomTemp $nombreTemporal <br>";
							$PATHINICIAL = __ROOT__."/uploads/";
					        //$carpeta=
					        $targetPath = $carpeta.$nombreArchivo;
				            $copiar=0;
				            // Comprimos el fichero
					           $imageTemp = $_FILES["miHojas"]["tmp_name"][$i];
					           $imageUploadPath = $targetPath;
            				$copiar = compressImage($imageTemp, $imageUploadPath, 75); 
				            // Upload file
							//$copiar = move_uploaded_file($_FILES["miHojas"]["tmp_name"][$i], $targetPath );

							if( $copiar )
							 {
							  $mensajes .= "<br> archivo copiado al FS ";     
							  	//$fechaEnHoja $obs1    
							  	$regresoAccion =altaHojaCarpeta($anioCurso,$idCurso,$idalumno,$materiaid,$nombreArchivo,$mensajes,$obs1,$fechaEnHoja);
				            	$mensajes .= "<br> retorno del insert: ".$regresoAccion."<br>"; 
							  
							 } else 
							 {
							  $mensajes .= "<br> no se copió el archivo al FS.Codigo error".$_FILES["file"]["error"][$i];
							  }
				        } // Tipo Correcto
						//$mensajes .= "<br> llego algo...temporal : ".$nombreTemporal."<br>  y con nombre: ".$nombreArchivo."<br>";
				     } // el archivo no trajo errores..
				     else
				     { //huno errores...
					 	 $mensajes .= "<br>no se cargo este archivo.$nombreArchivo <br>Volvé a intentarlo.<br>";
					 }
				} //recorrer archivos que llegaron..
			}	//analizando el vector FILES
			else
			{
				$mensajes .= "<br> No llego un archivo.";
			}
	   } // no hibo error en la generacion del PATH BASE
	   else
		{
			$mensajes = "Error en la generacion del path de la materia :".$carpeta."<br>";		
		}
		//echo "$mensajes";	
		break;	 		
	case "grabarsesion":
						$_SESSION[$_GET['clave']] = $_GET['valorSesion'];
						break;									
	case "leersesion":if(isset($_GET['clave']))
							if(isset($_SESSION[$_GET['clave']]))
								echo  trim($_SESSION[$_GET['clave']]);
							else
							  echo "";
						break;
						}
function listadoSubDirectoriov2($directorio,$padre,$nivel, &$archivos = [])
{
	$nivel++;
	//echo "<br> analizando $directorio <br>";
    $dir = opendir($directorio);//dir es un VECTOR CON LOS ARCHIVOS DENTRO
    while (false !== ($current = readdir($dir)))
     { //leer directorio
        $ruta_completa = $directorio . "/" . $current;
		if(is_dir($ruta_completa))
		{
        if ($current !== "." && $current !== ".." ) 
         {
         	//echo "<br>	encontre $current en nivel : $nivel<br>";
			//echo "<br>	y es un directorio<br>";
			
			$HijosCarpeta = array_diff(scandir($ruta_completa), array('..', '.'));
			//LIMPIO LAS IMAGENES DEL DIRECTORIO QUE NO ME SIRVEN
			//echo "			contenido  en nivel : $nivel<br> ";
			//print_r($HijosCarpeta);
			//echo "<br> 			******************* <br> ";
			$hijostemporal=array();
			$valid_extensions = array("jpeg", "jpg", "png");
			$hojasEnCarpeta=0;
			foreach($HijosCarpeta as $clave=>$value)
			{
			  $extensionFile = explode(".", $value);
			  $file_extension = end($extensionFile);
			  if(! in_array($file_extension, $valid_extensions))
				{
					$hijostemporal[]=$HijosCarpeta[$clave];
				}
				else $hojasEnCarpeta++;	
			}
			$HijosCarpeta=$hijostemporal;
			
			if (count($HijosCarpeta) > 0)
			{
				//echo "<br>				sigo escarbando dentro de el, desde el nivel : $nivel<br>";
				listadoSubDirectoriov2($ruta_completa . '/',$padre."/".$current,$nivel,  $archivos);
			}	
			else
			{ //no tiene hijos...
			//echo "<br>					+++++++  agregando Directorio : $directorio  en nivel : $nivel<br>";
	        $archivos[] = [
	  			  'path'       => $ruta_completa,
	  			  'directorio' => $ruta_completa."(con ".$hojasEnCarpeta." hojas)"
			];
			}
      	}
       }
      }
    
	closedir($dir);
  return $archivos;			

}
function listadoSubDirectorio($directorio,$padre,$nivel, &$archivos = [])
{
//DEVUELVE UN ARRAY CON LOS HIJOS Y SU PATH COMPLETO DE LAS CARPETAS
//QUE DEPENDEN DE LA CARPETA UPLOADS..
	echo "<br> analizando $directorio <br>";
    $dir = opendir($directorio);//dir es un VECTOR CON LOS ARCHIVOS DENTRO
    $conteoLocal =0;
	$nivel++;
    while (false !== ($current = readdir($dir)))
     { //leer directorio
        $ruta_completa = $directorio . "/" . $current;
        if ($current !== "." && $current !== ".." ) //&& is_dir($current)
         {
   			$conteoLocal++;	
			echo "+++   NIVEL: $nivel, carpeta nro: $conteoLocal , ruta completa: $ruta_completa <br>"; 
			
         }
      }
	closedir($dir);
      
    if($conteoLocal == 0)
     {
	    echo  "**** ultimo nivel de la carpeta, no tiene hijos ****<br>"; 
		    	echo "+++++++  agregando Directorio : $padre <br>";
		        $archivos[] = [
		  			  'path'       => $directorio,
		  			  'directorio' => $padre
				];
	}
	else
	{
	    $dir = opendir($directorio);
	    $conteoLocal =0;
	    while (false !== ($current = readdir($dir)))
	     { //leer directorio
	        $ruta_completa = $directorio . "/" . $current;
	        if ($current !== "." && $current !== "..")
	         {
			    if (is_dir($ruta_completa))
		     {
				echo "++++++++++  buscando hijos en : $ruta_completa <br>";
		     	listadoSubDirectorio($ruta_completa . '/',$padre."/".$current,$nivel,  $archivos);
//				echo "++++++++++  vuelve de buscar hijos de $current en nivel $nivel con: <br>";
//					foreach($archivos as $clave=>$value)
//					{
//						echo "<br> psicion: $clave  ";
//						print_r($value);
//					}
//					echo "<br><br>";	
			     }	
			} 
	    }
     }
	
	return $archivos;			

} // fin listadoSubDirectorio
function pathMateria($personaid,$materiaid,$ianio){

	$MateriasPersona = Materias::getAllPersona($personaid,$ianio);
	$CarpetaPath = "";    
    if ($MateriasPersona) 
    {
    	$carpetaOrigen = __ROOT__."/uploads/";
		$i=0;
		//nombreMateria ,usuariopersona,curcursos.nombreCurso,curcolegio.nombreColegio	
		$anio 					= $MateriasPersona[$i]['anioCurso'];
		$usuarioFolder			= $MateriasPersona[$i]['usuariopersona'];
		$nombreColegioFolder	= $MateriasPersona[$i]['nombreColegio']; 
		$CursoFolder			= $MateriasPersona[$i]['nombreCurso']; 
		$MateriaFolder			= "";

		for ($i = 0; $i < count($MateriasPersona); $i++) {
				if($MateriasPersona[$i]['idmateria'] == $materiaid ){
						//$founded = $MateriasPersona[$i]['idmateria'];
						//echo "materia encontrada: $founded, buscada: $materiaid y es: ".$MateriasPersona[$i]['nombreMateria'];
						$MateriaFolder	= $MateriasPersona[$i]['nombreMateria']; 
				}
		}			
	//el path fisico tiene que tener las barras hacia la DERECHA
	$CarpetaPath = $carpetaOrigen.$anio."/".$usuarioFolder."/".$nombreColegioFolder."/".$CursoFolder."/".$MateriaFolder."/";
	//el path virtual tiene que enviarse con las barras hacia la IZQUIERDA
	$PathVirtual = ".\\uploads\\".$anio."\\".$usuarioFolder."\\".$nombreColegioFolder."\\".$CursoFolder."\\".$MateriaFolder."\\";
	}	
if(is_dir($CarpetaPath)) return $CarpetaPath;

return "NO";	
}

function altaHojaCarpeta($anioCurso,$idCurso,$idpersona,$materiaid,$nombreArchivo,$mensajes,$obs1,$fechaEnHoja){
	
//IDENTIFICADOR AUTONUMERICO
$HojasCarpeta = HojasCarpeta::getUltimoNroHojaByMateria($idpersona,$anioCurso,$idCurso,$materiaid);
$ultimaHoja = 0;

//print_r($HojasCarpeta);
if($HojasCarpeta != "") $ultimaHoja = (int)$HojasCarpeta['nrohoja'];
if($ultimaHoja == 0)
		$ultimaHoja = 1;
else
		$ultimaHoja++;		

	$nrohoja= $ultimaHoja;
	$fechaCarga= date_create()->format('Y-m-d H:i:s'); 
	$fechaCarga= "'".$fechaCarga."'";
	
		$fechaEnHoja = "'".$fechaEnHoja."'";
	
	$obsUNO="'".$obs1."'";
	$obsDOS="''";
	$vistael="''"; //fecha nula, o vacia, aun no la vió nadie. 
	$nombreArchivo="'".$nombreArchivo."'";
	
$retorno = HojasCarpeta::insert($anioCurso, $idCurso, $idpersona, $materiaid, 
					$nrohoja,$fechaEnHoja, $fechaCarga, $nombreArchivo, $obsUNO,
					$obsDOS, $idpersona, $vistael );	
return $retorno;
}

/* 
 * Función personalizada para comprimir y 
 * subir una imagen mediante PHP
 */ 
function compressImage($source, $destination, $quality) { 
    // Obtenemos la información de la imagen
    $imgInfo = getimagesize($source); 
    $mime = $imgInfo['mime']; 
     
    // Creamos una imagen
    switch($mime){ 
        case 'image/jpeg': 
            $image = imagecreatefromjpeg($source); 
            break; 
        case 'image/png': 
            $image = imagecreatefrompng($source); 
            break; 
        case 'image/gif': 
            $image = imagecreatefromgif($source); 
            break; 
        default: 
            $image = imagecreatefromjpeg($source); 
    } 
     
    // Guardamos la imagen
    return imagejpeg($image, $destination, $quality); 
    // Devolvemos la imagen comprimida
    //return $destination; 
} 

?>