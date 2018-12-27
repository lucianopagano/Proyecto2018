<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="shortcut icon" href="./img/logo/logo-title.gif" />
    <!-- lo agrego Damian-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    
    <!-- autocomple -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


    <!-- OpenLAYERS -->
    <link rel="stylesheet" href="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.2.0/css/ol.css">
    <script src="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.2.0/build/ol.js"></script>
    <link rel="stylesheet" href="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.2.0/css/ol.css">

    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    {% block contentHeader %}
    {% endblock %}
  </head>
  <body>

    {% include 'header.tpl' %}


    <main class="container">
      {% if(mensaje != null) %}

        {% if(mensaje.tipoMensaje == 1) %}
        <div class="alert alert-success" role="alert">
          <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
          {{mensaje.mensajeAMostrar}}
        </div>

        {% elseif(mensaje.tipoMensaje == 0) %}
        <div class="alert alert-danger" role="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
          {{mensaje.mensajeAMostrar}}
        </div>
        {% endif %}
      {% endif %}

      {% block content %}
      {% endblock %}
    </main>

    {% include 'footer.tpl' %}
  </body>

  {% block contentFooter %}
  {% endblock %}

</html>
