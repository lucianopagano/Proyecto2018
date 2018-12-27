{% extends "plantilla-principal.tpl" %}

{% block contentHeader %}
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
{% endblock %}


{% block content %}
<div class="page-title"><h2 class="page-header">Actualización de mantenimiento</h2></div>

<div class="page-form form-horizontal">
	<form class="form" method="post" id="formMantenimiento" action="./index.php?ctl=mantenimientoUpdate">
		<div class="form-group row" >
		    <label class="col-sm-2 col-form-label">Modo Mantenimiento</label>
		    <div class="col-sm-3">
				<select name="mantenimiento" class="form-control">
					{% for key,value in modoMantenimiento %}
						<option 
							value={% if key == "Si" %} 1 {% elseif key == "No"  %} 0 {% endif %} 
							{% if value == true %} selected {% endif %}>
							{{key}}
						</option>
					{% endfor %}
				</select>
			</div>
		</div>

		<div class="form-group row" >
		    <label class="col-sm-2 col-form-label">Título de Página</label>
			<div class="col-md-3">
				<input type="text" name="titulo" required value="{{titulo}}" class="form-control">
			</div>
		</div>
		<div class="form-group row" >
		    <label class="col-md-2">Descripción</label>
			<div class="col-md-3">
				<input type="text" name="descripcion" required value="{{descripcion}}" class="form-control">
			</div>
		</div>
		<div class="form-group row">
		    <label class="col-md-2">Mail de contacto</label>
			<div class="col-md-3">
				<input type="text" name="mail" required value="{{mail}}" class="form-control">
			</div>
		</div>
		<div class="form-group row">
		    <label class="col-md-2">Cantidad de páginas por listado</label>
			<div class="col-md-3">
				<input type="text" name="cantpaginas" required value="{{cantPaginas}}" class="form-control">
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="pull-right">
					<button type="submit" class="btn btn-primary">Modificar</button>	
				</div>
			</div>
		</div>			
	</form>
</div>
{% endblock %}
{% block contentFooter %}

<script type="text/javascript">


$("#formMantenimiento").validate({
	rules:{
		
		cantpaginas: {
			digits:true
		},
		mail: {
      		required: true,
      		email: true
    	}
	},
	messages: {
		mantenimiento:"campo Requerido",
		titulo:"campo requerido",
		descripcion: "campo requerido",
		mail: {
      		required: "campo requerido",
      		email: "formato inválido"
    	},
		cantpaginas: {
			required:"campo requerido",
			digits:"Solo se aceptan números"		
		}

	}
})

</script>

{% endblock %}