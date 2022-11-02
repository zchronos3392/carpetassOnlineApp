<?php
/**
 * Obtiene todas los Colegios de la base de datos
 */
require ('Materia.php');
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petici�n GET
    $registros = Materias::contar();
    // ESTA VOLVIENDO UN VECTOR DE VECTORES
    	//print_r ($registros["0"]["count(*)"]);
    if($registros["0"]["count(*)"] > "0")
     {
		$Materias = Materias::getAll();
	    
	    if ($Materias) 
	    {
			//Array ( [0] => Array ( [idclub] => 4 [nombre] => BOCAb [clubabr] => BJR ) )
	        $datos["estado"] = 1;
	        $datos["Materias"] = $Materias;//es un array
	        //el print lo puedo usar para cuando lo llamo desde android
	    }
	}
	else
	{
		$datos["estado"] = 2;
	    $datos["Materias"] = array("Tabla vacía");//es un array
 	}	
	print json_encode($datos); 	
}

?>
