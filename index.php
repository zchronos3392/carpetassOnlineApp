<HTML>
<HEAD>
<title>Inicio. Administracion Sistema Carpetas</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="styles/disenioCarpetas.css">
	<link rel="stylesheet" href="styles/normalize.css">

    <link rel="stylesheet" href="styles/iconstyle.css">
    <link rel="stylesheet" href="styles/demo.css">

	<link rel="icon" href="favicon.ico">
</HEAD>
<!--SCRIPTS PRIMERO HAY QUE VINCULAR LA LIBERIA JQUERY PARA QUE RECONOZCA EL $-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<!--SCRIPTS-->
		<script src="scripts/carpetas.js"> </script>
<script>
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$(document).ready(function(){

			var f=new Date();
			var FechaHoy = f.getFullYear()-1 ;
			fechainicial = FechaHoy -10;
			fechaFinal   = FechaHoy +10;
			for (var i = fechainicial; i < fechaFinal; i++) 
			{
				if(i == FechaHoy) $("#ianio").prepend('<option selected>' + (i + 1) + '</option>');
				else  $("#ianio").prepend('<option>' + (i + 1) + '</option>');
			}
			$("#ianio").prop('disabled', true);
			//me fijo sino exsitia, sino lo grabo yo..porque sno vendra vacio 
			// en las otras pantallas..
			var anioSession = 0;
				anioSession = leersesion("IANIO");
			//$(".errores").html("anio en sesion: "+anioSession);
			if(anioSession  != 0)
					$("#ianio").val(anioSession);
			else
					grabarsesion("IANIO",$("#ianio").val());					
					
//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++				
	 //var parametros = {"idClub" : $("#iclubescab").val()};	
		//pedirPersona('#personas');
				 pedirPersonaTipo('#personas',999,'ALUMNO');	
		  		 pedirPersonaTipo('#profesionales',999,'ESPECIALISTA');	
		pedirNiveles('#niveles');	
			pedirNiveles('#inivelCur'); 
		pedirColegio('#colegios');
			pedirColegio('#icolegiocurso');	 
				pedirColegio('#icolegiocursom');	
					pedirColegio('#ColegioPersona'); 
		pedirCursos('#cursos');	 
		 pedirCursos('#icursomateria');
		pedirMaterias('#materias');	 
		pedirCarpetas('#carpetasfs');
		pedirNovedades('#grillaNovedades');

		$("#filtroTemas").keyup(function()
		{
			pedirListaUpdatesxTema("#grillaTemasCont",$("#filtroTemas").val());
		});					

		$("#icursospersona").empty();	 

		$(".itemAcceso1").hide();
		$(".itemAcceso2").hide();
		$(".itemAcceso3").hide();
		$(".itemAcceso4").hide();
		$(".itemAcceso5").hide();
		$(".itemAcceso6").hide();
		$(".itemAcceso7").hide();
		$(".itemAcceso8").hide();
		$(".itemAcceso9").hide();
		$("#grillaTemasCont").empty();	
			$("#grillaTemas").hide();										
		
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++			

		$("#CrearDirectorios").on("click",function(){
				crearestructuradirectorios($('#personas').val());
		});

		$("#AgregaPersona").on("click",function(){
				agregapersona();
		});
		
		$("#AsignarMaterias").on("click",function(){
				var url = "asignarmaterias.php?idpersona="+$('#personas').val()+"&ianio="+$('#ianio').val();
					window.location.replace(url);
		});

		$("#Materias").on("click",function(){
				var url = "verMateriasAlumno.php?idpersonaINI="+$('#personas').val()+"&llama=INDEX&docenteINI="+$('#profesionales').val()+"&ianio="+$('#ianio').val();
					window.location.replace(url);
		});

		$("#CargarMaterias").on("click",function(){
				var url = "cargaHojasMateriasAlumno.php?idpersonaINI="+$('#personas').val()+"&llama=INDEX&docenteINI="+$('#profesionales').val()+"&ianio="+$('#ianio').val();
					window.location.replace(url);
		});

		
		$("#AsignarColegio").on("click",function(){
			
					var parametros = {"personaid":$('#personas').val(),"colegiopersona":$("#ColegioPersona").val()};	
				 	
				 	$.ajax({ 
				    url:   './apis/insertar_colegio_persona.php',
				    type:  'POST',
				    data: parametros ,
				    datatype:   'text json',
					// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
				    beforeSend: function (){},
				    done: function(data){},
				    success:  function (re){
						//idpersona, usuariopersona, nombrepersona, tipopersona         	  
							pedirPersona('#personas');	 	 			
				    },
				    error: function (xhr, ajaxOptions, thrownError)
				    	{
							// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
							$(".errores").html(xhr);
						}
				    });

			
			
			
		});
		
		$(".icono1").on("click",function(){
			$(".itemAcceso1").toggle();
				$(".itemAcceso2").hide();
				$(".itemAcceso3").hide();
				$(".itemAcceso4").hide();
				$(".itemAcceso5").hide();
				$(".itemAcceso6").hide();
				$(".itemAcceso7").hide();
				$(".itemAcceso8").hide();
				$(".itemAcceso9").hide();								
				$("#grillaNovedades").show();
				$("#grillaTemasCont").empty();	
				$("#grillaTemas").hide();							

		});
		
		$(".icono2").on("click",function(){
			$(".itemAcceso2").toggle();				
				$(".itemAcceso1").hide();
				$(".itemAcceso3").hide();
				$(".itemAcceso4").hide();
				$(".itemAcceso5").hide();
				$(".itemAcceso6").hide();
				$(".itemAcceso7").hide();
				$(".itemAcceso8").hide();
				$(".itemAcceso9").hide();
				$("#grillaNovedades").show();
				$("#grillaTemasCont").empty();					
				$("#grillaTemas").hide();							
		});

		$(".icono3").on("click",function(){
			$(".itemAcceso3").toggle();
				$(".itemAcceso1").hide();
				$(".itemAcceso2").hide();
				$(".itemAcceso4").hide();
				$(".itemAcceso5").hide();
				$(".itemAcceso6").hide();
				$(".itemAcceso7").hide();
				$(".itemAcceso8").hide();
				$(".itemAcceso9").hide();
				$("#grillaNovedades").show();
				$("#grillaTemasCont").empty();					
				$("#grillaTemas").hide();							
											
		});

		$(".icono4").on("click",function(){
			$(".itemAcceso4").toggle();				
				$(".itemAcceso1").hide();
				$(".itemAcceso2").hide();
				$(".itemAcceso3").hide();
				$(".itemAcceso5").hide();
				$(".itemAcceso6").hide();
				$(".itemAcceso7").hide();
				$(".itemAcceso8").hide();
				$(".itemAcceso9").hide();			
				$("#grillaNovedades").show();
				$("#grillaTemasCont").empty();					
				$("#grillaTemas").hide();							

		});

		$(".icono5").on("click",function(){
			$(".itemAcceso5").toggle();				
				$(".itemAcceso1").hide();
				$(".itemAcceso2").hide();
				$(".itemAcceso3").hide();
				$(".itemAcceso4").hide();
				$(".itemAcceso6").hide();
				$(".itemAcceso7").hide();
				$(".itemAcceso8").hide();
				$(".itemAcceso9").hide();			
				$("#grillaNovedades").show();
				$("#grillaTemasCont").empty();					
				$("#grillaTemas").hide();							
				
		});

		$(".icono6").on("click",function(){
			$(".itemAcceso6").toggle();				
				$(".itemAcceso1").hide();
				$(".itemAcceso2").hide();
				$(".itemAcceso3").hide();
				$(".itemAcceso4").hide();
				$(".itemAcceso5").hide();
				$(".itemAcceso7").hide();
				$(".itemAcceso8").hide();
				$(".itemAcceso9").hide();
				$("#grillaNovedades").show();
				$("#grillaTemasCont").empty();					
				$("#grillaTemas").hide();							
		});
		
		$(".icono7").on("click",function(){
			$(".itemAcceso7").toggle();				
				$(".itemAcceso1").hide();
				$(".itemAcceso2").hide();
				$(".itemAcceso3").hide();
				$(".itemAcceso4").hide();
				$(".itemAcceso5").hide();
				$(".itemAcceso6").hide();
				$(".itemAcceso8").hide();
				$(".itemAcceso9").hide();
				$("#grillaNovedades").toggle();
				$("#grillaTemas").toggle();
		});
		

		$("#AgregaColegio").on("click",function(){
				agregacolegio();
		});
		$("#AgregaNivel").on("click",function(){
				agreganivel();	
		});	
		$("#AgregaCurso").on("click",function(){
				agregacurso();
		});
		$("#AgregaMateria").on("click",function(){
				agregamateria();
		});

		$("#EliminarPersona").on("click",function(){
				EliminarPersona();
		});
		$("#EliminarColegio").on("click",function(){
				EliminarColegio();
		});
		$("#EliminarNivel").on("click",function(){
				EliminarNivel();	
		});	
		$("#EliminarCurso").on("click",function(){
				EliminarCurso();
		});
		$("#EliminarMateria").on("click",function(){
				EliminarMateria();
		});

		$("#EliminarCarpeta").on("click",function(){
				EliminarCarpeta();
		});

		$("#EliminaRelacion").on("click",function(){
				EliminarRelacion("#personas","#profesionales");
		});
		$("#AgregaRelacion").on("click",function(){
				AgregarRelacion("#personas","#profesionales");
		});
		
		$("#personas").on("change click",function()
		{
			var persona  = $('#personas').val();
				pedirCursosPersona("#icursospersona",persona);	 
				pedirPesoCarpeta("#pesoCarpetas",persona,$("#ianio").val());
				pedirRelaciones("#profesionalesAlumno",persona );
		});

		$("#ianio").on("change",function()
		{
			//graba el año en SESION
			grabarsesion("IANIO",$("#ianio").val());
		});
		
		$("#cargarotroanio").on("click",function()
		{
		  if( $("#cargarotroanio").is(':checked') )
		  {
			    $("#ianio").prop('disabled', false);
			    

		  } else
		   {
				$("#ianio").prop('disabled', true);
				var f=new Date();
				var FechaHoy = f.getFullYear() ;
				$("#ianio").val(FechaHoy);
				//grabar año en sesion
					grabarsesion("IANIO",$("#ianio").val());
    	   }
		});
		
		
	}); // parentesis del READY
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
</script>

