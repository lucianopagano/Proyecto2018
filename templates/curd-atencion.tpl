{% extends 'plantilla-principal.tpl' %}

{% block content %}

<div class="page-title">

	 <h2 class="page-header">Atención de Pacientes</h2>
	</div>
	<form class="col-md-12" method="post" action="./index.php?ctl={% if paciente %}editarConsulta {% else %}ingresarAtencionMedica{% endif %}">
	<div class="row">
		
		{% if paciente is null %}
		<div class="col-12">
			<div class="input-group input-group-sm col-md-10">
				<div class="input-group-prepend">
					<span class="input-group-text" id="">Buscar Paciente:</span>
				</div>
				<input type="text" name="autocomplete" id="autocomplete"  class="form-control border-secondary py-2"  placeholder="Nombre de Paciente o DNI">

				<div class="input-group-append">
					<input type=hidden name='selectuser_id' id='selectuser_id' >
					<button name=iduser class="btn btn-outline-secondary" type="submit" >
						<i class="fa fa-search"></i>
					</button>
				</div>
			</div>
		</div>
		{% endif %}
	</div>
	<br>
	<div class="row">
		<div class="input-group input-group-sm col-md-10">
				<div class="input-group-prepend">
					<span class="input-group-text" >DNI: </span>
				</div>
				<input type="text" id="dni" name="dni" value="{{paciente.numero}}" class="form-control" required>
			</div>  
			<br>
			<div class="input-group input-group-sm col-md-10">
				<div class="input-group-prepend">
					<span class="input-group-text" id="">Apellido y Nombre: </span>
				</div>
				<input type="text" id="apellido" name="apellido" value="{{paciente.apellido}}" class="form-control" required>
				<input type="text" id="nombre" name="nombre" value="{{paciente.nombre}}" class="form-control" required>
				
			</div> 
	</div>
	{% if paciente is null %}				
	<br>
	<h1>Historia Clinica</h1>
	 


