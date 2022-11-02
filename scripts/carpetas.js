
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function crearestructuradirectorios(idpersona)
{
	var parametros={"llamador":'index',"funcion":'CrearDirectorioPersona',"persona":idpersona,"ianio":$("#ianio").val()}
 	$.ajax({ 
    url:   './apis/curFunciones.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){
			//idpersona, usuariopersona, nombrepersona, tipopersona         	  
		var r = JSON.parse(re);
		alert(r);
		pedirCarpetas('#carpetasfs');
       if(r['estado'] == 1) {pedirCarpetas('#carpetasfs');}
		else {			
				$(".errores").append(r['Carpetas']);
			};
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
				$(".errores").append(xhr);
		}
    });   	
}
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++


function parametroURL(_par) {
  var _p = null;
  if (location.search) location.search.substr(1).split("&").forEach(function(pllv) {
    var s = pllv.split("="), //separamos llave/valor
      ll = s[0],
      v = s[1] && decodeURIComponent(s[1]); //valor hacemos encode para prevenir url encode
    if (ll == _par) { //solo nos interesa si es el nombre del parametro a buscar
      if(_p==null){
      _p=v; //si es nula, quiere decir que no tiene valor, solo textual
      }else if(Array.isArray(_p)){
      _p.push(v); //si ya es arreglo, agregamos este valor
      }else{
      _p=[_p,v]; //si no es arreglo, lo convertimos y agregamos este valor
      }
    }
  });
  return _p;
}
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// ****************************************************************
function pedirCarpetas(destinoId)
{	 
	var parametros={"llamador":'index',"funcion":'CarDirectorios'}
 	$.ajax({ 
    url:   './apis/curFunciones.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).empty();},
    done: function(data){},
    success:  function (re){
			//idpersona, usuariopersona, nombrepersona, tipopersona         	  
		var r = JSON.parse(re);
		//alert(r['estado']);
       if(r['estado'] == 1) {
        $(r['Carpetas']).each(function(i, v)
		        { // indice, valor
		        	//alert(i);
		        	//alert(v);
		                		//TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
		                		// TRIPLICANDO UN EVENTO QUE NO PUDE ENCONTRAR Y CARGABA TODOS LOS DATOS TRES VECESSS
		        	if (! $(destinoId).find("option[value='" + v.path + "']").length)
		        	{						
						  $(destinoId).append('<option value="' + v.path + '">' +v.directorio+ '</option>');
					}		
		        });
		}
		else {			
				$(".errores").append(r['Carpetas']);
			};
       $(destinoId).prop('disabled', false);
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
				$(".errores").append(xhr);
		}
    });
}
// ****************************************************************

// ****************************************************************
function pedirDocente(destinoId,persona,tipo){	 
	var parametros={"filtroPersona":persona,"llama":"pedirDocente"};
 	$.ajax({ 
    url:   './apis/obtener_personas.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).empty();},
    done: function(data){},
    success:  function (re){
			//idpersona, usuariopersona, nombrepersona, tipopersona         	  
	   if(re.indexOf("<br />") > -1)
					$(".errores").append(re);
		else
		{
		var r = JSON.parse(re);
		//alert(r['estado']);
        if(r['estado'] == 1) {
         $(r['Personas']).each(function(i, v)
		        { // indice, valor
		                		//TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
		                		// TRIPLICANDO UN EVENTO QUE NO PUDE ENCONTRAR Y CARGABA TODOS LOS DATOS TRES VECESSS
						$(destinoId).html('');			
						$(destinoId).html(v.nombrepersona+' - ' + v.tipopersona);
						//alert(v.tipopersona);
						if(v.tipopersona != 'ADMIN')
						{
							console.log(v.tipopersona);
							$("#volver").hide();
						}

		        });
		}
		else {			
				$(".errores").append(re);
			};
		}	
       //$(destinoId).hide();//		.prop('disabled', false);

    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
				$(".errores").append(xhr);
		}
    });
}

// ****************************************************************

	
// ****************************************************************
function pedirPersonaTipoEspecialista(destinoId,tipo,docente){	 
	var parametros={"filtroPersona":docente,"llama":"COMBOESPECIALISTA"};
 	$.ajax({ 
    url:   './apis/obtener_personas.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).empty();},
    done: function(data){},
    success:  function (re){
			//idpersona, usuariopersona, nombrepersona, tipopersona         	  
	   if(re.indexOf("<br />") > -1)
					$(".errores").append(re);
		else
		{
		var r = JSON.parse(re);
		//alert(r['estado']);
        if(r['estado'] == 1) {
         $(r['Personas']).each(function(i, v)
		        { // indice, valor
		                		//TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
		                		// TRIPLICANDO UN EVENTO QUE NO PUDE ENCONTRAR Y CARGABA TODOS LOS DATOS TRES VECESSS
		        	if (! $(destinoId).find("option[value='" + v.idpersona + "']").length  && v.tipopersona == tipo)
		        	{						
						  $(destinoId).append('<option value="' + v.idpersona + '" title="'+v.nombrepersona+ ' ">' +v.nombrepersona+' - ' + v.tipopersona +' - ' + v.ColegioNombre + '</option>');
			  
					}		
		        });
		}
		else {			
				$(".errores").append(re);
			};
		}	
       //$(destinoId).hide();//		.prop('disabled', false);

    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
				$(".errores").append(xhr);
		}
    });
}

// ****************************************************************


// ****************************************************************
function pedirPersonaTipo(destinoId,persona,tipo){	 
	var parametros={"filtroPersona":persona,"llama":"pedirPersonaTipo"};
 	$.ajax({ 
    url:   './apis/obtener_personas.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).empty();},
    done: function(data){},
    success:  function (re){
			//idpersona, usuariopersona, nombrepersona, tipopersona         	  
	   if(re.indexOf("<br />") > -1)
					$(".errores").append(re);
		else
		{
		var r = JSON.parse(re);
		//alert(r['estado']);
        if(r['estado'] == 1) {
         $(r['Personas']).each(function(i, v)
		        { // indice, valor
		                		//TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
		                		// TRIPLICANDO UN EVENTO QUE NO PUDE ENCONTRAR Y CARGABA TODOS LOS DATOS TRES VECESSS
		        	if (! $(destinoId).find("option[value='" + v.idpersona + "']").length  && v.tipopersona == tipo)
		        	{						
						  $(destinoId).append('<option value="' + v.idpersona + '" title="'+v.nombrepersona+ ' ">' +v.nombrepersona+' - ' + v.tipopersona +' - ' + v.ColegioNombre + '</option>');
			  
					}		
		        });
		}
		else {			
				$(".errores").append(re);
			};
		}	
       //$(destinoId).hide();//		.prop('disabled', false);

    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
				$(".errores").append(xhr);
		}
    });
}

