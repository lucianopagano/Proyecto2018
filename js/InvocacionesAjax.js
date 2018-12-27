var urlApi= "https://"+window.location.hostname+"/index.php?ctl=";
//var urlApi= "http://"+window.location.hostname+"/grupo20/index.php?ctl=";

function SetChartConsultaMotivos(funcionChart){
	var accion = "ObtenerCantidadConsultaMotivos";
	AjaxGet(accion,funcionChart,false);
}

function SetChartConsultaLocalidades(funcionChart){
	var accion = "ObtenerCantidadConsultaLocalidad";
	AjaxGet(accion,funcionChart,false);
}

function SetChartConsultaGenero(funcionChart){
	var accion = "ObtenerCantidadConsultaGeneros";
	AjaxGet(accion,funcionChart,false);
}

function ObtenerObrasSociales(funcionObraSocial,obraSocialId, siAsincronico=true){
	
	var accion = "GetObrasSociales";


	if(obraSocialId != null){
		accion += ("&obraSocial=" + obraSocialId)
	}


	AjaxGet(accion,funcionObraSocial,siAsincronico);
}


function ObtenerLocalidadesByPartido(partidoId, funcionLocalidades,siAsincronico=true){
	

	var accion = "GetLocalidadesByPartido&partido="+partidoId;

	AjaxGet(accion,funcionLocalidades,siAsincronico);
}

function ObtenerLocalidaes(funcionLocalidades,localidad= null, siAsincronico=true){

	var accion = "GetLocalidades"
	

	if(localidad != null){
		accion += ("&localidadId=" + localidad)
	}

	
	AjaxGet(accion,funcionLocalidades,siAsincronico);

}

function ObtenerRegionSanitaria(regionId, funcionRegionSanitaria){
	
	var accion = "GetRegionSanitaria&region="+regionId;
	AjaxGet(accion,funcionRegionSanitaria);
}


function ObtenerPartidos(functionPartidos, partidoId, siAsincronico=true){
	var accion = "GetPartidos";
	AjaxGet(accion,functionPartidos,siAsincronico);
}

//obtiene uno o todos los documentos 
//si en tipo de documento se pone en null
//obtiene todos
function ObtenerTipoDocumentos(funcionTipoDocumento,tipoDocumento,siAsincronico=true){
	var accion = "GetTipoDocumentos"
	if(tipoDocumento != null){
		accion += ("&tipoDocumento=" + tipoDocumento)
	}

	AjaxGet(accion,funcionTipoDocumento,siAsincronico);
}

//esta funcion lo que realiza es la invocacion a ajax
//accion = a donde se quiere invocar
//funcion a ejecutar despues de la invocación
function AjaxGet(accion,funcionAEjecutar,SiAsincronico = true){
	
	$.ajax({
	    type: "GET",
	    // Formato de datos que se espera en la respuesta
	    dataType: "json",
	    // URL a la que se enviará la solicitud Ajax
	    url: urlApi+accion,
	    async: SiAsincronico 
	})
	 .done(function( data, textStatus, jqXHR ) {

	 	funcionAEjecutar(data);
	 })
	 .fail(function( jqXHR, textStatus, errorThrown ) {
         console.log( "La solicitud a fallado: " +  textStatus);
	});

}


function AjaxPost(accion,funcionAEjecutar,data){


	$.post(urlApi+accion, data, 
	    function(returnedData){
	         console.log(returnedData);
	}).fail(function(){
	      console.log("error");
	});

}