{% extends 'plantilla-principal.tpl' %}

{% block content %}

	<div class="page-title">
	 <h2 class="page-header">Listado de Pacientes</h2>
	</div>
	<div class="row">
		<form class="col-md-12" method="post" action="./index.php?ctl=ShowListadoPaciente">
			<div class="form-row">
			<div class="input-group input-group-sm col-md-10">
				<div class="input-group-prepend">
					<span class="input-group-text" id="">Apellido y Nombre</span>
				</div>
				<input type="text" name="apellido" value="{{apellido}}" class="form-control">
				<input type="text" name="nombre" value="{{nombre}}" class="form-control">
			</div>         
			<div class="form-group col-md-2">
				<select class="form-control form-control-sm" name="genero">
					<option value="">Seleccione</option>
					{% for g in generos %}
						<option {% if generoSeleccionado is not null and  generoSeleccionado == g.id  %} {{"selected"}} {% endif %} value="{{g.id}}">
							 {{g.nombre}}
						</option>
					{% endfor %}
				</select>
			</div>
			</div>
			<div class="form-row">
				<div class="input-group input-group-sm col-md-6">
					<div class="input-group-prepend">
						<span class="input-group-text" id="inputGroup-sizing-sm">Documento</span>
					</div>
					<input type="text" class="form-control" aria-label="Small" name="numeroDocumento" value="{{numDocumento}}" aria-describedby="inputGroup-sizing-sm">
				</div>
				<div class="input-group input-group-sm col-md-4">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon3">Nº de Historia Clínica</span>
					</div>
					<input type="text" class="form-control" name="numHistClinica" value="{{num_historia_clinica}}" aria-describedby="basic-addon3">
				</div>
				<button type="submit" class="btn btn-outline-success btn-sm col-md-2">Buscar</button>
			</div>
		</form>
	</div>
	<div class="row">
		<table class="table table-hover">
			<thead>
			<tr>
				<th scope="col">Apellido</th>
				<th scope="col">Nombre</th>
				<th scope="col">Nº de Documento</th>
				<th scope="col">Nº de Historia Clínica</th>
				<th scope="col" class="acciones"></th>
			</tr>
			</thead>
			<tbody>

				{% for paciente in pacientes %}
					<tr>
					  <th scope="row">{{paciente.apellido}}</th>
					  <td>{{paciente.nombre}}</td>
					  <td>{{paciente.numero}}</td>
					  <td>{{paciente.nro_historia_clinica}}</td>
					  <td class="acciones">
					  	
					  	{% if siHabilitadoActualizacion %}
							<a href="./index.php?ctl=ShowActualizarPaciente&pacienteId={{paciente.id}}"><i class="far info fa-edit"></i></a>
					  	{% endif %}

					  	{% if siHabilitadoDetalle %}
					  		<a href="./index.php?ctl=DetallePaciente&pacienteId={{paciente.id}}"><i class="fas fa-info-circle"></i></a>
					  	{% endif %}
					  	
					  	{% if siHabilitadoBaja %}
						  	<a href="#" 
						  		onclick="AbrirModalBajaPaciente({{paciente.id}})" >
						  		<i class="fas fa-trash"></i>
						  			
						  	</a>
					  	{% endif %}

					  </td>
					</tr>
				{% endfor %}

			</tbody>
		</table>
		<nav aria-label="Paginador">

          	{%  set num_filas = num_filas %}
          	{%  set tamagno_paginas = tamagno_paginas %}
          	{%  set pagina = pagina %}
          	{%  set total_paginas = total_paginas %}
          	{% set parametros = '&genero='~ generoSeleccionado 
          	~'&nombre='~ nombre 
          	~'&apellido='~ apellido 
          	~'&numHistClinica='~ num_historia_clinica
          	~'&numeroDocumento='~ numDocumento
          	 %}
			{% if num_filas > 0 %}
				<ul class="pagination">
					<li  class="page-item {% if pagina <= 1 %}{{"disabled"}}{% endif %}" >
						<a class="page-link" 
						href="./index.php?ctl=ShowListadoPaciente&pagina={{pagina - 1}}{{parametros}}">
							Anterior</a>
					</li>
					{% for pag in 1..total_paginas %}
	                	<li class="page-item {% if pagina ==  pag  %} {{ "active" }} {% endif %}" >
	                		<a class="page-link" 
	                		href="./index.php?ctl=ShowListadoPaciente&pagina={{ pag }}{{parametros}}">{{ pag }}</a>
	            		</li>
					{% endfor %}
					
					<li class="page-item{% if pagina >= total_paginas %} {{"disabled"}}{% endif %}" >
						<a class="page-link" 
							href="./index.php?ctl=ShowListadoPaciente&pagina={{pagina + 1}}{{parametros}}" >
						Siguiente</a>
					</li>
				</ul>
			{% endif %}	
		</nav>
	</div>

	{% if siHabilitadoBaja %}
		<!-- modal baja paciente -->
		<div class="modal fade" id="ModalBajaPaciente" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Baja de Paciente</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
					  </div>
					  <div class="modal-body">
							Desdea dar baja el paciente?
					  </div>
					  <div class="modal-footer">
					    	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

							<form method="post"  action="./index.php?ctl=EliminarPaciente">
								<input type="hidden" id="PacienteId" name="PacienteId">
								<input type="submit" class="btn btn-primary" value="Aceptar">
							</form>
					  </div>
				</div>
			</div>
		</div>
	{% endif %}	

{% endblock %}
{% block contentFooter %}
<script type="text/javascript">

{% if siHabilitadoBaja %}

	function AbrirModalBajaPaciente(PacienteId){
		console.log(PacienteId);
		$("#PacienteId").val(PacienteId);

		$("#ModalBajaPaciente").modal("show");
	}

{% endif %}	
</script>

{% endblock %}