// ****************************************************************


// ****************************************************************
function pedirPersona(destinoId,persona){	 
	var parametros={"filtroPersona":persona,"llama":"pedirPersona"};
 	$.ajax({ 
    url:   './apis/obtener_personas.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).empty();},
    done: function(data){},
    success:  function (re){
			//idpersona, usuariopersona, nombrepersona, tipopersona         	  
	   if(re.indexOf("<br />") > -1)
					$(".errores").append(re);
		else
		{
		var r = JSON.parse(re);
		//alert(r['estado']);
        if(r['estado'] == 1) {
         $(r['Personas']).each(function(i, v)
		        { // indice, valor
		                		//TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
		                		// TRIPLICANDO UN EVENTO QUE NO PUDE ENCONTRAR Y CARGABA TODOS LOS DATOS TRES VECESSS
		        	if (! $(destinoId).find("option[value='" + v.idpersona + "']").length)
		        	{						
						  $(destinoId).append('<option value="' + v.idpersona + '">' +v.nombrepersona+' - ' + v.tipopersona +' - ' + v.ColegioNombre + '</option>');
					}		
		        });
		}
		else {			
				$(".errores").append(re);
			};
		}	
       $(destinoId).prop('disabled', false);
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
				$(".errores").append(xhr);
		}
    });
}

// ****************************************************************

// ****************************************************************
function agregapersona(){	 

	var parametros = {"usuariopersona":$("#personaNombre").val(),"tipopersona":$("#tipoPersona").val()};	
 	
 	$.ajax({ 
    url:   './apis/insertar_persona.php',
    type:  'POST',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){
		//idpersona, usuariopersona, nombrepersona, tipopersona         	  
			//pedirPersona('#personas');	 
			pedirPersonaTipo('#personas',999,'ALUMNO');	
		  	pedirPersonaTipo('#profesionales',999,'ESPECIALISTA');	
			
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });
}
// ****************************************************************

// ****************************************************************
function EliminarPersona(){
	
	var parametros = {"idpersona":$('#personas').val()}
 	$.ajax({ 
    url:   './apis/eliminar_persona.php',
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
			$(".errores").append(xhr);
		}
    });
	
}
// ****************************************************************


function pedirRelaciones(destinoId,persona){	 
	var parametros={"filtroPersona":persona,"llama":"pedirPersona"};
 	$.ajax({ 
    url:   './apis/obtener_relacionAlumnoEspec.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).empty();},
    done: function(data){},
    success:  function (re){
			//idpersona, usuariopersona, nombrepersona, tipopersona         	  
	   if(re.indexOf("<br />") > -1)
					$(".errores").append(re);
		else
		{
		var r = JSON.parse(re);
		//alert(r['estado']);
        if(r['estado'] == 1) {
         $(r['Especialistas']).each(function(i, v)
		        { // indice, valor
		                		//TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
		                		// TRIPLICANDO UN EVENTO QUE NO PUDE ENCONTRAR Y CARGABA TODOS LOS DATOS TRES VECESSS
		                		//PersEspec.nombrepersona as 'Especialista'
		        	if (! $(destinoId).find("option[value='" + v.idespecialista + "']").length)
		        	{						
						  $(destinoId).append('<option value="' + v.idespecialista + '">' +v.Especialista+ '</option>');
					}		
		        });
		}
		else {			
				$(".errores").append(re);
			};
		}	
       $(destinoId).prop('disabled', false);
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
				$(".errores").append(xhr);
		}
    });
}

// ****************************************************************

// ****************************************************************
function AgregarRelacion(alumno,especialista){	 

	var parametros = {"especialista":$(especialista).val(),"alumno":$(alumno).val()};	
 	
 	$.ajax({ 
    url:   './apis/insertar_alumnoEspec.php',
    type:  'POST',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){
		//idpersona, usuariopersona, nombrepersona, tipopersona         	  
			//pedirPersona('#personas');	 
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });
}
// ****************************************************************


// ****************************************************************
function EliminarRelacion(alumno,especialista){	 

	var parametros = {"especialista":$(especialista).val(),"alumno":$(alumno).val()};	
 	
 	
 	$.ajax({ 
    url:   './apis/eliminar_alumnoEspec.php',
    type:  'POST',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){
		//idpersona, usuariopersona, nombrepersona, tipopersona         	  
			//pedirPersona('#personas');	 
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });
	
}
// ****************************************************************


// ****************************************************************
function pedirColegio(destinoId){
//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++				
	 var parametros = {"colegioid" : 0};	
 	$.ajax({ 
    url:   './apis/obtener_colegios.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).empty();},
    done: function(data){},
    success:  function (re){
		var r = JSON.parse(re);
		//alert(r['estado']);
       if(r['estado'] == 1) {
        $(r['Colegios']).each(function(i, v)
		        { // indice, valor
		                		//TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
							//idcolegio, nombreColegio
		        	if (! $(destinoId).find("option[value='" + v.idcolegio + "']").length)
		        	{						
						  $(destinoId).append('<option value="' + v.idcolegio + '">' +v.nombreColegio+ '</option>');
					}		
		        });
		}
		else {			
		    $(destinoId).empty();
			$(destinoId).append('<option value="' + '9999' + '">' + r['Colegios'] + '</option>');
			$(destinoId).val('9999');
			$(destinoId).prop('disabled', false);

			};
			
       $(destinoId).prop('disabled', false);
    },
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(destinoId).empty();
			$(destinoId).append('<option value="' + '9999' + '">' + 'JQERY:Error en consulta (ver console.Log)' + '</option>');
			$(destinoId).val('9999');
			$(destinoId).prop('disabled', false);     	
     }
    });
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++	
}
// **************************************************************************************************

// ****************************************************************
function agregacolegio(){	 

	var parametros = {"colegionombre":$("#colegioNombre").val()};	
 	
 	$.ajax({ 
    url:   './apis/insertar_colegio.php',
    type:  'POST',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){
		//idpersona, usuariopersona, nombrepersona, tipopersona         	  
			pedirColegio('#colegios');
				pedirColegio('#icolegiocurso');	 
					pedirColegio('#icolegiocursom');	 			
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });
}

// ****************************************************************

