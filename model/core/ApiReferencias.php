<?php

require_once './model/core/Api.php';

/**
 * esta clase es la encargada de la comunicación con la API de la catedra
 */
class ApiReferencias extends Api
{

	public function __construct(){
		$this->urlApi = "https://api-referencias.proyecto2018.linti.unlp.edu.ar/";
	}

	/**
	 * obtiene los partidos mediante la api de de la catedra
	 **/
	function ObtenerPartidos($id=null){	
		return $this->get('partido'. ($id == null ? "": "/".$id));
	}


	/**
	 * obtiene los partidos mediante la api de de la catedra
	 **/
	function ObtenerLocalidades($id=null){	
		return $this->get('localidad'. ($id == null ? "": "/".$id));
	}


	/**
	 * obtiene todas las localidades para un partido
	 */
	function ObtenerLocalidadesByPartido($partidoId){
		
		//recupero los datos y los retorno
		return $this->get('localidad/partido/'.$partidoId);
	}

	/**
	 * obtiene una region sanitaria de la api
	 * $id = identificador de la region sanitaria
	 */
	function ObtenerRegioSanitaria($id=null){
	
		//recupero los datos y los retorno
		return $this->get('region-sanitaria'. ($id == null ? "": "/".$id));
		
	}

	/**
	 * obtiene una ObtenerTipoDocumentos de la api
	 * $id = identificador del tipo de documento que se quiere obtener, null en caso de que se quieran todos
	 */
	function ObtenerTipoDocumentos($id=null){

		//recupero los datos y los retorno
		return $this->get('tipo-documento'. ($id == null ? "": "/".$id));
	}

	/**
	 * obtiene las obras sociales de la api 
	 * atravez de get
	 */
	function ObtenerObrasSociales($id=null){

		return $this->get('obra-social'. ($id == null ? "": "/".$id));

	}

}