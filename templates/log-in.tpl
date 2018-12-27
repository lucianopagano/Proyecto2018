<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="./css/main2.css">
	<link rel="stylesheet" type="text/css" href="./css/logIn.css">
	<title>Ingresar</title>
</head>
<body>
	<div class="login-container default-box">
		{% if(tipo != null) %}
		<div class="alert">
  			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
 			{{mensaje}}
		</div>
		{% endif %}
		<form method="post" action="./index.php?ctl=login">
			<h2 class="title">Ingresar</h2>
		  <div class="imgcontainer">
		    <img src="./img/img_avatar2.png" alt="Avatar" class="avatar">
		  </div>
		  <div class="container">
		    <label for="usuario"><b>Nombre de Usuario</b></label>
		    <input type="text" placeholder="Ingrese nombre de Usuario" name="usuario" required>

		    <label for="pass"><b>Contraseña</b></label>
		    <input type="password" placeholder="Ingrese contraseña" name="pass" required>

		    <button type="submit">Ingresa</button>
		    <label>
		      <input type="checkbox" checked="checked" name="remember"> Remember me
		    </label>
		  </div>
		</form>
	</div>
</body>
</html>
