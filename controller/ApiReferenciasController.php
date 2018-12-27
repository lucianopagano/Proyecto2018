<?php
require_once './model/core/ApiReferencias.php';


/**
 * Este controlador es el encargado de manejar los llamados a la api de referencias de la catedra
 */
class ApiReferenciasController
{
	
	/**
	 * Obtiene los todos los partidos de la api
	 */
	function GetPartidos(){

		try {
			$partidos = new ApiReferencias;


			$id = !isset($_GET["partidoId"])? null : $_GET["partidoId"];

			if($id != null){
				//valido que el id del documento sea int
				if (!filter_var($id, FILTER_VALIDATE_INT)) {
				    throw new Exception("El parametro partidoId debe ser entero", 400);
				}
			}

			$jsonPartidos = $partidos->ObtenerPartidos();
			echo $jsonPartidos;
		} catch (Exception $e) {
			$this->SendError($e->getMessage(), $e->getCode());
		}
	}


	function GetLocalidades(){

		try {
			$api = new ApiReferencias;


			$id = !isset($_GET["localidadId"])? null : $_GET["localidadId"];

			if($id != null){
				//valido que el id del documento sea int
				if (!filter_var($id, FILTER_VALIDATE_INT)) {
				    throw new Exception("El parametro localidadId debe ser entero", 400);
				}
			}

			$json = $api->ObtenerLocalidades($id);
			echo $json;
		} catch (Exception $e) {
			$this->SendError($e->getMessage(), $e->getCode());
		}
	}

	/**
	 * Obtiene las localidades de un partido
	 */
	function GetLocalidadesByPartido(){
		try {

			$partido = $_GET['partido'];

			//valido que el id del Partido sea int
			if (!filter_var($partido, FILTER_VALIDATE_INT)) {
			    throw new Exception("El parametro partido debe ser entero", 400);
			}


			$api = new ApiReferencias;
			$jsonPartidos = $api->ObtenerLocalidadesByPartido($partido);
			echo $jsonPartidos;
			
		} catch (Exception $e) {
			$this->SendError($e->getMessage(), $e->getCode());
		}
	}

	/**
	 * Obtiene una region sanitaria 
	 */
	function GetRegionSanitaria(){
		try {

			$id = !isset($_GET["region"])? null : $_GET["region"];

			if($id != null){
				//valido que el id del documento sea int
				if (!filter_var($id, FILTER_VALIDATE_INT)) {
				    throw new Exception("El parametro region debe ser entero", 400);
				}
			}


			$api = new ApiReferencias;
			$jsonPartidos = $api->ObtenerRegioSanitaria($id);
			echo $jsonPartidos;
			
		} catch (Exception $e) {
			$this->SendError($e->getMessage(), $e->getCode());
		}
	}

	/**
	 * Obtiene todas las obras sociales
	 */	
	function GetObrasSociales(){
		try {

			$id = !isset($_GET["obraSocial"])? null : $_GET["obraSocial"];

			if($id != null){
				//valido que el id del documento sea int
				if (!filter_var($id, FILTER_VALIDATE_INT)) {
				    throw new Exception("El parametro obraSocial debe ser entero", 400);
				}
			}


			$api = new ApiReferencias;
			$jsonPartidos = $api->ObtenerObrasSociales($id);
			echo $jsonPartidos;
			
		} catch (Exception $e) {
			$this->SendError($e->getMessage(), $e->getCode());
		}
	}

	/**
	 * obtiene los tipo de documentos o un tipo de documento 
	 * que se pase como parametro por get
	 */	
	function GetTipoDocumentos(){

		try {

			$api = new ApiReferencias;
			$tipoDocumento = !isset($_GET["tipoDocumento"])? null : $_GET["tipoDocumento"];

			if($tipoDocumento != null){
				//valido que el id del documento sea int
				if (!filter_var($tipoDocumento, FILTER_VALIDATE_INT)) {
				    throw new Exception("El parametro tipo documento debe ser entero", 400);
				}
			}

			$jsonPartidos = $api->ObtenerTipoDocumentos($tipoDocumento);
			echo $jsonPartidos;
			
		} catch (Exception $e) {
			$this->SendError($e->getMessage(), $e->getCode());
		}
	}


	/**
	 * Este metodo envia un error
	 * seteando la cabecera 
	 * $mensaje: mensaje de error
	 * $tipoError: tipo de error a mandar
	 */
	function SendError($mensaje,$tipoError){
		header('HTTP/1.1 '.$tipoError.' '.$mensaje, true, $tipoError);
		//todo enviar bad requeret
		echo json_encode($mensaje);
	}

}