<BODY>
<?php
	include('header.html');
?>	
  <div class="errores"></div>
  <div class="listaAccesos">

  <div class="grillaCambioAnio">
 	<div class="itemcambioanio1">
	   <A>Administrar Sistema Carpetas</A>
 	</div>
 	<div class="itemcambioanio2">
		<select id="ianio" name="ianio" class="ianio">
				<option value="9999">Seleccionar año...</option>
		</select>	
 	</div>
 	<div class="itemcambioanio3">
		<input type="checkbox" value="" id="cargarotroanio" ><A style="color:#fff;">Cargar años anteriores</A></input>
 	</div>
  </div>

<div class="iconosFunciones">
	<div class="icono1"><span class="icon-creative-commons-attribution"></span>Personas</div>
	<div class="icono2"><span class="icon-blackboard"></span>Colegios</div>
	<div class="icono3"><span class="icon-layers"></span>Nivel</div>
	<div class="icono4"><span class="icon-graduation-cap"></span>Curso</div>
	<div class="icono5"><span class="icon-open-book"></span>Materias</div>
	<div class="icono6"><span class="icon-download"></span>Carpetas</div>
	<div class="icono7"><span class="">Temas</span></div>
	<div class="icono8"><span class=""></span></div>
	<div class="icono9"><span class=""></span></div>	