// ****************************************************************
function EliminarColegio(){
	
	var parametros = {"idcolegio":$('#colegios').val()}
 	$.ajax({ 
    url:   './apis/eliminar_colegio.php',
    type:  'POST',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){
		//idpersona, usuariopersona, nombrepersona, tipopersona         	  
				pedirColegio('#colegios');
				pedirColegio('#icolegiocurso');	 
					pedirColegio('#icolegiocursom');	 			
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });
	
}
// ****************************************************************


// ****************************************************************
function pedirNiveles(destinoId){
//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++				
	var parametros = {"nivelesid" : 0};	
 	$.ajax({ 
    url:   './apis/obtener_niveles.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).empty();},
    done: function(data){},
    success:  function (re){
		var r = JSON.parse(re);
		//alert(r['estado']);
       if(r['estado'] == 1) {
        $(r['Niveles']).each(function(i, v)
		        { // indice, valor
		                		//TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
							//SELECT idNivel, DescripcionNivel 
		        	if (! $(destinoId).find("option[value='" + v.idNivel + "']").length)
		        	{						
						  $(destinoId).append('<option value="' + v.idNivel + '">' +v.DescripcionNivel+ '</option>');
					}		
		        });
		}
		else {		
			$(destinoId).empty();		
			$(destinoId).append('<option value="' + '9999' + '">' + r['Niveles'] + '</option>');
			$(destinoId).val('9999');
			$(destinoId).prop('disabled', false);

			};
			
       $(destinoId).prop('disabled', false);
    },
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(destinoId).empty();
			$(destinoId).append('<option value="' + '9999' + '">' + 'JQERY:Error en consulta (ver console.Log)' + '</option>');
			$(destinoId).val('9999');
			$(destinoId).prop('disabled', false);     	
	  }
    });
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++	
}
// **************************************************************************************************



// ****************************************************************
function agreganivel(){	 

	var parametros = {"nivelnombre":$("#nivelNombre").val()};	
 	
 	$.ajax({ 
    url:   './apis/insertar_nivel.php',
    type:  'POST',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){
		//idpersona, usuariopersona, nombrepersona, tipopersona         	  
			if(re.indexOf("Stack") > -1)
					$(".errores").append(re);
			else  {
					pedirNiveles('#niveles');	
					pedirNiveles('#inivelCur'); 
				}	
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });
}

// ****************************************************************

// ****************************************************************
function EliminarNivel(){
	
	var parametros = {"idnivel":$('#niveles').val()}
 	$.ajax({ 
    url:   './apis/eliminar_nivel.php',
    type:  'POST',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){
		//idpersona, usuariopersona, nombrepersona, tipopersona         	  
			pedirNiveles('#niveles');	
			pedirNiveles('#inivelCur'); 

    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });
	
}
// ****************************************************************

// **************************************************************************************************
function pedirCursosPersona(destinoId,persona)
{
//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++				
	var parametros = {"personaid" : persona};	
 	$.ajax({ 
    url:   './apis/obtener_cursos.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).empty();},
    done: function(data){},
    success:  function (re){
		var r = JSON.parse(re);
		//alert(r['estado']);
       if(r['estado'] == 1) {
        $(r['Cursos']).each(function(i, v)
		        { // indice, valor
					var informeMaterias = "";
					if(v.MateriasEnCurso > 0)
						informeMaterias=' con '+v.MateriasEnCurso+ ' mats.';
					else
						informeMaterias=' sin materias ';
						
		                		//TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
						//anioCurso, idColegio, idCurso, idnivel, nombreCurso 
						//anioCurso, curcursos.idColegio, idCurso, idnivel, nombreCurso +' de: ' + nombreColegio as 'nombreCompletoCurso'						
		        	if (! $(destinoId).find("option[value='" + v.idCurso + "']").length)
		        	{						
						  $(destinoId).append('<option value="' + v.idCurso + '">' +v.anioCurso +'_'+v.nombreCompletoCurso+informeMaterias+ '</option>');
					}		
		        });
		}
		else {			
		    $(destinoId).empty();
			$(destinoId).append('<option value="' + '9999' + '">' + r['Cursos'] + '</option>');
			$(destinoId).val('9999');
			//$(destinoId).prop('disabled', false);

			};
			
      // $(destinoId).prop('disabled', false);
    },
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(destinoId).empty();
			$(destinoId).append('<option value="' + '9999' + '">' + 'JQERY:Error en consulta (ver console.Log)' + '</option>');
			$(destinoId).val('9999');
			$(destinoId).prop('disabled', false);   
	}
    });
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++		
}
// ***********************************************************************************************/

// ***************************************************************************************
function pedirPesoCarpeta(destinoId,persona,ianio)
{
//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++			
	var parametros = {"personaid" : persona,"ianio":ianio};	
 	$.ajax({ 
    url:   './apis/obtener_materias_peso_persona.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
    async: false, //=>>>>>>>>>>> here >>>>>>>>>>>ESTO EVITA QUE SE REPITA !!!!
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).empty();},
    done: function(data){},
    success:  function (re){
		var r = JSON.parse(re);
		//$datos["Cursos"] = $Cursos //PesoCurso y curso(nombre)
       var DataCurso=''; 
       if(r['estado'] == 1) {
        $(r['Cursos']).each(function(i, v){
        	//if (! $(destinoId).find("[name='" + v.curso + "']").length)
 					DataCurso += '<span>'+v.curso+' , '+v.PesoCurso+'</span>';			
		});
	  };
	  $(destinoId).append(DataCurso);
	  $(destinoId).prop('disabled', true);   

    },
     error: function (xhr, ajaxOptions, thrownError){}
    });
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET++++++++++++++++++++++++++++++++++++++++++++++++++		
}
// ***********************************************************************************************/

// **************************************************************************************************

 
// **************************************************************************************************
function pedirCursos(destinoId){
//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++				
	var parametros = {"cursoid" : 0};	
 	$.ajax({ 
    url:   './apis/obtener_cursos.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).empty();},
    done: function(data){},
    success:  function (re){
		var r = JSON.parse(re);
		//alert(r['estado']);
       if(r['estado'] == 1) {
        $(r['Cursos']).each(function(i, v)
		        { // indice, valor
					var informeMaterias = "";
					if(v.MateriasEnCurso > 0)
						informeMaterias=' con '+v.MateriasEnCurso+ ' mats.';
					else
						informeMaterias=' sin materias ';
						
		                		//TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
						//anioCurso, idColegio, idCurso, idnivel, nombreCurso 
						//anioCurso, curcursos.idColegio, idCurso, idnivel, nombreCurso +' de: ' + nombreColegio as 'nombreCompletoCurso'						
		        	if (! $(destinoId).find("option[value='" + v.idCurso + "']").length)
		        	{						
						  $(destinoId).append('<option value="' + v.idCurso + '">' +v.anioCurso +'_'+v.nombreCompletoCurso+informeMaterias+ '</option>');
					}		
		        });
		}
		else {			
		    $(destinoId).empty();
			$(destinoId).append('<option value="' + '9999' + '">' + r['Cursos'] + '</option>');
			$(destinoId).val('9999');
			//$(destinoId).prop('disabled', false);

			};
			
      // $(destinoId).prop('disabled', false);
    },
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(destinoId).empty();
			$(destinoId).append('<option value="' + '9999' + '">' + 'JQERY:Error en consulta (ver console.Log)' + '</option>');
			$(destinoId).val('9999');
			$(destinoId).prop('disabled', false);   
	}
    });
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++		
}
// **************************************************************************************************

