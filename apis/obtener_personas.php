<?php
/**
 * Obtiene todas las Clubs de la base de datos
 */
require ('Persona.php');
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petici�n GET
    $registros = Persona::contar();
    // ESTA VOLVIENDO UN VECTOR DE VECTORES
    	//print_r ($registros["0"]["count(*)"]);
    	$idPersona=0;
    	if(isset($_GET['filtroPersona']))
    		$idPersona=	$_GET['filtroPersona'];
    	if($idPersona== 999)$idPersona=0;

    	$llamador="";
    	if(isset($_GET['llama']))
    		$llamador=	$_GET['llama'];

    		  
    if($registros["0"]["count(*)"] > "0")
     {
     	
     	if($idPersona == 0)
			$personas = Persona::getAll();
		else
			if($llamador == "COMBOESPECIALISTA")
					$personas = Persona::getAllEspecialista($idPersona);
			else
					$personas = Persona::getById($idPersona);
		
	    
	    if ($personas) 
	    {
			//Array ( [0] => Array ( [idclub] => 4 [nombre] => BOCAb [clubabr] => BJR ) )
	        $datos["estado"] = 1;
	        $datos["Personas"] = $personas;//es un array
	        //el print lo puedo usar para cuando lo llamo desde android
	    }
	    else
	{
		$datos["estado"] = 22;
	    $datos["Personas"] = array("Error en query Filtro(filtroPersona) :",$_GET['filtroPersona']);//es un array
 	}	
	    
	}
	else
	{
		$datos["estado"] = 2;
	    $datos["Personas"] = array("Tabla vacia");//es un array
 	}	
	print json_encode($datos); 	
}

?>
