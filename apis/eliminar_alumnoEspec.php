<?php
/**
 * Obtiene todas las Clubs de la base de datos
 */
require ('RelacionPersona.php');
if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$especialista=0;
	if(isset($_POST['especialista']))
		$especialista = $_POST['especialista'];

	$alumno=0;
	if(isset($_POST['alumno']))
		$alumno = $_POST['alumno'];

    // Eliminar Alumno del Especialista
	    $retorno = EspecialistaAlumno::deleteAluFromEspec($especialista,$alumno);


	if ($retorno) 
	  {
	        $datos["estado"] = 1;
	        //el print lo puedo usar para cuando lo llamo desde android
	  }
	else
	{
		$datos["estado"] = 2;
	    $datos["Relaciones"] = array($retorno);//es un array
 	}	
	print json_encode($datos); 	
}

?>
