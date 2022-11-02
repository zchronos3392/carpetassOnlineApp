<?php
/**
 * Obtiene todas las Clubs de la base de datos
 */
require ('Materia.php');
if($_SERVER['REQUEST_METHOD'] == 'POST') {
//	"materianombre","icursomateria","colegiomateria,"ianio"
	$materianombre="";
	$icursomateria=$colegiomateria=$anioCurso=0;
	
	//año del curso...
	if(isset($_POST['ianio']))
		$anioCurso = $_POST['ianio'];		
	//nombre o codigo de la materia
	if(isset($_POST['materianombre']))
		$materianombre = $_POST['materianombre'];	
	
	//nivel id
	if(isset($_POST['icursomateria']))
		$cursomateria = $_POST['icursomateria'];		
	
	//colegio id
	if(isset($_POST['colegiomateria']))
		$colegiomateria = $_POST['colegiomateria'];
    // Insertar Curso
    $retorno = Materias::insert($anioCurso,$colegiomateria,$cursomateria,$materianombre);

	if ($retorno) 
	  {
	        $datos["estado"] = 1;
	    $datos["Materias"] = array($retorno);//es un array
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
