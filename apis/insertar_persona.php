<?php
/**
 * Obtiene todas las Clubs de la base de datos
 */
require ('Persona.php');
if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$usuariopersona=$nombrepersona=$tipopersona="";
	if(isset($_POST['usuariopersona']))
		$usuariopersona = $_POST['usuariopersona'];
	
	$nombrepersona  = $usuariopersona;
	if(isset($_POST['tipopersona']))
		$tipopersona    = $_POST['tipopersona'];
    // Insertar ciudad
    $retorno = Persona::insert($usuariopersona,$nombrepersona,$tipopersona);

	if ($retorno) 
	  {
	        $datos["estado"] = 1;
	        //el print lo puedo usar para cuando lo llamo desde android
	  }
	else
	{
		$datos["estado"] = 2;
	    $datos["Personas"] = array($retorno);//es un array
 	}	
	print json_encode($datos); 	
}

?>
