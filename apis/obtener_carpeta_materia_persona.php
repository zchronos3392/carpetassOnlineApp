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
	$filtroFechaCarga = "";
	$filtroTemas	= "";
    // ESTA VOLVIENDO UN VECTOR DE VECTORES
    	//print_r ($registros["0"]["count(*)"]);
	$MateriasPersona = Materias::getAllPersona($personaid,$ianio);
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
	//$icurso					= $MateriasPersona[$i]['idcurso']; 
	//$imateria				= $MateriasPersona[$i]['idmateria']; 
	
	for ($i = 0; $i < count($MateriasPersona); $i++) {
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
	$registro="";
	//Si es un directorio
		if(is_dir($CarpetaPath)) {
			$HojasCarpetaFS = array_diff(scandir($CarpetaPath), array('..', '.'));
			if($MateriaFolder !="")
					$HojasDB		= HojasCarpeta::getByMateria($personaid,$ianio,$icurso,$imateria,$filtroFechaCarga,$filtroTemas);
			//Array ( [0] => Array ( [anioCurso] => 2022 [idCurso] => 1 [idpersona] => 1 
			//		  [idMateria] => 6    [hojaId] => 1   [nrohoja] => 1 
			//		  [fechaCarga] => 2022-02-09  
			//[nombreHoja] => wp_ss_20170914_0002.png 
			//[obsUNO] => [obsDOS] => 
			//[quienSube] => 1 , [usuariopersona] => cipriano, [vistael] => ) )			
			//echo "erl arryar encontro: <br>";
			//	print_r($HojasDB);
			//echo "<br>";	
			If($HojasCarpetaFS != ""){
			//Miramos si existen archivos
				if (count($HojasCarpetaFS) > 0){
				//echo 'El directorio tiene archivos..mostrando:';
					$registro="";
					foreach($HojasCarpetaFS as $clave=>$value)
					{
					if($MateriaFolder !=""){
						
               			$registro.="<div class='col s12 m4 l3'>";
                    	$registro.="<div class='material-placeholder' >";
                    	if($llamaQuien=="CARGAR"){
                    		$epigrafeHoja=$claveIMAGEN = "";
							$claveIMAGEN  = buscarIMAGEN($value,$HojasDB);
							$epigrafeHoja = generaEpigrafe($value,$HojasDB);
                    		$registro.="<div class='sobreImagen' id='eliminarTHIS_".$claveIMAGEN."' onclick='eliminarimagen(this)' >X";
						}
	                	//echo "$clave => $value<br>";	
						//$registro.=
                        $registro.="<img src='".$PathdeUso."\\".$value."' alt='' class='responsive-img materialboxed' data-caption='hoja de carpeta nro XX, cargada el 99/99/9999' |'></div></div>";
                       
                        if($llamaQuien=="CARGAR")
                    			$registro.="$epigrafeHoja</div>";
                    		 
							//echo "$registro";
							//print_r($value);
					  }
				    }	

				}
		  }
	  }	  

													
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

function generaEpigrafe($valorNombreImagen,$HojasDB)
{
//Array ( [anioCurso] => 2022 [idCurso] => 1 [idpersona] => 1 
//		  [idMateria] => 6    [hojaId] => 1   [nrohoja] => 1 
//		  [fechaCarga] => 2022-02-09  
//[nombreHoja] => wp_ss_20170914_0002.png 
//[obsUNO] => [obsDOS] => 
//[quienSube] => 1 , [usuariopersona] => cipriano, [vistael] => )						
$epigrafeHoja = "";	
	if(is_array($HojasDB))
	{
		for($i=0;$i < count($HojasDB);$i++)
		{
			if($HojasDB[$i]['nombreHoja'] == $valorNombreImagen)
			{
				//[anioCurso] => 2022 [idCurso] => 1 [idpersona] => 1 [idMateria] => 6 [hojaId] => 1
					$epigrafeHoja = "<span>Cargada el ".$HojasDB[$i]['fechaCarga']." por ".$HojasDB[$i]['usuariopersona'];
					//$HojasDB[$i]['vistael'];
			}					
		}
	}	
return $epigrafeHoja;
}


function buscarIMAGEN($valorNombreImagen,$HojasDB)
{
//Array ( [anioCurso] => 2022 [idCurso] => 1 [idpersona] => 1 
//		  [idMateria] => 6    [hojaId] => 1   [nrohoja] => 1 
//		  [fechaCarga] => 2022-02-09  
//[nombreHoja] => wp_ss_20170914_0002.png 
//[obsUNO] => [obsDOS] => 
//[quienSube] => 1 , [usuariopersona] => cipriano, [vistael] => )						
$claveIMAGEN = "";	
	if(is_array($HojasDB))
	{
		for($i=0;$i < count($HojasDB);$i++)
		{
			if($HojasDB[$i]['nombreHoja'] == $valorNombreImagen)
			{
				//[anioCurso] => 2022 [idCurso] => 1 [idpersona] => 1 [idMateria] => 6 [hojaId] => 1
				$claveIMAGEN = $HojasDB[$i]['anioCurso']."_".$HojasDB[$i]['idCurso']."_".$HojasDB[$i]['idpersona']."_".$HojasDB[$i]['idMateria']."_".$HojasDB[$i]['hojaId'];
					$epigrafeHoja = "<span>Cargada el ".$HojasDB[$i]['fechaCarga']." por ".$HojasDB[$i]['usuariopersona'];
					//$HojasDB[$i]['vistael'];
			}					
		}
	}	
return $claveIMAGEN;
}

?>
