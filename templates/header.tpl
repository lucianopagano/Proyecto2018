<nav class="navbar navbar-expand-lg navbar-default">
	<a class="navbar-brand" href="#">
		<img src="./img/logo/Asset5.png">
	</a>

	{% if mantenimiento == null or mantenimiento == false %}
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
		aria-controls=navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
	</button>
	{% endif %}
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		{% if mantenimiento == null or mantenimiento == false %}
			<ul class="navbar-nav mr-auto">
			
				{% for rol in rolesUserSistema %}
					{% if rol.nombre == "administrador"  %}
						<li class="nav-item">
							<a class="nav-link" href="index.php?ctl=configuracion">Mantenimieto<span class="sr-only">(current)</span></a>
						</li>
				 {%endif%}
			 {% endfor %}
				{% for key, rol in rolesUserSistema %}
					
					{% if rol.nombre == "administrador" or rol.nombre == "equipoDeGuardia" and  key < 1 %}
						<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">Usuarios
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="./index.php?ctl=showAltaUsuario">Alta</a>
							<a class="dropdown-item" href="./index.php?ctl=listUsuarios">Listado</a>
						</div>
					 </li>				
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Paciente
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="./index.php?ctl=altaPacienteIndex">Alta</a>
						<a class="dropdown-item" href="./index.php?ctl=ShowListadoPaciente">Listado</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Atención 
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="./index.php?ctl=showAtencionMedica">Alta</a>
						<a class="dropdown-item" href="./index.php?ctl=listarConsultas">Listado</a>
					</div>
				</li>
			
		 
				<li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">Consultas
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="./index.php?ctl=ShowConsultasMotivo">Motivo</a>
							<a class="dropdown-item" href="./index.php?ctl=ShowConsultaGenero">Género</a>
							<a class="dropdown-item" href="./index.php?ctl=ShowConsultasLocalidad">Localidades</a>
						</div>
					 </li>

				<a class="nav-link" href="./index.php?ctl=logout">LogOut</a>
			</li>
				{%endif%}
			{% endfor %}
			{%endif%}
			{% if not rolesUserSistema %}
					
			 	<a class="nav-link" href="./index.php?ctl=login">LogIn</a>
			{% endif %}
			
			</ul>
	</div>

</nav>