</div>
  	<div class="itemAcceso1" id="AdmUsuario">Administrar Personas
  	  <div class="FormCabPersona">
		  <div class="itemCFPer1">Persona </div>
		  <div class="itemCFPer2">
		  		<select id="personas" class="personaSel">
		  			<option value="9999">Seleccione persona</option>
		  		</select>
		  </div>
		  <div class="itemCFPer3">Especialista </div>
		  <div class="itemCFPer4">
		    	<select id="profesionales" class="cursoSel"></select>
 		  </div>
 		   <div class="itemCFPer44">
 		  	Relacionar
 		  </div>

 		  <div class="itemCFPer5">
 		  <button class="agregarBoton" id="EliminaRelacion" />-
 		  </div>
 		  <div class="itemCFPer6">
 		  <button class="agregarBoton" id="AgregaRelacion" />+
 		  </div>
  	  </div>  		  

  	
			<div class="iconosFuncionesPersona">
				<div class="picono1" id="EliminarPersona"><span class="icon-creative-commons-attribution"></span>Borrar</div>
				<div class="picono2" id="AgregaPersona"><span class="icon-blackboard"></span>Agregar</div>
				<div class="picono4" id="CrearDirectorios"	><span class="icon-graduation-cap"></span>Estruc.</div>
				<div class="picono3  verdecito" id="Materias" ><span class=""></span>Carpeta</div>
				<div class="picono5 celeste" id="AsignarMaterias"><span class="icon-open-book"></span>Asig.Materias</div>
				<div class="picono6 rosa" id="CargarMaterias" ><span class="icon-download"></span>Uploads</div>
				<div class="picono7" id="AsignarColegio" ><span class="icon-layers"></span>Asig.Colegio</div>
				<div class="picono8">
					<select id="ColegioPersona" class="cursoSel">
	  		  				<option value="9999">Seleccione colegio</option>
	  		  		</select>
				<span class=""></span></div>
				<div class="picono9"><span class=""></span></div>	
			</div>  	
  		<div class="FormPersona">
		  <div class="itemFPer1">Cursos Alumno</div>
	  	  <div class="itemFPer2">
	  		  		<select id="icursospersona" class="personaSel">
	  		  			<option value="9999">Cursos...</option>
	  		  		</select>
	  	   </div>
