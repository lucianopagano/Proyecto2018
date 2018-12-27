{% extends "plantilla-principal.tpl" %}
{% block javascripts %}


{% endblock %}
{% block content %}

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



});
$(document).ready(function(){
		$("button").click(function(){
				var selectuser_id = $("#selectuser_id").val();
				//alert(selectuser_id);
				$.ajax({
				 url: "index.php?ctl=searchUsuario",
				 type: 'post',
				 dataType: "json",
				 data: {
					search: selectuser_id
				 },
				 success: function( data ) {
					//response( data );
					if (data){

						$('#tabla').empty();
						$(data).each(function(i, v){ // indice, valor
							//alert(v.username);
						$('#tabla').append('<tr><td>'+ v.username +'</td><td>'+ v.last_name +'</td><td>'+ v.first_name +'</td><td>'+ v.email +'</td><td>'+ v.activo +'</td><td>'+ '<a href="index.php?ctl=editarUsuario&id='+v.id+'"><img src="imagenes/Edit16.png" alt="modificar" title="Modificar"></a>'+
						'<a href="index.php?ctl=viewUsuario&id='+v.id+'"><img src="imagenes/view.png" alt="Ver Detalle" title="Modificar"></a>'+
						'<a href="index.php?ctl=eliminarUsuario&id='+v.id+'"onclick="return confirm('+'¿Esta seguro que desea borrar el usuario v.username ?'+')"><img src="imagenes/eliminar.png" alt="eliminar" title="Eliminar"></a>' +'</td></tr>');

						 });

					 $('#tabla').show("slow");
					}
					else {alert('1er. debe realizar una busqueda de usuario');}
				 }
				});
		});
});
</script>
<section >
		<div class="page-title">
			<h2 class="page-header">Listado de Usuarios</h2>
		</div>
		<h5>Buscar usuarios: </h5>
		<div class="row">
				<div class="col-12">
						<div class="input-group">
								<input type="text" name="autocomplete" id="autocomplete"  class="form-control border-secondary py-2"  placeholder="Nombre de Usuario">

								<div class="input-group-append">
									<input type=hidden  id='selectuser_id' >
										<button name=iduser class="btn btn-outline-secondary" type="submit" >
												<i class="fa fa-search"></i>
										</button>
								</div>

								<br>
								<!--<div>

								<button  class="btn btn-default"  type="submit" onclick="location.href='index.php?ctl=showAltaUsuario'">
										<span class="glyphicon glyphicon-plus"></span> +
									</button>
								</div>-->
						</div>
				</div>
		</div>
		</div>

		<br>
		<div class="row">
			<table class="table table-hover">

						<thead>
							 <tr class="encabezado">
							 <th scope="col"scope="col">Usuario</th>
							 <th scope="col">Apellido</th>
								<th scope="col">Nombre</th>
								<th scope="col">E-mail</th>
								<th scope="col">Activo</th>

								<th scope="col">Acción</th>

							 </tr>
						</thead>
						<tbody id="tabla">
								{% for usuario in usuarios %}

										<tr>

												<td scope="col">{{usuario.username}}</td>
												<td scope="col">{{usuario.last_name}}</td>
													<td scope="col">{{usuario.first_name}}</td>
												<td scope="col">{{usuario.email}}</td>
												<td scope="col">{{usuario.activo}}</td>



												<td class="td_botones">
												<a href="index.php?ctl=editarUsuario&id={{usuario.id}}"><img src="imagenes/Edit16.png" alt="modificar" title="Modificar"></a>
												<a href="index.php?ctl=viewUsuario&id={{usuario.id}}"><img src="imagenes/view.png" alt="modificar" title="Ver detalles"></a>
												{% for rol in rolesUserSistema %}
													{% if rol.nombre == "administrador" %}
														<a href="index.php?ctl=eliminarUsuario&id={{usuario.id}}" onclick="return confirm('¿Esta seguro que desea borrar el usuario {{usuario.username}}?')"><img src="imagenes/eliminar.png" alt="eliminar" title="Eliminar"></a>
													{%endif%}

												{% endfor %}
												</td>
										</tr>
								{% endfor%}
						</tbody>

			</table>
	
		<nav class="pagination pagination-centered">
			<ul class="pagination">
			<li class="page-item"><a class="page-link" href="index.php?ctl=listUsuarios&id={{ pagina_actual }}"><<</a></li>
			<li class="page-item"><a class="page-link" href="index.php?ctl=listUsuarios&id={{ pagina_anterior }}"><</a></li>
			{% for key in paginas %}

			<li class="page-item"><a class="page-link" href="index.php?ctl=listUsuarios{{ key }}" ></a></li>
			{% endfor %}
			<li class="page-item"><a class="page-link" href="index.php?ctl=listUsuarios&id={{ pagina_siguiente }}">></a></li>
			<li class="page-item"><a class="page-link" href="index.php?ctl=listUsuarios&id={{ ultima_pagina }}">>></a></li>
			</ul>

		</nav>
</div>

</div>
</section>

{% endblock %}
