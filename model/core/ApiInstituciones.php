<?php

require_once __DIR__. '/../../model/core/Api.php';
//require_once './model/core/Api.php';

/**
 * esta clase es una adaptador para consultar la api de insticiones 
 */
class ApiInstituciones extends Api
{

	function __toString(){

	}
	
	function __construct()
	{
		//en el constructor seteo a donde quiero consultar
		$this->urlApi = "https://grupo20.proyecto2018.linti.unlp.edu.ar/api/index.php/";
	}

	/**
	 * obtiene todas las instituciones 
	 * en el caso de que se pase como parametro
	 * $institucionId se obtiene la institucion deseada
	 */
	function ObtenerInstituciones($institucionId = null){
		return $this->get('instituciones'. ($institucionId == null ? "": "/".$institucionId));
	}

	/**
	 * obtiene todas las instituciones 
	 * en el caso de que se pase como parametro
	 * $institucionId se obtiene la institucion deseada
	 */
	function ObtenerInstitucionesPorRegionSanitaria($regionId){
		return $this->get('instituciones/region-sanitaria/'.$regionId);	
	}

}