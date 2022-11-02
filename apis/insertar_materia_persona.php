<?php
/**
 * Obtiene todas las Clubs de la base de datos
 */
require ('Materia.php');
if($_SERVER['REQUEST_METHOD'] == 'POST') {
//"persona","icursomateria,"ianio"	

	$cursomateria=$persona=$anioCurso=0;
	
	//año del curso...
	if(isset($_POST['ianio']))
		$anioCurso = $_POST['ianio'];		
		
	//curso id
	if(isset($_POST['icursomateria']))
		$cursomateria = $_POST['icursomateria'];		
	//persona id
	if(isset($_POST['persona']))
		$persona = $_POST['persona'];
	$retorno=0;	
    // Insertar Materias a la Persona
	$registrosMateria = Materias::getAnioCurso($anioCurso,$cursomateria);
	for($i=0;$i < count($registrosMateria);$i++)
	{
		$anioCurso		= $registrosMateria[$i]['anioCurso'];
		$idcolegio		= $registrosMateria[$i]['idcolegio'];
		$cursomateria	= $registrosMateria[$i]['idCurso'];
		$idMateria      = $registrosMateria[$i]['idMateria'];
		    $retorno = Materias::insertMateriasPersona($anioCurso,$idcolegio,$cursomateria,$idMateria,$persona);
	}

	if ($retorno) 
	  {
	    $datos["estado"] = 1;
	    $datos["Materias"] = array($retorno);//es un array
	        //el print lo puedo usar para cuando lo llamo desde android
	  }
	else
	{
		$datos["estado"] = 2;
	    $datos["Materias"] = $registrosMateria;//es un array
 	}	
	print json_encode($datos); 	
}

?>
