<?php
/**
 * Obtiene todas las Clubs de la base de datos
 */
require ('Colegio.php');
if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$colegionombre="";
	if(isset($_POST['colegionombre']))
		$colegionombre = $_POST['colegionombre'];
	$CreaColegio = date_create()->format('Y-m-d H:i:s');// fecha corecta de ahora
	$CreaColegio = "'".$CreaColegio."'";	
    // Insertar Colegio
    $retorno = Colegio::insert($colegionombre,$CreaColegio);	

	if ($retorno) 
	  {
	        $datos["estado"] = 1;
	        //el print lo puedo usar para cuando lo llamo desde android
	  }
	else
	{
		$datos["estado"] = 2;
	    $datos["Colegios"] = array($retorno);//es un array
 	}	
	print json_encode($datos); 	
}

?>
