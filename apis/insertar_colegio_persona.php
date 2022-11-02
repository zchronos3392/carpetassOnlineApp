<?php
/**
 * Obtiene todas las Clubs de la base de datos
 */
require ('Colegio.php');
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	//{"personaid":"colegiopersona"	
	
	$colegiopersona=$personaid=0;
	if(isset($_POST['colegiopersona']))
		$colegiopersona = $_POST['colegiopersona'];

	if(isset($_POST['personaid']))
		$personaid = $_POST['personaid'];


	$CreaColegioPersona = date_create()->format('Y-m-d H:i:s');// fecha corecta de ahora
	$CreaColegioPersona = "'".$CreaColegioPersona."'";	
    // Insertar Persona en Colegio
    $retorno = Colegio::insertPersona($colegiopersona,$personaid,$CreaColegioPersona);	

	if ($retorno) 
	  {
	        $datos["estado"] = 1;
	        //el print lo puedo usar para cuando lo llamo desde android
	  }
	else
	{
		$datos["estado"] = 2;
	    $datos["ColegioPersona"] = array($retorno);//es un array
 	}	
	print json_encode($datos); 	
}

?>
