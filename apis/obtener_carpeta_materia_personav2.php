<?php
/**
 * Obtiene todas los Colegios de la base de datos
 */
require ('Materia.php');
require_once('Carpeta.php');

define('__ROOT__', dirname(dirname(__FILE__)));
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petici�n GET
    
//{"personaid" : personaid};
  $personaid=0;
  if(isset($_GET['personaid']))
  		$personaid	= $_GET['personaid'];
  $materiaNombre="";
  if(isset($_GET['materiaNombre']))
  		$materiaNombre	= $_GET['materiaNombre'];

  $ianio=0;
  if(isset($_GET['ianio']))
  		$ianio	= $_GET['ianio'];

  $llamaQuien = "";
	if(isset($_GET['llamador']))
		    $llamaQuien = $_GET['llamador'];
		    	  			
  //desde VERMATERIAS, se agrega la posibilidad de filtrar imagenes..		    	  			
  $filtroFechaCarga = "";
	if(isset($_GET['filtroParms']))
		    $filtroFechaCarga = $_GET['filtroParms'];
		    
	$filtroTemas="";
		if(isset($_GET['filtroTemas']))
		    $filtroTemas = $_GET['filtroTemas'];

    // ESTA VOLVIENDO UN VECTOR DE VECTORES
    	//print_r ($registros["0"]["count(*)"]);
	//	obtengo la lista de materias de la persona que llego para no traer de TODOS
	$MateriasPersona = Materias::getAllPersona($personaid,$ianio);
	//armo el path completo de la carpeta de esa persona ( por persona, año, colegio, curso,    //materia)
	$CarpetaPath = "";    
    if ($MateriasPersona) 
    {
	$carpetaOrigen = __ROOT__."/uploads/";
	$i=0;
	//nombreMateria ,usuariopersona,curcursos.nombreCurso,curcolegio.nombreColegio	
	$anio 					= $MateriasPersona[$i]['anioCurso'];
	$usuarioFolder			= $MateriasPersona[$i]['usuariopersona'];
	$nombreColegioFolder	= $MateriasPersona[$i]['nombreColegio']; 
	$CursoFolder			= $MateriasPersona[$i]['nombreCurso']; 
	$MateriaFolder			= "";
	$icurso					= 0; 
	$imateria				= 0; 
	
	for ($i = 0; $i < count($MateriasPersona); $i++)
	{
			if($MateriasPersona[$i]['nombreMateria'] == $materiaNombre )
			{
					$MateriaFolder	= $MateriasPersona[$i]['nombreMateria']; 
					$icurso					= $MateriasPersona[$i]['idcurso']; 
					$imateria				= $MateriasPersona[$i]['idmateria']; 
			}
	}			
				
	
	//el path fisico tiene que tener las barras hacia la DERECHA
	$CarpetaPath = $carpetaOrigen.$anio."/".$usuarioFolder."/".$nombreColegioFolder."/".$CursoFolder."/".$MateriaFolder;
	//el path virtual tiene que enviarse con las barras hacia la IZQUIERDA
	$PathdeUso = ".\\uploads\\".$anio."\\".$usuarioFolder."\\".$nombreColegioFolder."\\".$CursoFolder."\\".$MateriaFolder."\\";
	//armo el path completo de la carpeta de esa persona ( por persona, año, colegio, curso,    //materia)
								
// FILTRAMOS LAS HOJAS QUE CUMPLAN EL FILTRO
//mando siempre EL FILTRO DE TEMA AUNQUE NO VENGA SIEMPRE CON VALOR..	
	$registro="";
	$HojasDB		= HojasCarpeta::getByMateria($personaid,$ianio,$icurso,$imateria,$filtroFechaCarga,$filtroTemas);
	
	//vector de registros de imagenes cargadas: 
	if(is_array($HojasDB))
	{
	$i=0;
	while ($i < count($HojasDB))
		{
			//echo "<br> Fecha carga hoja: ".$HojasDB[$i]['fechaCarga']."<br>";
		   $fechaAnalisis=$HojasDB[$i]['fechaEnHoja'];
			$registro.="<div class='bloqueFechas'><div class='bloqueFechasitem1'> Cargado el ".$fechaAnalisis."</div>";
		   	$registro.="<div class='bloqueFechasitem2'>"; 
		   	while ($i < count($HojasDB) && ($fechaAnalisis == $HojasDB[$i]['fechaEnHoja']))
			{
			//[anioCurso] => 2022 [idCurso] => 1 [idpersona] => 1 [idMateria] => 6 [hojaId] => 1
               	$registro.="<div class='col s12 m4 l3'>";
            	$registro.="<div class='material-placeholder' >";
                //$registro.="<div class='grillaimagen' >";	
                //$registro.="<div class='grillaimagenitem1' >";
                	$epigrafeHoja=$claveIMAGEN = "";
                	if($llamaQuien=="CARGAR")
                	{
							$claveIMAGEN = $HojasDB[$i]['anioCurso']."_".$HojasDB[$i]['idCurso']."_".$HojasDB[$i]['idpersona']."_".$HojasDB[$i]['idMateria']."_".$HojasDB[$i]['hojaId'];
                			$registro.="<div class='sobreImagen' id='eliminarTHIS_".$claveIMAGEN."' onclick='eliminarimagen(this)' >X</div>";
					}
				$value = "";	
				$value = $HojasDB[$i]['nombreHoja'];	
				
				//Calculo Tamaño hojas
				//$imgInfo = @filesize($CarpetaPath."/".$value); 
				//$imgInfo /= 1024; 
				//$imgInfo /= 1024; 
					//echo "Tamaño imagen $imgInfo kb <br>";
				//Calculo Tamaño hojas
				
                $registro.="<img src='".$PathdeUso."\\".$value."' alt='' class='responsive-img materialboxed' data-caption='hoja de carpeta nro XX, cargada el 99/99/9999' |'>";
                //if($llamaQuien=="CARGAR")
                //$registro.="</div>";//grillaimagenitem1
				$epigrafeHoja = "<span>Cargada el ".$HojasDB[$i]['fechaCarga']." por ".$HojasDB[$i]['usuariopersona']."<br>".$HojasDB[$i]['obsUNO']."</span>";		
                //$registro.="<div class='grillaimagenitem2' >";
                $registro.="$epigrafeHoja"; // </div> grillaimagenitem2
                //$registro.="</div>";//grillaimagen
                $registro.="</div>"; //material placehol
                $registro.="</div>"; //col s12..
		   		$i++;  
			}   	
			$registro.="</div>";
			$registro.="</div>";//bloqueFechas
		} //recorriendo la tabla original..
	  } //tiene imagenes cargadas en el vector del query de tabla..
													
    $datos["estado"] = 1;
    $datos["PathArmado"] = $CarpetaPath;//
    $datos["Galeria"] = $registro;//
        //el print lo puedo usar para cuando lo llamo desde android
    }
    else
    {
			//Array ( [0] => Array ( [idclub] => 4 [nombre] => BOCAb [clubabr] => BJR ) )
        $datos["estado"] = 22;
        $datos["PathArmado"] = $CarpetaPath;//es un array
        //el print lo puedo usar para cuand0o lo llamo desde android
	}
	print json_encode($datos); 	
}


?>
