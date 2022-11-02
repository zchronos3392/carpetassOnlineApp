<?php
/**
 * Obtiene todas las Clubs de la base de datos
 */
require ('Materia.php');
if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$idmateria=0;
	if(isset($_POST['idmateria']))
		$idmateria = $_POST['idmateria'];
    // Eliminar Colegio
    $retorno = Materias::delete($idmateria);

	if ($retorno) 
	  {
	        $datos["estado"] = 1;
	        //el print lo puedo usar para cuando lo llamo desde android
	  }
	else
	{
		$datos["estado"] = 2;
	    $datos["Materias"] = array($retorno);//es un array
 	}	
	print json_encode($datos); 	
}

?>