-  		  <div class="itemFPer3">Peso Carpeta</div>
  		  <div class="itemFPer33">
  		  		<div id="pesoCarpetas"></div>
  		  </div>  		  
		  <div class="itemFPer4">
			  <div class="itemFPerAlta">		  
		  		  <div class="itemFPerA1">Nombre</div>
		  		  <div class="itemFPerA2"><input type="text" class="FormNombres" id="personaNombre" /></div>
		  		  <div class="itemFPerA3">
		  		  		Tipo Persona
		  		  </div>		
		  		  <div  class="itemFPerA4">		
		  		  		<select id="tipoPersona" class="personaSel">
		  		  			<option value="ALUMNO">ALUMNO</option>
		  		  			<option value="ESPECIALISTA">ESPECIALISTA</option>
		  		  		</select>
		  		  </div>
		  		  <div  class="itemFPerA5"></div>  		   
			</div>
		</div>
  		  <div  class="itemFPer5">Profesionales del Alumno
  		  	<select id="profesionalesAlumno" class="cursoSel"></select>
  		  </div>
  		</div>
  	</div>
	<div class="itemAcceso2"  id="AdmColegio">Administrar Colegios

  		<div class="FormColegio">
  		  <div class="itemFCol1">Colegios </div>
  		  <div class="itemFCol2">
  		  		<select id="colegios" class="colegioSel">
  		  			<option value="9999">Seleccione colegio</option>
  		  		</select>
  		  </div>  		  
  		  <div  class="itemFCol3">
  		  	<button class="agregarBoton" id="EliminarColegio" />-
  		  </div>  		     		  
  		  <div class="itemFCol4">Colegio</div>
  		  <div class="itemFCol5"><input type="text" class="FormNombres" id="colegioNombre" /></div>
  		  <div  class="itemFCol6">
  		  	<button class="agregarBoton" id="AgregaColegio" />+
  		  </div>  		   
  		</div>
	</div>
	<div class="itemAcceso3"  id="AdmNiveles">Administrar Niveles
  		<div class="FormNivel">
  		  <div class="itemFNi1">Niveles </div>
  		  <div class="itemFNi2">
  		  		<select id="niveles" class="colegioSel">
  		  			<option value="9999">Seleccione nivel</option>
  		  		</select>
  		  </div>  		  
  		  <div  class="itemFNi3">
  		  	<button class="agregarBoton" id="EliminarNivel" />-
  		  </div>  		     		  
  		  <div class="itemFNi4">Nombre</div>
  		  <div class="itemFNi5"><input type="text" class="FormNombres" id="nivelNombre" /></div>
  		  <div  class="itemFNi6">
  		  	<button class="agregarBoton" id="AgregaNivel" />+
  		  </div>  		   
  		</div>
	
	</div>  	
	
	<div class="itemAcceso4"  id="AdmCurso">Administrar Cursos
  		<div class="FormCursos">
  		  <div class="itemFCur1">Cursos </div>
  		  <div class="itemFCur2">
  		  		<select id="cursos" class="cursoSel">
  		  				<option value="9999">Seleccione curso</option>
  		  		</select>
  		  </div>  		  
  		  <div  class="itemFCur3">
  		  	<button class="agregarBoton" id="EliminarCurso" />-
  		  </div>  		   
  		  <div class="itemFCur4">
					Colegio
  		  </div>  		  
  		  <div class="itemFCur5">
  		  		<select id="icolegiocurso" class="colegioSel">
  		  				<option value="9999">Seleccione colegio</option>
  		  		</select>
  		  </div>  		  
  		  <div  class="itemFCur6">
				Nivel
		  </div>	
  		  
  		  <div  class="itemFCur7">
  		    	<select id="inivelCur" class="colegioSel">
  		  			<option value="9999">Seleccione nivel</option>
  		  		</select>
		  </div>	
  		  <div class="itemFCur8">Nombre</div>
  		  <div class="itemFCur9"><input type="text" class="FormNombres" id="cursoNombre" /></div>
  		  <div  class="itemFCur10">
  		  	<button class="agregarBoton" id="AgregaCurso" />+
  		  </div>  		   
  		</div>	
	
	</div>
	<div class="itemAcceso5"  id="AdmMaterias">Administrar Materias
  		<div class="FormMaterias">
  		  <div class="itemFMat1">Materias </div>
  		  <div class="itemFMat2">
  		  		<select id="materias" class="cursoSel">
  		  			<option value="9999">Seleccione materia</option>
  		  		</select>
  		  </div>  		  
  		  <div  class="itemFMat3">	
  		  	<button class="agregarBoton" id="EliminarMateria" />-
  		  </div>  		   
  		  <div class="itemFMat4">
				Colegio
  		  </div>  		  
  		  <div class="itemFMat5">
  		  		<select id="icolegiocursom" class="colegioSel">
  		  			<option value="9999">Seleccione colegio</option>
  		  		</select>
  		  </div>  		  
  		  <div class="itemFMat6">
				Curso
  		  </div>  		  
  		  <div class="itemFMat7">
  		  		<select id="icursomateria" class="colegioSel">
  		  			<option value="9999">Seleccione curso</option>
  		  		</select>
  		  </div>  		  
  		  <div class="itemFMat8">Nombre</div>
  		  <div class="itemFMat9"><input type="text" class="FormNombres" id="materiaNombre" /></div>

  		  <div  class="itemFMat10">
  		  	<button class="agregarBoton" id="AgregaMateria" />+
  		  </div>  		   
  		</div>	
	
	
	</div>
	<div class="itemAcceso6"  id="AdmCarpetas">Administrar Carpetas
  		<div class="FormCarpeta">
  		  <div class="itemFCar1">Carpetas FS </div>
  		  <div class="itemFCar2">
  		  		<select id="carpetasfs" class="colegioSel">
  		  			<option value="9999">Seleccione carpeta...</option>
  		  		</select>
  		  </div>  		  
  		  <div  class="itemFCar3">
  		  	<button class="agregarBoton" id="EliminarCarpeta" />-
  		  </div>  		   
  		  <div class="itemFCar4">Nombre</div>
  		  <div class="itemFCar5"><input type="text" class="FormNombres" id="carpetaNombre" /></div>
  		  <div  class="itemFCar6">
  		  	<button class="agregarBoton" id="AgregaCarpeta" />+
  		  </div>  		   

  		</div>
		
	</div>
  </div> <!-- lisgta accesos -->
  <!-- grilla de novedades, ultimos cargados -->
	<div class="grillaNovedades" id="grillaNovedades">
	<div class="novedad1">
			<div class="n1_item1">FECHA SUBIDA</div>
			<div class="n1_item2">USUARIO</div>
			<div class="n1_item3">MATERIA</div>
			<div class="n1_item4">CANTIDAD DE HOJAS SUBIDAS</div>
			<div class="n1_item5"></div>
			<div class="n1_item6"></div>
		</div>
	
	</div>
  <!-- grilla de novedades, ultimos cargados -->
  <!-- grilla de novedades, ultimos cargados -->
	<div class="grillaTemas" id="grillaTemas">
	<div class="temas1">
			<div class="t1_item0">
           		<div class="grillaFiltroTemas">
           			<div class="itemfiltemas1">Buscar tema</div>
           			<div class="itemfiltemas2">
           				<input class="filtroTemas" id="filtroTemas" value="" placeholder="texto del tema a buscar.."/>
           			</div>
           		</div>
			</div>
			<div class="t1_item1">Fecha</div>
			<div class="t1_item2">Dueño</div>
			<div class="t1_item3">Materia</div>
			<div class="t1_item4">Tema</div>
			<div class="t1_item5">Cant Hjs</div>
			<div class="t1_item6"></div>
		</div>
		<div class="grillaTemasCont" id="grillaTemasCont">
		<div class="temas1A">
			<div class="t1_item1">01/11/2022</div>
			<div class="t1_item2">Demetria</div>
			<div class="t1_item3">PDL</div>
			<div class="t1_item4">Cuentos de miedo</div>
			<div class="t1_item5">3</div>
			<div class="t1_item6"></div>
		</div>
		</div>
	
	</div>
  <!-- grilla de novedades, ultimos cargados -->  
</BODY>
</HTML>
