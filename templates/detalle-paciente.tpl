{% extends 'plantilla-principal.tpl' %}

{% block contentHeader %}
	
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
{% endblock %}

{% block content %}
<div class="page-title">
	<h2 class="page-header">Detalle de paciente</h2>
</div>

<div class="page-form form-horizontal">
 
	<div class="form-group row" >
	    <label class="col-sm-2 col-form-label">N° de historia clínica</label>
		<div class="col-md-3">
			<span class="form-control" readonly>
				{{paciente.nro_historia_clinica}}
			</span>
		</div>
	</div>

	<div class="form-group row" >
	    <label class="col-sm-2 col-form-label" >Apellido</label>
		<div class="col-md-3">
			<span class="form-control" readonly>
				{{paciente.apellido}}
			</span>
		</div>
	    <label class="col-sm-2 col-form-label">Nombre</label>
		<div class="col-md-3">
			<span class="form-control" readonly>
				{{paciente.nombre}}
			</span>
		</div>
	</div>

	<div class="form-group row" >
	    <label class="col-sm-2 col-form-label">Género</label>
	    <div class="col-sm-3">
			<span class="form-control" readonly>
				{{paciente.genero}}
			</span>
		</div>
	</div>

	<div class="form-group row" >
	    <label class="col-sm-2 col-form-label" for="FechaNacimiento">Fecha de Nacimiento</label>
		<div class="col-md-3">
			<span class="form-control" readonly>
				{{paciente.fecha_nac}}
			</span>
		</div>


	    <label class="col-sm-2 col-form-label">Lugar de Nacimiento</label>
		<div class="col-md-3">
			<span class="form-control" readonly>
				{{paciente.lugar_nac}}
			</span>
		</div>
	</div>


	<div class="form-group row" >
	    <label class="col-sm-2 col-form-label">Partido</label>
	    <div class="col-sm-3">
			<span class="form-control" readonly>
				{{paciente.partido}}
			</span>
		</div>
	    <label class="col-sm-2 col-form-label">Localidad</label>
	    <div class="col-sm-3">
			<span class="form-control" readonly>
				{{paciente.localidad}}
			</span>
		</div>			
	</div>


	<div class="form-group row" >
	    <label class="col-sm-2 col-form-label">Región Sanitaria</label>
		<div class="col-md-3">
			<span class="form-control" readonly>
				{{paciente.region}}
			</span>
		</div>
	</div>

	<div class="form-group row" >
	    <label class="col-sm-2 col-form-label">Domicilio</label>
		<div class="col-md-3">
			<span class="form-control" readonly>
				{{paciente.domicilio}}
			</span>
		</div>
	</div>

	<div class="form-group row" >
	    <label class="col-sm-2 col-form-label">Tipo Documento</label>
	    <div class="col-sm-3">
			<span class="form-control" readonly>
				{{paciente.tipoDoc}}
			</span>
		</div>
	</div>
	<div class="form-group row" >
	    <label class="col-sm-2 col-form-label">Número documento</label>
	    <div class="col-sm-3">
			<span class="form-control" readonly>
				{{paciente.numero}}
			</span>
		</div>
	</div>

	<div class="form-group row" >
	    <label class="col-sm-2 col-form-label">N° de carpeta</label>
		<div class="col-md-3">
			<span class="form-control" readonly>
				{{paciente.nro_carpeta}}
			</span>
		</div>
	</div>

	<div class="form-group row" >
	    <label class="col-sm-2 col-form-label">Tel / Cel</label>
		<div class="col-md-3">
			<span class="form-control" readonly>
				{{paciente.tel}}
			</span>
		</div>
	</div>

	<div class="form-group row" >
	    <label class="col-sm-2 col-form-label">Obra Social</label>
	    <div class="col-sm-3">
			<span class="form-control" readonly>
				{{paciente.obra}}
			</span>
		</div>
	</div>	

</div>

{% endblock %}

{% block contentFooter %}

<script src="./js/InvocacionesAjax.js"></script>
<script>

$( function() {

 // Single Select
 $( "#autocomplete" ).autocomplete({
	source: function( request, response ) {
	 // Fetch data

	 $.ajax({
		url: "index.php?ctl=autocompletarUsuario",
		type: 'post',
		dataType: "json",
		data: {
		 search: request.term
		},
		success: function( data ) {
		 response( data );
		}
	 });
	},
	select: function (event, ui) {
	 // Set selection
	 $('#autocomplete').val(ui.item.label); // display the selected text
	 $('#selectuser_id').val(ui.item.value); // save selected id to input
	 return false;
	}
 });
</script>
{% endblock %}