<?php
/**
 * Obtiene todas los Colegios de la base de datos
 */
require ('Materia.php');
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petici�n GET
		$accion="";
			if(isset($_GET['accion']))
				$accion = $_GET['accion'];
				
		$ianio=0;
			if(isset($_GET['ianio']))
				$ianio = $_GET['ianio'];
				
		$cursoid=0;				
			if(isset($_GET['cursoid']))
				$cursoid = $_GET['cursoid'];
		$materiaid=0;						
			if(isset($_GET['materiaid']))
				$materiaid = $_GET['materiaid'];
		$colegioid=0;						
			if(isset($_GET['colegioid']))
				$colegioid = $_GET['colegioid'];
    	$persona=0;
			if(isset($_GET['personaid']))
				$persona = $_GET['personaid'];
				    	
    	$materia = 0;
    	echo "llamando a materia: $ianio, $colegioid, $cursoid, $materiaid , $persona <br>";
    	if($materiaid !=0) $materia = Materias::getById($ianio,$colegioid,$cursoid,$materiaid); 
    	//	print_r($materia); 
    	$nombreMateria = $materia['nombreMateria'];
    // ESTA VOLVIENDO UN VECTOR DE VECTORES
    	//print_r ($registros["0"]["count(*)"]);
    	if($accion == "AGREGA")
    		$Materias = Materias::insertMateriasPersona($ianio,$colegioid,$cursoid,$materiaid,$persona);
	   	if($accion == "ELIMINA")	
		    $Materias = Materias::deleteMateriasPersona($ianio,$colegioid,$cursoid,$materiaid,$persona);
		    
	    if ($Materias) 
	    {
			//Array ( [0] => Array ( [idclub] => 4 [nombre] => BOCAb [clubabr] => BJR ) )
	        $datos["estado"] = 1;
	        $datos["Materias"] = $Materias;//es un array
	        //el print lo puedo usar para cuando lo llamo desde android
	    }
	print json_encode($datos); 	
}

?>
