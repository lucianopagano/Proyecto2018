<?php

	
/**
 * esta clase se encargar de realizar los metodos genérico para consultar apis
 */
class Api
{

	protected  $urlApi;
	
	/**
	 * invoca a la api por metodo get
	 * metodo de la api a invocar
	 */
	protected function get($metodo){
		$uri = $this->urlApi . $metodo;
		$response = \Httpful\Request::get($uri)->send();

		return $response;
	}
	

}
