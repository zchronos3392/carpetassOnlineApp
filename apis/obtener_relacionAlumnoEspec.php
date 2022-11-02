<?php
/**
 * Obtiene todas las Clubs de la base de datos
 */
require ('RelacionPersona.php');
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petici�n GET
    //$registros = Persona::contar();
    // ESTA VOLVIENDO UN VECTOR DE VECTORES
    	//print_r ($registros["0"]["count(*)"]);
    	$idPersona=0;
    if(isset($_GET['filtroPersona']))
    		$idPersona=	$_GET['filtroPersona'];
    if($idPersona== 999)$idPersona=0;
    
	$personas = EspecialistaAlumno::getByIdAlumno($idPersona);
		
	if ($personas) 
	    {
			//Array ( [0] => Array ( [idclub] => 4 [nombre] => BOCAb [clubabr] => BJR ) )
	        $datos["estado"] = 1;
	        $datos["Especialistas"] = $personas;//es un array
	        //el print lo puedo usar para cuando lo llamo desde android
	    }
	else
	{
		$datos["estado"] = 22;
	    $datos["Especialistas"] = array("Error en query Filtro(filtroPersona) :",$_GET['filtroPersona']);//es un array
 	}	
	    
	print json_encode($datos); 	
}

?>
