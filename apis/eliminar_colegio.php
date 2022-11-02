<?php
/**
 * Obtiene todas las Clubs de la base de datos
 */
require ('Colegio.php');
if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$idcolegio=0;
	if(isset($_POST['idcolegio']))
		$idcolegio = $_POST['idcolegio'];
    // Eliminar Colegio
    $retorno = Colegio::delete($idcolegio);

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
