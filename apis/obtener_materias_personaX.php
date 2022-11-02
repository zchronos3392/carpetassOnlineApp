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
	$MateriasAsignadas = Materias::getAllPersonaCurso($personaid,$ianio,$cursoid);
    $MateriaCompleto   = Materias::getAnioCurso($ianio,$cursoid);

	//	$pila = array("naranja", "plátano");
	//	array_push($pila, "manzana", "arándano");
	 $Materias = array();
	//empujo las materias con usuario..
    if(is_array($MateriasAsignadas))
 	   foreach($MateriasAsignadas as $clave => $datosMateria)
    		array_push($Materias, $datosMateria);

	$consulta="";
// based on original work from the PHP Laravel framework
//	if (!function_exists('str_contains'))
//	 {
//  	function str_contains($haystack, $needle) {
//        	$consulta !== '' && mb_strpos($MateriaCompleto, 'SQLSTATE') !== false;
//     }
//	}
	if(is_array($MateriaCompleto)){
	for($i=0;$i < count($MateriaCompleto);$i++)
    {
		$existe = buscarMateria($Materias,$MateriaCompleto[$i]);
	    if(! $existe) {
			$MateriaCompleto[$i]['usuariopersona']="";
			$MateriaCompleto[$i]['nombrepersona']="";
			$MateriaCompleto[$i]['tipopersona']="";

	    	array_push($Materias, $MateriaCompleto[$i]);
		}
	}

	$CarpetaPath = "";    
    if ($Materias) 
    {
    	$carpetaOrigen = __ROOT__."/uploads/";
		for ($i = 0; $i < count($Materias); $i++)
		 {
			if(isset($Materias[$i]['usuariopersona'])){
			//nombreMateria ,usuariopersona,curcursos.nombreCurso,curcolegio.nombreColegio	
			$anio 					= $Materias[$i]['aniocurso'];
			$usuarioFolder			= $Materias[$i]['usuariopersona'];
			$nombreColegioFolder	= $Materias[$i]['nombrecolegio']; 
			$CursoFolder			= $Materias[$i]['nombrecurso']; 
			$MateriaFolder	= $Materias[$i]['nombremateria']; 

			//el path fisico tiene que tener las barras hacia la DERECHA
			$CarpetaPath = $carpetaOrigen.$anio."/".$usuarioFolder."/".$nombreColegioFolder."/".$CursoFolder."/".$MateriaFolder."/";
		 	if(is_dir($CarpetaPath))
		 	{
				$HijosCarpeta = array_diff(scandir($CarpetaPath), array('..', '.'));

				$valid_extensions = array("jpeg", "jpg", "png");
				$hojasEnCarpeta=0;
				foreach($HijosCarpeta as $clave=>$value)
				{
				  $extensionFile = explode(".", $value);
				  $file_extension = end($extensionFile);
				  if(in_array($file_extension, $valid_extensions))
						$hojasEnCarpeta++;
				}
				$Materias[$i]['conteoMateria'] = "<br>($hojasEnCarpeta hjs)";
			} //es un directorio
		 } //recorro las materias asignadas
	  } // tiene un usuario cargado...
	 }	//vector de Materias de la Persona		
  } // HAY DATOS..
	    
    if ($Materias) 
    {
		//Array ( [0] => Array ( [idclub] => 4 [nombre] => BOCAb [clubabr] => BJR ) )
        $datos["estado"] = 1;
        $datos["Materias"] = $Materias;//es un array
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

function buscarMateria($Materias,$MateriaEnviada){

    foreach($Materias as $clave => $datosMateria)
    	foreach($datosMateria as $clave => $componentesMateria)
				//echo "<br>$clave : $componentesMateria <br>";
					if($clave == "idmateria")
						if($MateriaEnviada['idmateria'] == $componentesMateria)
							return true;	
	
return false;	
}


?>