// ****************************************************************
function agregacurso(){	 

	var parametros = {"cursonombre":$("#cursoNombre").val(),"cursonivel":$("#inivelCur").val(),"cursocolegio":$("#icolegiocurso").val(),"ianio":$("#ianio").val()};	
 	
 	$.ajax({ 
    url:   './apis/insertar_curso.php',
    type:  'POST',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){
		//idpersona, usuariopersona, nombrepersona, tipopersona         	  
			if(re.indexOf("Stack") > -1)
					$(".errores").append(re);
			else  {pedirCursos('#cursos');	 
		 			pedirCursos('#icursomateria');}
    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });
}

// ****************************************************************

// ****************************************************************
function EliminarCurso(){
	
	var parametros = {"idcurso":$('#cursos').val(),"ianio":$("#ianio").val(),"idColegio":$("#icolegiocurso").val()}
 	$.ajax({ 
    url:   './apis/eliminar_curso.php',
    type:  'POST',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){
		//idpersona, usuariopersona, nombrepersona, tipopersona         	  
				pedirCursos('#cursos');	 
		 			pedirCursos('#icursomateria');

    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });
	
}
// ****************************************************************

// **************************************************************************************************
function grabarsesion(claveSesion,valorSesion){
	
//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++				
	var parametros = {"llamador" :"grabarSesion","funcion":"grabarsesion","clave" : claveSesion,"valorSesion":valorSesion};	
 
 	$.ajax({ 
    url:   './apis/curFunciones.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){},
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);   
	}
    });
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++		
}
// **************************************************************************************************

// **************************************************************************************************
function leersesion(claveSesion){
	
//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++				
 	var respuesta = 0;
	var parametros = {"llamador" :"leerSesion","funcion":"leersesion","clave" : claveSesion};	
 	$.ajax({ 
    url:   './apis/curFunciones.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
    async: false,
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    success:  function (re){
    	//$(".errores").append(re);
    	respuesta = re;	
    },
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);   
	}
    });
    
  return respuesta.trim(); 
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++		
}
// **************************************************************************************************
function devuelveSesionValores(datos){
	return datos;
}

// **************************************************************************************************
function procesamateria(ianio,cursoid,materiaid,colegioid,controlRegistro,destinoId,personaId){
  var accion="";
  if( $(controlRegistro).is(':checked') )
	   accion ="AGREGA";
  else
  		accion="ELIMINA";
  
  var parametros = {
						"accion" : accion,
						"ianio":ianio,
						"cursoid" :cursoid,
						"materiaid":materiaid,
						"colegioid" :colegioid,
						"personaid" : personaId
						};	
 	$.ajax({ 
    url:   './apis/procesar_materias.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).empty();},
    done: function(data){},
    success:  function (re){
			pedirMaterias2(destinoId,personaId,ianio,cursoid);
    },
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);   
	 }
    });  	
  	
}
// **************************************************************************************************

// **************************************************************************************************
function pedirMaterias2(destinoId,personaid,ianio,cursoid){
//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++				
	//alert(cursoid);
	var xcursoid =0;
	if(cursoid == null || cursoid == 0)
		xcursoid = $("#cursos").val();
	else
		xcursoid = cursoid;
		
	var parametros = {"personaid" : personaid,"ianio":ianio,"cursoid":xcursoid };	
 	$.ajax({ 
    url:   './apis/obtener_materias_personaX.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).html('');},
    done: function(data){},
    success:  function (re){
	
		if(re.indexOf("Stack") > -1 || re.indexOf("SQLSTATE") > -1 || re.indexOf("<br />") > -1)
					$(".errores").append(re);
		else
		{
		var r = JSON.parse(re);
		//alert(r['estado']);
       if(r['estado'] == 1 && ! (re.indexOf("Stack") > -1 || re.indexOf("SQLSTATE") > -1 || re.indexOf("<br />") > -1)) {
        $(r['Materias']).each(function(i, v)
		        { // indice, valor
	 			var chequeado = " checked onclick='procesamateria("+v.aniocurso+","+v.idcurso+","+v.idmateria+","+v.idcolegio+",this,\""+destinoId+"\","+personaid+");' ";
//				curmateria.anioCurso, 
//				curmateria.idColegio, 
//				curmateria.idcurso, 
//					idmateria, nombreMateria ,
//					curcursos.nombreCurso,
//					curcolegio.nombreColegio
				if(v.usuariopersona == "")
					chequeado = "  onclick='procesamateria("+v.aniocurso+","+v.idcurso+","+v.idmateria+","+v.idcolegio+",this,\""+destinoId+"\","+personaid+");' ";

				$("#cursosver").val(v.idcurso);
 				//	 if(v['estado'] == "0"){chequeado ='';} 
			var tabla= "<div id='MateriasAsignadas' class='MateriasAsignadas'>"+
				"<div class='itemmaasgn1'>"+
					"<input id='midanio' type='hidden' value='"+v.aniocurso+"'/>"+
					"<input id='midcurso' type='hidden' value='"+v.idcurso+"'/>"+
					"<input id='midmateria' type='hidden' value='"+v.idmateria+"'/>"+
					"<input id='midcolegio' type='hidden' value='"+v.idcolegio+"'/>"+
				"</div>"+
				"<div class='itemmaasgn2'><input type='checkbox' value='' "+chequeado+" /></div>"+
				"<div class='itemmaasgn3'>"+v.nombrecolegio+"</div>"+
				"<div class='itemmaasgn4'>"+v.aniocurso+"</div>"+
				"<div class='itemmaasgn5'>"+v.nombrecurso+"</div>"+
				"<div class='itemmaasgn6'>"+v.nombremateria+"</div>"+
				"<div class='itemmaasgn7'></div>"+
			"</div>";
					$(destinoId).append(tabla);	
		        });
		}
		else {			
					$(".errores").append(re);

			};
		}			
	
       $(destinoId).prop('disabled', false);
    },
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);   
	}
    });
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++		
}
// **************************************************************************************************

