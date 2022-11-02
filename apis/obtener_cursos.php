<?php
/**
 * Obtiene todas los Colegios de la base de datos
 */
require ('Curso.php');
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petici�n GET
    $registros = Cursos::contar();
    // ESTA VOLVIENDO UN VECTOR DE VECTORES
    	//print_r ($registros["0"]["count(*)"]);

	$personaid = 0;
	if(isset($_GET["personaid"]))
			$personaid = $_GET["personaid"];

    $datos["estado"] = 0;	
    if($registros["0"]["count(*)"] > "0")
     {
     	if($personaid == 0)
			$Cursos = Cursos::getAll();
	    else
		    $Cursos = Cursos::getAllPersona($personaid);
		    
		    
	    if ($Cursos) 
	    {
			//Array ( [0] => Array ( [idclub] => 4 [nombre] => BOCAb [clubabr] => BJR ) )
	        $datos["estado"] = 1;
	        $datos["Cursos"] = $Cursos;//es un array
	        //el print lo puedo usar para cuando lo llamo desde android
	    }
	}
	else
	{
		$datos["estado"] = 2;
	    $datos["Cursos"] = array("Tabla vacía");//es un array
 	}	
	print json_encode($datos); 	
}

?>
