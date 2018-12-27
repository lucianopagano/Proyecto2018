<?php

require_once "./view/TwigView.php";

/**
 *
 */
class ConfiguracionView extends TwigView
{
	
	/*
		muestra la pagina en modo mantenimiento
	*/
	function showMantenimiento($rol = array()){

			echo self::getTwig()->render('plantilla-modo-mantenimiento.tpl',array('mantenimiento'=> true,'rolesUserSistema' => $rol));
		
		
	}
	function showIndex($rol){
		//$rol=$_SESSION['rol'];
		echo self::getTwig()->render('plantilla-principal.tpl',array('rolesUserSistema' => $rol));
	}
	function showLogIn(){
		echo self::getTwig()->render('log-in.tpl',array());
	}

	/*
		muestra el index de la configuracion
		en donde se pueden modificar los datos de la configuracion
	*/
	function index($mantenimiento,$cantidadPaginas,$titulo,$descripcion,$mail, $mensaje = null,$rol){
		//$rol=$_SESSION['rol'];
		echo self::getTwig()->render('plantilla-actualizacion-mantenimiento.tpl', array(
			'modoMantenimiento' => $mantenimiento,
			'mensaje'=> $mensaje,
			'titulo'=> $titulo,
			'descripcion' => $descripcion,
			'mail' => $mail,
			'cantPaginas'=> $cantidadPaginas,
			'rolesUserSistema' => $rol)
		);
	}
}