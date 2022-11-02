<?php
/**
 * Obtiene todas los Colegios de la base de datos
 */
require_once('Carpeta.php');

define('__ROOT__', dirname(dirname(__FILE__)));
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petici�n GET
//"llamador":"ListaUpdates"};    
//{"personaid" : personaid};
  $personaid=0;
  if(isset($_GET['personaid']))
  		$personaid	= $_GET['personaid'];

  $ianio=0;
  if(isset($_GET['ianio']))
  		$ianio	= $_GET['ianio'];

  $opcion2="";
  if(isset($_GET['opcion2']))
  		$opcion2 = $_GET['opcion2'];

	$temaBuscardo="";
	  if(isset($_GET['temaBuscardo']))
  		$temaBuscardo = $_GET['temaBuscardo'];

  $llamaQuien = "";
	if(isset($_GET['llamador']))
		    $llamaQuien = $_GET['llamador'];
		    	 
	if($opcion2 == "S")	
		$HojasDB  = HojasCarpeta::getStats2updTema($temaBuscardo);
	else    	  			
		$HojasDB  = HojasCarpeta::getStats2upd($personaid,$ianio);
	
													
    $datos["estado"] = 1;
    $datos["EstadisticasCarpetas"] = $HojasDB;//

	print json_encode($datos); 	
}


?>
