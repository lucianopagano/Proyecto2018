{% extends "plantilla-principal.tpl" %}
{% block javascripts %}


{% endblock %}
{% block content %}


<script>
$(function() {

 // Single Select
 $( "#autocomplete" ).autocomplete({
	source: function( request, response ) {
	 // Fetch data

	 $.ajax({
		url: "index.php?ctl=autocompletarPaciente",
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
	 $('#user_id').val(ui.item.value); // save selected id to input
	 return false;
	}
 });



});





$(document).ready(function(){
		$("button").click(function(){
				var user_id = $("#user_id").val();
				//alert(user_id);
				$.ajax({
				 url: "index.php?ctl=searchPaciente",
				 type: 'post',
				 dataType: "json",
				 data: {
					search: user_id
				 },
				 success: function( data ) {
					//response( data );
					if (data){
						$('#dni').val(data.numero);
						$('#nombre').val(data.nombre);
						$('#apellido').val(data.apellido);
					}
					else {alert('Error, 1er. Debe realizar la busqueda del paciente!!!');}
				 }
				});
				$.ajax({
				 url: "index.php?ctl=searchInstituciones",
				 type: 'post',
				 dataType: "json",
				 data: {
					search: user_id
				 },
				 success: function( data ) {
					//alert( data );
					if (data){
						$('#tabla').empty();
						$(data).each(function(i, v){ // indice, valor
							//alert(v.username);
						$('#tabla').append('<tr><td>'+ v.fecha +'</td><td>'+ v.nombreMotivo +'</td><td>'+ v.nombreDerivacion +'</td><td>'+ v.internacion +'</td><td>'+ v.tratamientoNombre +'</td><td>'+ v.acompanamientoNombre +'</td><td>'+ '<a href="index.php?ctl=showEditarConsulta&id='+v.id+'"><img src="imagenes/Edit16.png" alt="modificar" title="Modificar"></a>'+
						'<a href="index.php?ctl=eliminarConsulta&id='+v.id+'onclick="return confirm( ¿Esta seguro que desea borrar el usuario '+v.username +'?)"><img src="imagenes/eliminar.png" alt="eliminar" title="Eliminar"></a></td></tr>');

						 });

					 $('#tabla').show("slow");
						
					}
					else {alert('Upsss!, No hay historial para dibujar!!!');}
				 }
				});
		});
});

</script>
<section >
		<div class="page-title">

	 <h2 class="page-header">Atención de Pacientes</h2>
	</div>
	<!--<form class="col-md-12" method="post" action="./index.php?ctl=ingresarAtencionMedica"> -->
	<div class="row">
		<div class="col-12">
			<div class="input-group input-group-sm col-md-10">
				<div class="input-group-prepend">
					<span class="input-group-text" id="">Buscar Paciente:</span>
				</div>
				<input type="text" name="autocomplete" id="autocomplete"  class="form-control border-secondary py-2"  placeholder="Nombre de Paciente o DNI">

				<div class="input-group-append">
					<input type=hidden name='user_id' id='user_id' >
					<button name=iduser class="btn btn-outline-secondary" type="submit" >
						<i class="fa fa-search"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="input-group input-group-sm col-md-10">
				<div class="input-group-prepend">
					<span class="input-group-text" >DNI: </span>
				</div>
				<input type="text" id="dni" name="dni" value="{{dni}}" class="form-control" required>
			</div>  
			<br>
			<div class="input-group input-group-sm col-md-10">
				<div class="input-group-prepend">
					<span class="input-group-text" id="">Apellido y Nombre: </span>
				</div>
				<input type="text" id="apellido" name="apellido" value="{{apellido}}" class="form-control" required>
				<input type="text" id="nombre" name="nombre" value="{{nombre}}" class="form-control" required>
				
			</div> 

	</div>
	<br><br>
	<div class="page-title">
			<h2 class="page-header">Listado de consulas de Pacientes</h2>					
		</div>
	

		<div class="row">
			<table class="table table-hover">

						<thead>
							 <tr class="encabezado">
							 <th scope="col"scope="col">Fecha</th>
							 <th scope="col">Motivo</th>
							 <th scope="col">Derivación</th>
							 <th scope="col">Internacion</th>
                             <th scope="col">Tratamiento</th>
                             <th scope="col">Acompañamiento</th>
                             <th scope="col">Acción</th>


							 </tr>
						</thead>
						<tbody id="tabla">
								{% for consulta in consultas %}

										<tr>

												<td scope="col">{{consulta.fecha}}</td>
												<td scope="col">{{consulta.nombreMotivo}}</td>
												<td scope="col">{{consulta.nombreDerivacion}}</td>
												
												<td scope="col">{{consulta.internacion}}</td>
												<td scope="col">{{consulta.tratamientoNombre}}</td>
												<td scope="col">{{consulta.acompanamientoNombre}}</td>



												<td class="td_botones">
												<a href="index.php?ctl=showEditarConsulta&id={{consulta.id}}"><img src="imagenes/Edit16.png" alt="modificar" title="Modificar"></a>
												
												{% for rol in rolesUserSistema %}
													{% if rol.nombre == "administrador" %}
														<a href="index.php?ctl=eliminarConsulta&id={{consulta.id}}" onclick="return confirm('¿Esta seguro que desea borrar la Consulta para le fecha: {{ consulta.fecha  }}?')"><img src="imagenes/eliminar.png" alt="eliminar" title="Eliminar"></a>
													{%endif%}

												{% endfor %}
												</td>
										</tr>
								{% endfor%}
						</tbody>

			</table>
	
		<nav class="pagination pagination-centered">
			<ul class="pagination">
			<li class="page-item"><a class="page-link" href="index.php?ctl=listarConsultas&id={{ pagina_actual }}"><<</a></li>
			<li class="page-item"><a class="page-link" href="index.php?ctl=listarConsultas&id={{ pagina_anterior }}"><</a></li>
			{% for key in paginas %}

			<li class="page-item"><a class="page-link" href="index.php?ctl=listarConsultas{{ key }}" ></a></li>
			{% endfor %}
			<li class="page-item"><a class="page-link" href="index.php?ctl=listarConsultas&id={{ pagina_siguiente }}">></a></li>
			<li class="page-item"><a class="page-link" href="index.php?ctl=listarConsultas&id={{ ultima_pagina }}">>></a></li>
			</ul>

		</nav>
</div>

</div>
</section>

{% endblock %}
