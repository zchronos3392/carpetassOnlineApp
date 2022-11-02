<?php
/**
 * Obtiene todas los Colegios de la base de datos
 */
define('__ROOT__', dirname(dirname(__FILE__)));
require ('Materia.php');
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petici�n GET
    
//{"personaid" : personaid};
  $personaid=0;
  if(isset($_GET['personaid']))
  		$personaid	= $_GET['personaid'];

  $ianio=0;
  if(isset($_GET['ianio']))
  		$ianio	= $_GET['ianio'];

  $cursoid=0;
  if(isset($_GET['cursoid']))
  		$cursoid = $_GET['cursoid'];
  	  			
    // ESTA VOLVIENDO UN VECTOR DE VECTORES
    	//print_r ($registros["0"]["count(*)"]);
	$Materias = Materias::getAllPersona($personaid,$ianio);
	
	$indiceCursos=0;
	//print_r($Materias);
	$CarpetaPath = "";    
    if ($Materias) 
    {
    	$carpetaOrigen = __ROOT__."/uploads/";
		$i = 0;
		$cursoActual="";
		//$conteo = count($Materias);
		//echo "<br> Resultado conteo Materias $conteo <br>";
		while ( $i <= count($Materias)-1 )
		 {
		 	//echo " <br>WHILE 1 valor del indice materias: $i <br>";
			//nombreMateria ,usuariopersona,curcursos.nombreCurso,curcolegio.nombreColegio	
	    	$Cursos[$indiceCursos]['curso']=$Materias[$i]['nombreCurso'];
	    	$pesoCursoMB=0;
	    	$cursoActual = $Materias[$i]['nombreCurso'];
			while(($i <= count($Materias)-1) && $cursoActual == $Materias[$i]['nombreCurso'] )
			{
		 	//echo " <br>WHILE 2 valor del indice materias: $i <br>";
				
			$anio 					= $Materias[$i]['anioCurso'];
			$usuarioFolder			= $Materias[$i]['usuariopersona'];
			$nombreColegioFolder	= $Materias[$i]['nombreColegio']; 
			$CursoFolder			= $Materias[$i]['nombreCurso']; 
			$MateriaFolder	= $Materias[$i]['nombreMateria']; 
			//echo "<br>Analizando $MateriaFolder <br>";
			//el path fisico tiene que tener las barras hacia la DERECHA
			$CarpetaPath = $carpetaOrigen.$anio."/".$usuarioFolder."/".$nombreColegioFolder."/".$CursoFolder."/".$MateriaFolder."/";
		 	if(is_dir($CarpetaPath))
		 	{
				$HijosCarpeta = array_diff(scandir($CarpetaPath), array('..', '.'));
				$valid_extensions = array("jpeg", "jpg", "png");
				$hojasEnCarpeta=0;
				$pesoCarpetaKB = 0;
				//peso de la carpeta
				foreach($HijosCarpeta as $clave=>$value)
				{
				  $extensionFile = explode(".", $value);
				  $file_extension = end($extensionFile);
				  if(in_array($file_extension, $valid_extensions))
						$hojasEnCarpeta++;
						//Calculo Tamaño hojas
							$imgInfo = @filesize($CarpetaPath."/".$value); 
							$imgInfo /= 1024; //en kb
				//$imgInfo /= 1024; 
							$pesoCarpetaKB += $imgInfo;
							//echo "<br>Tamaño imagen $imgInfo kb <br>";
				//Calculo Tamaño hojas
				}
				$pesoCarpetaKB /= 1024; //lo paso a mb
				$pesoCarpetaKB = intval($pesoCarpetaKB);
				//$Materias[$i]['conteoMateria'] = "<br>($hojasEnCarpeta hjs,$pesoCarpetaKB MB)";
			} //es un directorio
			$pesoCursoMB += $pesoCarpetaKB;
		    $i++;
		   };
		   $Cursos[$indiceCursos]['PesoCurso']=$pesoCursoMB."MB";
		   $indiceCursos++;
		 } //recorro las materias asignadas
	 }	//vector de Materias de la Persona		
	
//	$Cursos[1]['curso']="CURSO DE CONTROL";
//	$Cursos[1]['PesoCurso']=" 1000 MB";
	 
    if ($Cursos) 
    {
		//Array ( [0] => Array ( [idclub] => 4 [nombre] => BOCAb [clubabr] => BJR ) )
        $datos["estado"] = 1;
        $datos["Cursos"] = $Cursos;//es un array
        //el print lo puedo usar para cuando lo llamo desde android
    }
    else
    {
			//Array ( [0] => Array ( [idclub] => 4 [nombre] => BOCAb [clubabr] => BJR ) )
        $datos["estado"] = 22;
        $datos["Materias"] = $Materias;//es un array
        //el print lo puedo usar para cuando lo llamo desde android
	}
	print json_encode($datos); 	
}

?>