// **************************************************************************************************
function pedirMaterias3(destinoId,personaid,aniobuscado,llamadorParms,materiaParm,docente,cursoAlumno){
//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++				

	var parametros = {"personaid" : personaid,"ianio":aniobuscado};	
 	$.ajax({ 
    url:   './apis/obtener_materias_persona.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).empty();},
    done: function(data){},
    success:  function (re){

	
		if(re.indexOf("Stack") > -1 || re.indexOf("SQLSTATE") > -1 || re.indexOf("<br />") > -1)
					$(".errores").append(re);
		else
		{
		var r = JSON.parse(re);
		//alert(r['estado']);
       if(r['estado'] == 1 && ! (re.indexOf("Stack") > -1 || re.indexOf("SQLSTATE") > -1 || re.indexOf("<br />") > -1)) {
       	
       	if(materiaParm == null) MATERIANOMBRE="";
       		else MATERIANOMBRE="-"+materiaParm;	
			$("#alumnos").val(personaid);
		     var titulo = "Carpetas de<br>"+$("#alumnos option:selected").attr('title') + "<br>"+MATERIANOMBRE;
		        	$(".titulo").html(titulo);	
		     var cursoTexto="";  	
        $(r['Materias']).each(function(i, v)
		        { // indice, valor
	 			var chequeado = 'checked';
//				curmateria.anioCurso, 
//				curmateria.idColegio, 
//				curmateria.idcurso, 
//					idmateria, nombreMateria ,
//					curcursos.nombreCurso,
//					curcolegio.nombreColegio
				$("#cursosver").val(v.idcurso);
				$(cursoAlumno).html(v.anioCurso +'-'+v.nombreColegio +'-' +v.nombreCurso);
 				//	 if(v['estado'] == "0"){chequeado ='';} 
			var tabla= "<div id='MateriasVer' class='MateriasVer'>"+
				"<div class='itemmaver1'>"+
					"<a href='verMateriasAlumno.php?idpersona="+personaid+"&llama="+llamadorParms+"&materia="+v.nombreMateria+"&docente="+docente+"&ianio="+aniobuscado+"' >"+
					"<input id='midanio' type='hidden' value='"+v.anioCurso+"'/>"+
					"<input id='midcurso' type='hidden' value='"+v.idcurso+"'/>"+
					"<input id='midmateria' type='hidden' value='"+v.idmateria+"'/>"+
					"<input id='midcolegio' type='hidden' value='"+v.idColegio+"'/>"
					+v.nombreMateria+v.conteoMateria+"</a></div>"+
					"</div>";
					$(destinoId).append(tabla);	
		        });
		}
		else {			
					$(".errores").append(re);

			};
		}			
	
       $(destinoId).prop('disabled', false);
    },
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);   
	}
    });
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++	
}
// **************************************************************************************************

// **************************************************************************************************
function pedirMateriasFiles(destinoId,personaid,anioParms,llamadorParms,materiaParm,cursoAlumno){
//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++				
	//alert(destinoId+" , "+personaid+" , "+llamadorParms+" , "+materiaParm+" , "+cursoAlumno);
	
	var parametros = {"personaid" : personaid,"ianio":anioParms};	
 	$.ajax({ 
    url:   './apis/obtener_materias_persona.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).empty();},
    done: function(data){},
    success:  function (re){
	
		if(re.indexOf("Stack") > -1 || re.indexOf("SQLSTATE") > -1 || re.indexOf("<br />") > -1)
					$(".errores").append(re);
		else
		{
		var r = JSON.parse(re);
		//alert(r['estado']);
       if(r['estado'] == 1 && ! (re.indexOf("Stack") > -1 || re.indexOf("SQLSTATE") > -1 || re.indexOf("<br />") > -1)) {
       	
       	if(materiaParm == null) MATERIANOMBRE="";
       		else MATERIANOMBRE="-"+materiaParm;	
			$("#alumnos").val(personaid);
		     var titulo = "Carpetas de<br>"+$("#alumnos option:selected").attr('title') + "<br>"+MATERIANOMBRE;
		        	$(".titulo").html(titulo);	
		     var cursoTexto="";  	
        $(r['Materias']).each(function(i, v)
		        { // indice, valor
	 			var chequeado = 'checked';
//				curmateria.anioCurso, 
//				curmateria.idColegio, 
//				curmateria.idcurso, idmateria
//					idmateria, nombreMateria ,
//					curcursos.nombreCurso,
//					curcolegio.nombreColegio
				$("#cursosver").val(v.idcurso);	
				$("#nombreMateria").html(materiaParm);

				$(cursoAlumno).html(v.anioCurso +'-'+v.nombreColegio +'-' +v.nombreCurso);
 				//	 if(v['estado'] == "0"){chequeado ='';} 
			var tabla= "<div id='MateriasVer' class='MateriasVer'>"+
				"<div class='itemmaver1'>"+
					"<a href='cargaHojasMateriasAlumno.php?idpersona="+personaid+"&llama="+llamadorParms+"&materia="+v.nombreMateria+"&ianio="+anioParms+"' >"+
					"<input id='midanio_"+v.nombreMateria+"' type='hidden' value='"+v.anioCurso+"'/>"+
					"<input id='midcurso_"+v.nombreMateria+"' type='hidden' value='"+v.idcurso+"'/>"+
					"<input id='midmateria_"+v.nombreMateria+"' type='hidden' value='"+v.idmateria+"'/>"+
					"<input id='midcolegio_"+v.nombreMateria+"' type='hidden' value='"+v.idColegio+"'/>"
					+v.nombreMateria+v.conteoMateria+"</a></div>"+
			"</div>";
					$("#faniocurso").val(v.anioCurso);
					$("#fidcurso").val(v.idcurso);
					$("#fidalumno").val(personaid);
					
					if(materiaParm == null)
					   $("#formularioHojasCarpeta").hide();
					else   
						$("#formularioHojasCarpeta").show();
					//alert("igualdad con "+materiaParm+" y " + v.nombreMateria+"?");
					if((v.nombreMateria == materiaParm) &&(materiaParm != null))
						{
							$("#fidmateriaid").val(v.idmateria);	
							//alert("igualdad con "+materiaParm);							
						}
					
					$(destinoId).append(tabla);	
		        });
		}
		else {			
					$(".errores").append(re);

			};
		}			
	
       $(destinoId).prop('disabled', false);
    },
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);   
	}
    });
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++	
}
// ***************************************************************************************

