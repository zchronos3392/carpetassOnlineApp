<?php
/**
 * Obtiene todas las Clubs de la base de datos
 */
require ('Nivel.php');
if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$descripcionNivel="";
	if(isset($_POST['nivelnombre']))
		$descripcionNivel = $_POST['nivelnombre'];
    // Insertar Nivel
    $retorno = Niveles::insert($descripcionNivel);	

	if ($retorno) 
	  {
	        $datos["estado"] = 1;
	        //el print lo puedo usar para cuando lo llamo desde android
	  }
	else
	{
		$datos["estado"] = 2;
	    $datos["Niveles"] = array($retorno);//es un array
 	}	
	print json_encode($datos); 	
}

?>
