{% extends 'plantilla-principal.tpl' %}

{% block contentHeader %}
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
{% endblock %}

{% block content %}
<div class="page-title">
	<h2 class="page-header">{% if paciente is null %} Alta {% else %} Modificación {% endif %} de paciente</h2>
</div>



<div class="page-form form-horizontal">

	{% if paciente is null %}
		<div class="form-group row" >
		    <label class="col-sm-6 col-form-label">Se conoce la identidad del paciente? </label>
		    <div class="col-sm-6 form-check">
			    <div class="form-check">
		        	<input type="checkbox"
			        class="form-check-input" 
			        id="SiNN"
			        name="SiNN">

		      		<label class="form-check-label" for="SiTienDocumento">No</label>
			    </div>
			</div>
		</div>
	{% endif %}


	<form class="form" method="post"  id="formPaciente" action="./index.php?ctl={% if paciente is null %}AgregarPaciente{% else %}ActualizarPaciente{% endif %} ">
		<input type="hidden" name="id" value="{{paciente.id}}">
		<div class="form-group row" >
		    <label class="col-sm-2 col-form-label">N° de historia clínica</label>
			<div class="col-md-3">
				<input type="text" name="NumHistoriaClinica" 
				required 
				{% if paciente.nro_historia_clinica %} readonly value="{{paciente.nro_historia_clinica}}" {% endif %} 
				
				class="form-control">
			</div>
		</div>

		<div class="form-group row" >
		    <label class="col-sm-2 col-form-label" >Apellido</label>
			<div class="col-md-3">
				<input type="text" name="Apellido" required id="Apellido" value="{{paciente.apellido}}" class="form-control">
			</div>
		    <label class="col-sm-2 col-form-label">Nombre</label>
			<div class="col-md-3">
				<input type="text" name="Nombre" required id="Nombre" value="{{paciente.nombre}}"  class="form-control">
			</div>
		</div>

		<div class="form-group row" >
		    <label class="col-sm-2 col-form-label">Género</label>
		    <div class="col-sm-3">
				<select name="Genero" class="form-control" required >

					{% for g in generos %}
						<option {% if paciente.genero_id == g.id  %} {{"selected"}} {% endif %} value="{{g.id}}">
							 {{g.nombre}}
						</option>
					{% endfor %}
				</select>
			</div>
		</div>

		<div class="form-group row" >
		    <label class="col-sm-2 col-form-label" for="FechaNacimiento">Fecha de Nacimiento</label>
			<div class="col-md-3">
				<input type="date"
				placeholder="dd/mm/aaaa"
				value="{{paciente.fecha_nac}}" 
				required 
				pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d"
				name="FechaNacimiento" id="FechaNacimiento" class="form-control">

			</div>


		    <label class="col-sm-2 col-form-label">Lugar de Nacimiento</label>
			<div class="col-md-3">
				<input type="text" name="LugarNacimiento" value="{{paciente.lugar_nac}}" class="form-control">
			</div>
		</div>

		<div class="form-group row" >
		    <label class="col-sm-2 col-form-label">Partido</label>
		    <div class="col-sm-3">
				<select id="Partido" class="form-control">
				</select>
			</div>
		    <label class="col-sm-2 col-form-label">Localidad</label>
		    <div class="col-sm-3">
				<select name="Localidad" id="Localidad" class="form-control">
				</select>
			</div>			
		</div>

		<div class="form-group row" >
		    <label class="col-sm-2 col-form-label">Región Sanitaria</label>
			<div class="col-md-3">
				<input type="text" id="Region" readonly class="form-control">
				<input type="hidden" id="RegionId" name="RegionSanitaria" >
			</div>
		</div>

		<div class="form-group row" >
		    <label class="col-sm-2 col-form-label">Domicilio</label>
			<div class="col-md-3">
				<input type="text" name="Domicilio" value="{{paciente.domicilio}}" required class="form-control">
			</div>
		</div>

		<div class="form-group row" >
		    <label class="col-sm-2 col-form-label">Tiene en su poder su documento?</label>
		    <div class="col-sm-3 form-check">
			    <div class="form-check">
		        	<input type="checkbox"
			        data-toggle="collapse" 
			        data-target="#documentoSection"
			        class="form-check-input" 
			        id="SiTienDocumento"
			        {% if paciente.tiene_documento %} checked {% endif %}
			        name="SiTienDocumento">

		      		<label class="form-check-label" for="SiTienDocumento">Si</label>
			    </div>
			</div>
		</div>

		<div class="form-group row" >
		    <label class="col-sm-2 col-form-label">Tipo Documento</label>
		    <div class="col-sm-3">
				<select name="TipoDocumento" id="TipoDocumento" required class="form-control">
				</select>
			</div>
		</div>
		<div class="form-group row" >
		    <label class="col-sm-2 col-form-label">Número documento</label>
			<div class="col-md-3">
				<input type="text" id="NumDocumento" value="{{paciente.numero}}" required name="NumDocumento" class="form-control">
			</div>
		</div>

		<div class="form-group row" >
		    <label class="col-sm-2 col-form-label">N° de carpeta</label>
			<div class="col-md-3">
				<input type="text" name="NumCarpeta" value="{{paciente.nro_carpeta}}" class="form-control">
			</div>
		</div>

		<div class="form-group row" >
		    <label class="col-sm-2 col-form-label">Tel / Cel</label>
			<div class="col-md-3">
				<input type="text" name="Tel" value="{{paciente.tel}}" class="form-control">
			</div>
		</div>

		<div class="form-group row" >
		    <label class="col-sm-2 col-form-label">Obra Social</label>
		    <div class="col-sm-3">
				<select id="ObraSocial" name="ObraSocial" class="form-control">
				</select>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="pull-right">
					<button type="submit" class="btn btn-primary" alt="Dar de alta el paciente en el sistema">{% if paciente 	%}Modificar {% else %}Ingresar{% endif %} Paciente
					</button>	
				</div>
			</div>
		</div>
		<div class="form-group">
            <label for="tipoAsignatura" class="col-sm-2 control-label">Tratamiento farmacológico:</label>
            <div class="col-sm-10">
                {# select #}
                <select name="tipoAsignatura" id="tipoAsignatura" class="form-control" onChange="">
                    <option value="Mañana" selected>Mañana</option>
                    <option value="Tarde">Tarde</option>
                    <option value="Noche">Noche</option>
                </select>
            </div>
        </div>

{% endblock %}

{% block contentFooter %}

<script src="./js/InvocacionesAjax.js"></script>
<script>



	$("#SiNN").on('change',function () {
		if(this.checked){
			$("#Apellido").prop("readonly", true);
			$("#Nombre").prop("readonly", true);
			$("#Apellido").val("N");
			$("#Nombre").val("N");
		}
		else{

			$("#Apellido").val("");
			$("#Nombre").val("");

			$("#Apellido").removeAttr("readonly");
			$("#Nombre").removeAttr("readonly");
		}
	});

	$(document).ready(function(){

		{% if paciente %}
				ObtenerPartidos(PopulatePartidos,null,false);

				//asincronico
				ObtenerObrasSociales(PopulateObrasSociales,null,false);
				
				//asincronico
				ObtenerTipoDocumentos(PopulateTipoDocumento,null,false);


				var localidadId = "{{- paciente.localidad_id -}}";
				if(localidadId != null && localidadId != undefined &&  localidadId !=""){
					ObtenerLocalidaes( SetLocalidad ,localidadId,false);
				}
				var regionId = "{{- paciente.region_sanitaria_id -}}";
				if(regionId != null && regionId != undefined &&  regionId !="" ){
					ObtenerRegionSanitaria(regionId,SetRegion)
				}

				var ObraSocial = "{{- paciente.obra_social_id -}}";
				if(ObraSocial != null && ObraSocial != undefined &&  ObraSocial !=""){
					SetObraSocial(ObraSocial);
				}


				var TipoDocumento = "{{- paciente.tipo_doc_id -}}";
				if(TipoDocumento != null && TipoDocumento != undefined &&  TipoDocumento !=""){

					SetTipoDocumento(TipoDocumento);
				}

		{% else %}
			ObtenerPartidos(PopulatePartidos,null);
			ObtenerObrasSociales(PopulateObrasSociales,null);
			ObtenerTipoDocumentos(PopulateTipoDocumento,null);
		{% endif %}		
	});

	function PopulatePartidos(data){
		$('#Partido').append($('<option></option>').attr('value', '').text("Seleccione..."));
		$.each(data, function (key, entry) {
			$('#Partido').append($('<option></option>').attr('value', entry.id).attr('regionSanitaria',entry.region_sanitaria_id).text(entry.nombre));
		});
	}

	$('#Partido').change(function() {
		$('#Localidad').empty();
		$("#Region").val("");
		var partidoId= $("#Partido option:selected").val();

		if(partidoId > -1){
			var regionSanitariaId= $("#Partido option:selected").attr('regionsanitaria');
			ObtenerRegionSanitaria(regionSanitariaId,SetRegion);	
		}

		ObtenerLocalidadesByPartido(partidoId,PopulateLocalidades);
	});

	function PopulateLocalidades(data){

		$('#Localidad').empty();

		$('#Localidad').append($('<option></option>').attr('value', -1).text("Seleccione..."));
		$.each(data, function (key, entry) {
			$('#Localidad').append($('<option></option>').attr('value', entry.id).text(entry.nombre));
		});
	}

	function SetObraSocial(id){
		$('#ObraSocial').val(id);
	}

	function SetRegion(data){
		$("#Region").val(data.nombre);
		$("#RegionId").val(data.id);
	}
	

	function SetTipoDocumento(id){
		$('#TipoDocumento').val(id);
	}

	function PopulateTipoDocumento(data){
		$('#TipoDocumento').empty();

		$('#TipoDocumento').append($('<option></option>').attr('value', "").text("Seleccione..."));
		$.each(data, function (key, entry) {
			$('#TipoDocumento').append($('<option></option>').attr('value', entry.id).text(entry.nombre));
		});
	}

	function PopulateObrasSociales(data){
		$('#ObraSocial').empty();

		$('#ObraSocial').append($('<option></option>').attr('value', '').text("Seleccione..."));
		$.each(data, function (key, entry) {
			$('#ObraSocial').append($('<option></option>').attr('value', entry.id).text(entry.nombre));
		});
	}


	function SetLocalidad(data){

		ObtenerLocalidadesByPartido(data.partido_id,PopulateLocalidades,false);

		$('#Localidad').val(data.id);

		$("#Partido").val(data.partido_id);
		
	}


$("#formPaciente").validate({
	rules:{
		NumHistoriaClinica: {
			required:true,
			digits:true,
			max:999999
		},

		NumCarpeta: {
			digits:true,
			max:99999
		},

		NumDocumento:{
			required:true,
			digits:true,
		}

	},
	messages: {
		Apellido:"campo Requerido",
		Nombre:"campo Requerido",
		NumHistoriaClinica: {
			required:"campo requerido",
			digits:"Solo se aceptan números",
			max: "Solo se aceptan hasta 6 números"
		},
		FechaNacimiento: "campo requerido",
		Domicilio:"campo requerido",
		NumCarpeta: {
			required:"campo requerido",
			digits:"Solo se aceptan números",
			max: "Solo se aceptan hasta 5 números"
		},
		NumDocumento:{
			required:"campo requerido",
			digits:"Solo se aceptan números",
		},
		TipoDocumento: {
			requerido:"campo requerido"
		}

	}
})

</script>
{% endblock %}