// ***************************************************************************************
function pedirListaUpdatesxTema(destinoId,temaBuscardo)
{
	
	var parametros = {"temaBuscardo" : temaBuscardo,"opcion2":'S'};	
 	$.ajax({ 
    url:   './apis/obtener_lista_updates.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){
		$(destinoId).empty();
    },
    done: function(data){},
    success:  function (re){
	
		if(re.indexOf("Stack") > -1 || re.indexOf("SQLSTATE") > -1 || re.indexOf("<br />") > -1)
					$(".errores").append(re);
		else
		{
			var r = JSON.parse(re);
			//alert(r['estado']);
	       if(r['estado'] == 1 && ! (re.indexOf("Stack") > -1 || re.indexOf("SQLSTATE") > -1 || re.indexOf("<br />") > -1)) {
			var linea='';		
			$(r['EstadisticasCarpetas']).each(function(i, v){
						linea += '<div class="temas1A">'+
					             '<div class="t1_item1">'+v.fechaEnHoja+'</div>'+
					             '<div class="t1_item2">'+v.nombrepersona+'</div>'+
					             '<div class="t1_item3">'+v.materiaAbr+'</div>'+
					             '<div class="t1_item4">'+v.obsuno+'</div>'+
					             '<div class="t1_item5">'+v.Hojas+'</div>'+
					             '<div class="t1_item6"></div>'+
					             '</div>';});
			
			$(destinoId).html(linea);	
			}
			else {			
						$(".errores").append(re);
				};
		}			
    },
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);   
	}
    });	
	
	
	
}
// ***************************************************************************************

// ***************************************************************************************
function pedirGaleriaxTemas(destinoId,personaid,ianioParms,filtroParms,filtroTemas,materiaParm){

	var parametros = {"personaid" : personaid,"materiaNombre":materiaParm,"ianio":ianioParms,"filtroParms":filtroParms,"filtroTemas":filtroTemas};	
 	
 	$.ajax({ 
    url:   './apis/obtener_carpeta_materia_personav2.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).empty();},
    done: function(data){},
    success:  function (re){
	
		if(re.indexOf("Stack") > -1 || re.indexOf("SQLSTATE") > -1 || re.indexOf("<br />") > -1)
					$(".errores").append(re);
		else
		{
			var r = JSON.parse(re);
			//alert(r['estado']);
	       if(r['estado'] == 1 && ! (re.indexOf("Stack") > -1 || re.indexOf("SQLSTATE") > -1 || re.indexOf("<br />") > -1)) {

			     if(materiaParm == null) MATERIANOMBRE="";
			       	else MATERIANOMBRE="-"+materiaParm;	
		       	
			     var titulo = "Carpetas de<br>"+$("#alumnos option:selected").attr('title') + "<br>"+MATERIANOMBRE;
		        	$(".titulo").html(titulo);	
				
				 $(destinoId).append(r['Galeria']);	

			}
			else {			
						$(".errores").append(re);
				};
		}			
    },
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);   
	}
    });	




}
// ***************************************************************************************

// ***************************************************************************************
function pedirGaleria(destinoId,personaid,ianioParms,filtroParms,materiaParm){
//+++++++++++++++++++++++++++++++LLAMADA AL GET++++++++++++++++++++++++++++++++++++++++++++

	var parametros = {"personaid" : personaid,"materiaNombre":materiaParm,"ianio":ianioParms,"filtroParms":filtroParms};	
 	$.ajax({ 
    url:   './apis/obtener_carpeta_materia_personav2.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).empty();},
    done: function(data){},
    success:  function (re){
	
		if(re.indexOf("Stack") > -1 || re.indexOf("SQLSTATE") > -1 || re.indexOf("<br />") > -1)
					$(".errores").append(re);
		else
		{
			var r = JSON.parse(re);
			//alert(r['estado']);
	       if(r['estado'] == 1 && ! (re.indexOf("Stack") > -1 || re.indexOf("SQLSTATE") > -1 || re.indexOf("<br />") > -1)) {

			     if(materiaParm == null) MATERIANOMBRE="";
			       	else MATERIANOMBRE="-"+materiaParm;	
		       	
			     var titulo = "Carpetas de<br>"+$("#alumnos option:selected").attr('title') + "<br>"+MATERIANOMBRE;
		        	$(".titulo").html(titulo);	
				
				 $(destinoId).append(r['Galeria']);	

			}
			else {			
						$(".errores").append(re);
				};
		}			
    },
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);   
	}
    });
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++	
}
// **************************************************************************************************


