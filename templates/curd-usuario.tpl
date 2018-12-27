{% extends "plantilla-principal.tpl" %}

{% block content %}
        <div class="content">
          <h1>Formulario de Usuarios</h1>
            <div class="formularioAltaUsuario">
                <form name="altaAltaUsuario" action="index.php?ctl={{accion}}" method="POST" accept-charset="utf-8">
                  <input type="text" id="id" name="id" value="{{usuario.usuario_id}}" hidden></li>
                    <fieldset>
                        <legend>{{titulo}}</legend>
                        <ul>
                           <li class="required"><label for="nombre">Nombre:</label>
                           <input type="text" id="nombre" name="nombre"   value="{{usuario.last_name}}" placeholder="Nombre del Usuario" required></li>

                           <li class="required"><label for="apellido">Apellido:</label>
                           <input type="text" id="apellido" name="apellido"  value="{{usuario.first_name}}" placeholder="Apellido del Usuario" required></li>

                           <li class="required"><label for="usuario">Usuario:</label>
                           <input type="text" id="usuario" name="usuario"  value="{{usuario.username}}" placeholder="Usuario" required></li>

                           <li class="required"><label for="password">Password:</label>
                           <input type="password" id="password" name="password"   value="{{usuario.password}}"placeholder="Password" required></li>
                           <li class="required"><label for="email">E-mail:</label>
                           <input type="email" id="email" name="email"   value="{{usuario.email}}" placeholder="Email" required></li>
                           <li>
                            {% if usuario.activo == 1 %}
                            <label class="form-check-label" for="inlineCheckbox1">Activo:</label>
                            <div class="form-check form-check-inline">
                                <input name="activo"  type="checkbox" id="{{usuario.usuario_id}}" value="activado" checked>

                                <label class="form-check-label" for="inlineCheckbox1"></label>
                              </div>
                            {%else%}
                            <label class="form-check-label" for="inlineCheckbox1">Activo:</label>
                            <div class="form-check form-check-inline">
                                <input name="activo"  type="checkbox" id="{{usuario.usuario_id}}" value="activar">

                                <label class="form-check-label" for="inlineCheckbox1"></label>
                              </div>
                               {%endif%}   
                           </li>
                           <li>
                             <div>
                             <label class="form-check-label" for="inlineCheckbox1">Roles:</label>
                           </div>
                             <br>
                             {% for items in roles %}
                             
                                   <div class="form-check form-check-inline">
                                      <input name="check-[]"  type="checkbox" id="{{items.id}}" value="{{items.id}}" checked>
                                      <label class="form-check-label" for="inlineCheckbox1"> {{items.nombre}}</label>
                                    </div>


                             {% endfor %}
                             {% for items in allRoles %}
                             <div class="form-check form-check-inline">
                                <input name="check-[]"  type="checkbox" id="{{items.id}}" value="{{items.id}}">
                                <label class="form-check-label" for="inlineCheckbox1">{{items.nombre}}</label>
                              </div>

                             {% endfor %}

                           </li>
                           
                           {% if accion == "viewUsuarios" %}
                              <div class="td_botones">
                                <a href="index.php?ctl=listUsuarios"><img src="imagenes/volver.png" alt="Volver" title="Volver"></a>
                              
                              </div>
                            {%else%}
                              
                              <li><input class="btnAltaUsuario" type="submit" value="Guardar"></li>
                              <li><a href="index.php?ctl=listUsuarios"><img src="imagenes/volver.png" alt="Volver" title="Volver"></a></li>

                              </li>
                             {%endif%}   
                          </ul>

                    </fieldset>
                </form>
            </div>

        </div>

    </main>
{% endblock %}
