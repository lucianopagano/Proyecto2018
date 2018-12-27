<?php

require_once "./model/Model.php";

/**
 * clase encargada de manejar el modulo de configuracion
 * del sistema
 **/
class Configuracion extends Model
{

	/**
	* obtiene la configuracion especificada en $variable
	**/
	public function getConfiguracion($variable){

		$query = $this->db->prepare("SELECT valor FROM configuracion WHERE variable = :var");
		$query->bindParam(":var",$variable);
		$query->execute();

		return $query->fetchColumn(0);
	}

	/**
	* actualiza toda la configuracion de la pagina
	**/
	public function actualizarConfiguraciones($mant,$cantPaginas,$titulo,$descripcion,$mail)
	{

		//valido cantida de paginas
		if(!filter_var($cantPaginas,FILTER_VALIDATE_INT)){
			throw new Exception('Cantidad de páginas por listado debe ser numerico');
		}
		//valido mail
		if(!filter_var($mail,FILTER_VALIDATE_EMAIL)){
			throw new Exception('Formato de mail incorrecto');
		}

		
		$this->update("mantenimiento",$mant);
		$this->update("cantidad_elementos_pagina",$cantPaginas);
		$this->update("titulo",$titulo);
		$this->update("descripcion",$descripcion);
		$this->update("mail",$mail);		
	}

	/**
	* actualiza la variable $varliable
	* con el valor $valor
	**/
	public function update($variable,$valor){

		$query = $this->db->prepare("UPDATE configuracion SET valor= :valor WHERE variable = :variable");
		$query->bindParam(':valor',$valor);
		$query->bindParam(':variable',$variable);
		$query->execute();
	}
}