// **************************************************************************************************
function pedirGaleriaX(destinoId,personaid,ianioParms,llamadorParms,materiaParm){
//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++
	var parametros = {"personaid" : personaid,"materiaNombre":materiaParm,"ianio":ianioParms,"llamador":"CARGAR"};	
 	$.ajax({ 
    url:   './apis/obtener_carpeta_materia_personav2.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).empty();},
    done: function(data){},
    success:  function (re){
	
		if(re.indexOf("Stack") > -1 || re.indexOf("SQLSTATE") > -1 || re.indexOf("<br />") > -1)
					$(".errores").append(re);
		else
		{
			var r = JSON.parse(re);
			//alert(r['estado']);
	       if(r['estado'] == 1 && ! (re.indexOf("Stack") > -1 || re.indexOf("SQLSTATE") > -1 || re.indexOf("<br />") > -1)) {

			     if(materiaParm == null) MATERIANOMBRE="";
			       	else MATERIANOMBRE="-"+materiaParm;	
		       	
			     var titulo = "Carpetas de<br>"+$("#alumnos option:selected").attr('title') + "<br>"+MATERIANOMBRE;
		        	$(".titulo").html(titulo);	
				
				 $(destinoId).append(r['Galeria']);	

			}
			else {			
						$(".errores").append(re);
				};
		}			
    },
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);   
	}
    });
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++	
}
//++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++	
function pedirListaUpdates(destinoId,personaid,anioAnalisis){
/*SELECT	curpersona.nombrepersona, fechaEnHoja, obsuno, count(obsuno) as 'Hojas' FROM curpermatcarpeta 
 left join curpersona ON
    curpersona.idpersona = curpermatcarpeta.idpersona 
WHERE aniocurso =2022
   and curpermatcarpeta.idpersona=2
  GROUP by obsuno
  order by fechaenhoja desc
  limit 10;
*/	
	var parametros = {"personaid" : personaid,"ianio":anioAnalisis};	
 	$.ajax({ 
    url:   './apis/obtener_lista_updates.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){
		$(destinoId).empty();
            $(destinoId).append('<div class="itemsUpdateCab">'+
            		        	'<div>Fecha</div>'+
            		        	'<div>Materia</div>'+
                    			'<div>Tema</div>'+
                    			'<div>Cant.Hojas</div>'+
                    			'</div>');
    
    },
    done: function(data){},
    success:  function (re){
	
		if(re.indexOf("Stack") > -1 || re.indexOf("SQLSTATE") > -1 || re.indexOf("<br />") > -1)
					$(".errores").append(re);
		else
		{
			var r = JSON.parse(re);
			//alert(r['estado']);
	       if(r['estado'] == 1 && ! (re.indexOf("Stack") > -1 || re.indexOf("SQLSTATE") > -1 || re.indexOf("<br />") > -1)) {
			var linea='';		
			$(r['EstadisticasCarpetas']).each(function(i, v){
						linea += '<div class="itemsUpdate">'+
					             '<div>'+v.fechaEnHoja+'</div>'+
					             '<div>'+v.materiaAbr+'</div>'+
					             '<div>'+v.obsuno+'</div>'+
					             '<div>'+v.Hojas+'</div>'+
					             '</div>';});
			
			$(destinoId).append(linea);	
			}
			else {			
						$(".errores").append(re);
				};
		}			
    },
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);   
	}
    });
}
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++	
// **************************************************************************************************
// **************************************************************************************************
function eliminarimagen(datosImagenEncriptados){
//(destinoId,personaid,ianioParms,llamadorParms,materiaParm)
//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++	
	var claveimagenDB = datosImagenEncriptados.id;
    separador = "_";
    claveDB = claveimagenDB.split(separador);
	var ianio = claveDB[1];
	var icurso = claveDB[2];
	var ipersona = claveDB[3];
	var imateria = claveDB[4];
	var ihojaNroId = claveDB[5];		

    var llamador = "CARGAR";
	var funcion="eliminarHoja"; // en cero no hace nada, en 1 achica la lista
	
  
	var parametros = {"ianio" : ianio,"icurso":icurso,"ipersona":ipersona,"imateria":imateria,"ihojaNroId":ihojaNroId,"funcion":funcion,"llamador":llamador};	
 	$.ajax({ 
    url:   './apis/curFunciones.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){
    		window.location.reload();
			//$(".errores").append(re);   
    },
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);   
	}
    });
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++	
}
// **************************************************************************************************




// **************************************************************************************************

 
function imgShow(outerdiv, innerdiv, bigimg, fuente)
{
	//alert('llego..');  
    var src = fuente.src; // Obtenga la propiedad SRC en el elemento PIMG que se hace clic actualmente  
     $(bigimg).attr("src", src); // Establezca el atributo SRC del elemento #Bigimg  

/* Obtenga el tamaño real del clic actual en la imagen y muestre la capa emergente y la imagen grande */  
$("<img/>").attr("src", src).load(function(){  
	 var windoww = $(window).width(); // Obtener el ancho de la ventana actual  
	 var windowh = $(window).height(); // Obtenga la altura de la ventana actual  
	 var realwidth = fuente.width ; // obtener imagen ancho real  
	 var realheight = fuente.height; // obtener imagen de altura real  
     var imgwidth, imgheight;  
	 var escala = 0.2; // tamaño de zoom, zoom cuando la imagen es ancho real y altura mayor que la anchura de la ventana y la altura  
//      	alert('altura real: ' +realheight + ' versus altura real : ' +fuente.height);	
    var escalaGrande = 5;
    //alert('ventaba escala alto: ' +(windowh * escala)+ ' versus altura real : ' +realheight);
    //alert('ventaba escala ancho: ' +(windoww * escala)+ ' versus ancho real : ' +realwidth);	
  
     if(realheight> windowh * escala)
      {// Altura de la imagen del juicio  
             imgheight = windowh * escala; // es más grande que la altura de la ventana, la imagen es altamente escalada  
             imgwidth = (imgheight / realheight) * realwidth; // Ancho de zoom isométrico  
             if(imgwidth> windoww * escala)
              {// Si el ancho se tira más grande que el ancho de la ventana  
                     imgwidth = window * escala; // devolviendo el ancho  
		  }  
     } 
     else if(realwidth> windoww * escala)
	      {// A medida que la imagen es apropiada, se determina el ancho de la imagen  
			//alert(';');
	        imgwidth = windoww * escalaGrande;// * escala; // es más grande que el ancho de la ventana, se escala el ancho de la imagen  
	     	imgheight = imgwidth / realwidth * realheight; // altura de zoom isométrico  
	     }
	      else{// Si la imagen es verdadera y anchura, cumple con los requisitos, y la constante alta y ancha  
	        imgwidth = realwidth * escalaGrande;  
	        imgheight = realheight * escalaGrande ;  
		}
//        alert('zoom final: '+imgwidth);
        $(bigimg).css("width", imgwidth); // zoom con el ancho final  
        $(bigimg).css("height", imgheight); // zoom con el ancho final  

        //alert("imgwidth "+ imgwidth+" , imgheight : "+imgheight);
        //alert("windoww "+ windoww+" , windowh: "+windowh);
        
        var w = (windoww-imgwidth); // Calcule la imagen y el lado izquierdo de la ventana  
        var h = (windowh-imgheight); // calcula imágenes y ventanas en el margen  
       
        //alert("top "+ h+" , left : "+w);
//        $(innerdiv).css({"top": h, "left": w}); // Configuración #Innerdiv Top e Atributos IZQUIERDOS  
        $(outerdiv).fadeIn("slow"); // Pantalla pasada #outerdiv y .pimg  
});  
  
         $ (outerdiv).click(function(){// Haga clic en el flash para desaparecer  
    			$(this).fadeOut("fast");  
			});  

} 
// **************************************************************************************************