<div style="width: 740px; height: 480px" id="map"></div>
	{% endif %}
	<div class="input-group-append">
					<input type=hidden name='consulta_id' id='consulta_id'value="{{consulta.id}}" > 
					
				</div>
	<br>
	<div class="form-group row" >
		    <label class="col-sm-2 col-form-label" for="FechaDeTurno">Fecha de Turno:</label>
			<div class="col-md-3">
				<input type="date"
				placeholder="dd/mm/aaaa"
				value="{{consulta.fecha}}" 
				required 
				pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d"
				name="FechaDeTurno" id="FechaDeTurno" class="form-control">

			</div>
	</div>

	<div class="form-group row" >
		    <label class="col-sm-2 col-form-label">Motivo</label>
		    <div class="col-sm-3">
				<select name="Motivo" class="form-control" required >

					{% for m in motivos %}
						<option {% if consulta.motivo_id == m.id  %} {{"selected"}} {% endif %} value="{{m.id}}">
							 {{m.nombre}}
						</option>
					{% endfor %}
				</select>
			</div>
		</div>
		<div class="form-group row" >
		    <label class="col-sm-2 col-form-label">Derivación:</label>
		    <div class="col-sm-3">
		    	
				<select name="Derivacion" class="form-control" required >

					{% for m in instituciones %}
						
						<option {% if consulta.derivacion_id == m.id  %} {{"selected"}} {% endif %} value="{{m.id}}">
							 {{m.nombre}}
						</option>
					{% endfor %}
				</select>
			</div>
		</div>
			<div class="form-group row">
            <label for="tipoAsignatura" class="col-sm-2 col-form-label">Tratamiento farmacológico:</label>
            <div class="col-sm-3">
                {# select #}
                <select name="Tratamientofarmacologico" id="Tratamientofarmacológico" class="form-control" onChange="">
                    {% for m in tratamiento %}
						<option {% if consulta.tratamiento_farmacologico_id == m.id  %} {{"selected"}} {% endif %} value="{{m.id}}">
							 {{m.nombre}}
						</option>
					{% endfor %}
                </select>
            </div>
        </div>
        </div>
			<div class="form-group row">
            <label for="Acompañamiento" class="col-sm-2 col-form-label">Acompañamiento:</label>
            <div class="col-sm-3">
                {# select #}
                <select name="acompanamiento" id="acompanamiento" class="form-control" onChange="">
                    {% for m in acompanamiento %}
						<option {% if consulta.acompanamiento_id == m.id  %} {{"selected"}} {% endif %} value="{{m.id}}">
							 {{m.nombre}}
						</option>
					{% endfor %}
                </select>
            </div>
        </div>
      
  		

	<div class="form-group row" >
		    <label class="col-sm-2 col-form-label">Internación</label>
		    <div class="col-sm-3 form-check">
			    <div class="form-check">
			    	<label class="form-check-label" for="internacion">Si</label><br>
		        	<input type="checkbox"
			        value="{{items.id}}"
			        id="internacion"
			        name="internacion" {% if consulta.internacion %} checked {% endif %} >
			    </div>
			</div>
	</div>
	<div class="form-group row">
		<div class="col-5">
			<label for="exampleTextarea">Tratar con:</label>
    		<textarea class="form-control" name="tratarcon" id="tratarcon" rows="1">{{consulta.articulacion_con_instituciones}} </textarea>
  		</div>
  	</div>	
	<div class="form-group row">
		<div class="col-5">
			<label for="exampleTextarea">Diagnóstico:</label>
    		<textarea class="form-control" name="diagnostico" id="diagnostico" rows="5" required >{{consulta.diagnostico}}</textarea>
  		</div>
  		<div class="col-5">
  			<label  for="exampleTextarea">Observaciones:</label>
    		<textarea  class="form-control" name="observaciones" rows="5"id="observaciones">{{consulta.observaciones}}</textarea>
  		</div>
  	</div>
  	<div class="row">
			<div class="col-md-12">
				<div class="pull-right">
					<button type="submit" class="btn btn-primary" alt="Desea modifircar la consulta en el sistema??">{% if paciente %}Modificar {% else %}Ingresar{% endif %} Consulta
					</button>	
				</div>
			</div>
		</div>	
  	</form>	

	</div>
	<meta name="viewport" content="initial-scale=1.0, width=device-width" />
  <script src="http://js.api.here.com/v3/3.0/mapsjs-core.js"
  type="text/javascript" charset="utf-8"></script>
  <script src="http://js.api.here.com/v3/3.0/mapsjs-service.js"
  type="text/javascript" charset="utf-8"></script>
  <meta name="viewport" content="initial-scale=1.0, width=device-width" />
<link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.0/mapsjs-ui.css?dp-version=1533195059" />
<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-core.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-service.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-ui.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-mapevents.js"></script>
 <script>

    // Initialize the platform object:
    var platform = new H.service.Platform({
    'app_id': 'jpYKyCWYmDjJvuwu9hhw',
    'app_code': 'EPgtTG6LYM8hdtXxYKhZmA'
    });

    var pixelRatio = window.devicePixelRatio || 1;
var defaultLayers = platform.createDefaultLayers({
  tileSize: pixelRatio === 1 ? 256 : 512,
  ppi: pixelRatio === 1 ? undefined : 320
});

//Step 2: initialize a map - this map is centered over Europe
 var map = new H.Map(document.getElementById('map'),
 defaultLayers.normal.map,{
 center: {lat:-34.92068, lng:-57.953764},
 zoom: 11,
 pixelRatio: pixelRatio
});

//Step 3: make the map interactive
// MapEvents enables the event system
// Behavior implements default interactions for pan/zoom (also on mobile touch environments)
var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

// Create the default UI components
var ui = H.ui.UI.createDefault(map, defaultLayers);

// Now use the map as required...
//addMarkersToMap(map);
</script>

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
				 url: "index.php?ctl=searchPaciente",
				 type: 'post',
				 dataType: "json",
				 data: {
					search: selectuser_id
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
					search: selectuser_id
				 },
				 success: function( data ) {
					//alert( data );
					if (data){
						
						function addMarkerToGroup(group, coordinate, html) {
  							var marker = new H.map.Marker(coordinate);
  							// add custom data to the marker
  							marker.setData(html);
  							group.addObject(marker);
						}
						function addInfoBubble(map, data) {
  							var group = new H.map.Group();
							map.addObject(group);
							// add 'tap' event listener, that opens info bubble, to the group
  							group.addEventListener('tap', function (evt) {
    						// event target is the marker itself, group is a parent event target
    						// for all objects that it contains
    						var bubble =  new H.ui.InfoBubble(evt.target.getPosition(), {
      						// read custom data
      						content: evt.target.getData()
						    });
    						// show info bubble
    						ui.addBubble(bubble);
  							}, false);
  							
  							$.each(data, function () {
   								
  								addMarkerToGroup(group, { 'lng': parseFloat(this.logitud), 'lat': parseFloat(this.latitud) },
    						'<div> Institución:' + this.nombre +
    						'</div><br><div >Teléfono: '+this.telefono+'<br>Director:'+ this.director +' </div><br><div>Fecha de consulta:'+this.fecha+'</div>');
        						
    						});
    						
							
						}

						document.getElementById('map').innerHTML = "";
						
						var map = new H.Map(document.getElementById('map'),
 						defaultLayers.normal.map,{
 						center: {lat:-34.92068, lng:-57.953764}, zoom: 11,
 						pixelRatio: pixelRatio
						});
						// MapEvents enables the event system
						// Behavior implements default interactions for pan/zoom (also on mobile touch environments)
						var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
						
						// create default UI with layers provided by the platform
						var ui = H.ui.UI.createDefault(map, defaultLayers);
						addInfoBubble(map, data);
						/*
						var cordenadaInsti = new H.map.Marker({lat:-34.92068, lng: -57.953764});
  						map.addObject(cordenadaInsti);
  						var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
						var ui = H.ui.UI.createDefault(map, defaultLayers);
					*/
					}
					else {alert('Upsss!, No hay historial para dibujar!!!');}
				 }
				});
		});
});
</script>

{% endblock %}

{% block contentFooter %}

{% endblock %}