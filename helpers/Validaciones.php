<?php

/**
 * esta clase es un utilitario para realizar validaciones
 */
class Validaciones
{
	
	/**
	 * este metodo valida una fehca en algun formato seleccionado
	 * $date fecha a validar
	 * $format formato por el cual se quiere validar
	 * null formato por defecto
	 */
	static function EsFecha($date, $format = 'd/m/Y H:i:s')
	{
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}

	/**
	 * valida si $enteroAValidar es del formato integer
	 */
	static function EsEntero($enteroAValidar){
		return filter_var($enteroAValidar, FILTER_VALIDATE_INT);
	}

}