function pedirNovedades(destinoId,fecha){
	
	var parametros = {"funcion" : "novedadesIndex","FechaCarga":fecha};	
 	$.ajax({ 
    url:   './apis/curFunciones.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).empty();},
    done: function(data){},
    success:  function (re){
		var r = JSON.parse(re);
		//alert(r['estado']);
		var ListaNovedades='<div class="novedad1">'+
								'<div class="n1_item1">FECHA SUBIDA</div>'+
								'<div class="n1_item2">USUARIO</div>'+
								'<div class="n1_item3">MATERIA</div>'+
								'<div class="n1_item4">CANTIDAD DE HOJAS SUBIDAS</div>'+
								'<div class="n1_item5"></div>'+
								'<div class="n1_item6"></div>'+
							'</div>';
       if(r['estado'] == 1 && ! (r['Novedades1'].indexOf("Stack") > -1 || r['Novedades1'].indexOf("SQLSTATE") > -1)) {
		var FechaCarga = '';

        $(r['Novedades1']).each(function(i, v)
		        { // indice, valor
		                		//TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
						//'CargadoEl','sube','Materia','CantidadHojas'
					if(FechaCarga != v.CargadoEl){
						ListaNovedades +='<div class="novedad1">'+
										'<div class="n1_item1">'+v.CargadoEl+'</div>'+
										'<div class="n1_item2"></div>'+
										'<div class="n1_item3"></div>'+
										'<div class="n1_item4"></div>'+
										'<div class="n1_item5"></div>'+
										'<div class="n1_item6"></div>'+
									'</div>';
								ListaNovedades +='<div class="novedad1">'+
									'<div class="n1_item1"></div>'+
									'<div class="n1_item2">'+v.sube+'</div>'+
									'<div class="n1_item3">'+v.Materia+'</div>'+
									'<div class="n1_item4">'+v.CantidadHojas+'</div>'+
									'<div class="n1_item5"></div>'+
									'<div class="n1_item6"></div>'+
								'</div>';
									
						FechaCarga = v.CargadoEl;				
					}
					else
		        		{ // indice, valor
								ListaNovedades +='<div class="novedad1">'+
									'<div class="n1_item1"></div>'+
									'<div class="n1_item2">'+v.sube+'</div>'+
									'<div class="n1_item3">'+v.Materia+'</div>'+
									'<div class="n1_item4">'+v.CantidadHojas+'</div>'+
									'<div class="n1_item5"></div>'+
									'<div class="n1_item6"></div>'+
								'</div>';
						};

		        });
		      $(destinoId).append(ListaNovedades);  
		}
		else {			
		    $(destinoId).empty();
		    $(".errores").append(r['Novedades1']);

			};
    },
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(destinoId).empty();
			$(destinoId).append('<option value="' + '9999' + '">' + 'JQERY:Error en consulta (ver console.Log)' + '</option>');
			$(destinoId).val('9999');
			$(destinoId).prop('disabled', false);   
	}
    });
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++	
}

// **************************************************************************************************
function pedirMaterias(destinoId){
//+++++++++++++++++++++++++++++++LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++				
	var parametros = {"materiaid" : 0};	
 	$.ajax({ 
    url:   './apis/obtener_materias.php',
    type:  'GET',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){$(destinoId).empty();},
    done: function(data){},
    success:  function (re){
		var r = JSON.parse(re);
		//alert(r['estado']);
       if(r['estado'] == 1 && ! (re.indexOf("Stack") > -1 || re.indexOf("SQLSTATE") > -1)) {
        $(r['Materias']).each(function(i, v)
		        { // indice, valor
		                		//TUVE QUE AGREGARLE, QUE NO EXISTA EL ELEMENTO, PORQUE SE ESTA
						//anioCurso, idColegio, idcurso, idmateria, nombreMateria ,curcursos.nombreCurso
						
		        	if (! $(destinoId).find("option[value='" + v.idmateria + "']").length)
		        	{						
						  $(destinoId).append('<option value="' + v.idmateria + '">' +v.anioCurso+'_'+ v.nombreCurso+'_'+v.nombreMateria+'</option>');
					}		
		        });
		}
		else {			
		    $(destinoId).empty();
			$(destinoId).append('<option value="' + '9999' + '">' + r['Materias'] + '</option>');
			$(destinoId).val('9999');
			$(destinoId).prop('disabled', false);

			};
			
       $(destinoId).prop('disabled', false);
    },
     error: function (xhr, ajaxOptions, thrownError) 
     {
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(destinoId).empty();
			$(destinoId).append('<option value="' + '9999' + '">' + 'JQERY:Error en consulta (ver console.Log)' + '</option>');
			$(destinoId).val('9999');
			$(destinoId).prop('disabled', false);   
	}
    });
//++++++++++++++++++++++FIN DE LA LLAMADA AL GET+++++++++++++++++++++++++++++++++++++++++++++++++++++		
}
// **************************************************************************************************


// ****************************************************************
function agregamateria(){	 

	var parametros = {"materianombre":$("#materiaNombre").val(),"icursomateria":$("#icursomateria").val(),"colegiomateria":$("#icolegiocursom").val(),"ianio":$("#ianio").val()};	
 	
 	$.ajax({ 
    url:   './apis/insertar_materia.php',
    type:  'POST',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){
		//idpersona, usuariopersona, nombrepersona, tipopersona         	  
			if(re.indexOf("Stack") > -1 || re.indexOf("SQLSTATE") > -1)
					$(".errores").append(re);
			else  pedirMaterias('#materias');	 

    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });
}

// ****************************************************************

// ****************************************************************
function agregamateriaPersona(persona,cursoElegido){	 

	var parametros = {"persona":persona,"icursomateria":cursoElegido,"ianio":$("#ianio").val()};	
 	
 	$.ajax({ 
    url:   './apis/insertar_materia_persona.php',
    type:  'POST',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){
		//idpersona, usuariopersona, nombrepersona, tipopersona         	  
			if(re.indexOf("Stack") > -1 || re.indexOf("SQLSTATE") > -1)
					$(".errores").append(re);
			else  pedirMaterias2('#grillaseleccionmaterias',persona,$("#ianio").val(),cursoElegido);

    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });
}
// ****************************************************************


// ****************************************************************
function EliminarMateria(){
	
	var parametros = {"idmateria":$('#materias').val()}
 	$.ajax({ 
    url:   './apis/eliminar_materia.php',
    type:  'POST',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){
		//idpersona, usuariopersona, nombrepersona, tipopersona         	  
				pedirMaterias('#materias');	 

    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });
	
}
// ****************************************************************

// ****************************************************************
function EliminarCarpeta(){
	
	var parametros = {"carpetasfs":$('#carpetasfs').val(),"funcion":"eliminarCarpeta"}
 	$.ajax({ 
    url:   './apis/curFunciones.php',
    type:  'POST',
    data: parametros ,
    datatype:   'text json',
	// EVENTOS QUE PODRIAN OCURRIR CUANDO ESTEMOS PROCESANDO EL AJAX		            
    beforeSend: function (){},
    done: function(data){},
    success:  function (re){
		//idpersona, usuariopersona, nombrepersona, tipopersona         	  
				pedirCarpetas('#carpetasfs');	 

    },
    error: function (xhr, ajaxOptions, thrownError)
    	{
			// LA TABLA VACIA, ES UN ERROR PORQUE NO DEVUELVE NADA
			$(".errores").append(xhr);
		}
    });
	
}
// ****************************************************************

