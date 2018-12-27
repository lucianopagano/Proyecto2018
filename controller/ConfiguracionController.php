<?php
require_once "./view/ConfiguracionView.php";
require_once "./model/core/Configuracion.php";
require_once './model/core/Usuario.php';
require_once "./helpers/funciones.php";
/**
 * este controlador es el encargado de
 * gestionar la configuracion del sitio
 */
class ConfiguracionController{

	private static $instance;

	static function getInstance(){
		if(!isset(self::$instance)){
			self::$instance= new self();
		}
		return self::$instance;
	}

	function SiModoMantenimiento(){
		$model = new Configuracion();

		if($model->getConfiguracion("mantenimiento") == true){
			return true;
		}
		return false;
	}

	function ShowMantenimiento(){
		$model = new Configuracion();
		$usuarioModel = new Usuario();
		$view = new ConfiguracionView();
		$rol=$_SESSION['rol'];

		if(isset($_SESSION['uid']) && $usuarioModel->siTieneRol($_SESSION['uid'],'administrador') == true){
			//si es rol administrador
			$this->Index();
		}
		else{
			$view->showMantenimiento($rol);
		}
	}
	
	function Index($mensaje = null){
		
		if($this->ValidarPermiso('configuracion_update')){
			$usuarioModel = new Usuario();

			// si tiene rol administrador
			
			$model = new Configuracion();
			$siMantenimiento= $model->getConfiguracion("mantenimiento");
			$cantPaginas = $model->getConfiguracion("cantidad_elementos_pagina");
			$titulo = $model->getConfiguracion("titulo");
			$desc = $model->getConfiguracion("descripcion");
			$mail = $model->getConfiguracion("mail");
			$mantenimiento = array('Si' => $siMantenimiento, 'No' => !$siMantenimiento);
			$view = new ConfiguracionView();
			$rol=$_SESSION['rol'];
			$view->index($mantenimiento,$cantPaginas,$titulo,$desc,$mail,$mensaje,$rol);
			
		}
	} 

	function Update(){

	    try {
	    		$funciones = new Funciones;
	    		$rol = $_SESSION['rol'];
				$usuarioModel = new Usuario();
				if(isset($_SESSION['uid']) &&  $funciones->validarAcceso($_SESSION, 'configuracion_update')){
					//si es rol administrador
					$model = new Configuracion();

					$mant= $_POST['mantenimiento'];


					$cantPaginas =$_POST['cantpaginas'];
					$titulo =$_POST['titulo'];
					$descripcion =$_POST['descripcion'];
					$mail =$_POST['mail'];
					$model = new Configuracion();
					$model->actualizarConfiguraciones($mant,$cantPaginas,$titulo,$descripcion,$mail);
					$mensaje = array('tipoMensaje' => '1', 
						'mensajeAMostrar'=>'La configuracion fue actualizada con éxito');
					$this->Index($mensaje);
				}
				else{
					$this->ShowMantenimiento($rol);
				}
			

		}
		catch (Exception $e) {
			//cualquier error que ocurra
			//se va a encapsular y
			//se va a mostrar en el Index un modal de error
			$mensaje = array('tipoMensaje' => '0', 
				'mensajeAMostrar'=>$e->getMessage());
		    $this->Index($mensaje);
		}
	}

	/**
	 * esta funcion valida los permisos del usuario
	 * se que no va aca pero no quiero repetir codigo
	 */
    function ValidarPermiso($permiso){

    	$funciones = new Funciones;
    	if(isset($_SESSION['uid']) && $funciones->validarAcceso($_SESSION, $permiso)){
    		return true;	
    	}

		$home = new HomeController;
        $mensaje = array('tipoMensaje' => '0', 'mensajeAMostrar'=>'Acceso inválido');

		$home->Index($mensaje);
    	return false;
    }
}
