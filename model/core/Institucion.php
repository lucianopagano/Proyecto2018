<?php

require_once __DIR__. '/../../model/Model.php';
require_once __DIR__. '/../../model/dtos/InstitucionDto.php';


/**
 * clase que contiene la lógica necesaria para manejar las insituciones del sistema 
 */
class Institucion extends Model
{


	function ObtenerInstituciones(){

		$query = $this->db->prepare("SELECT * FROM institucion");

		$query->execute();
		
		return $query->fetchAll(PDO::FETCH_CLASS,"InstitucionDto");

	}

	function ObtenerInstitucion($institucionId){
		$query = $this->db->prepare("SELECT * FROM institucion WHERE id= :institucionId");
		$query->bindParam(":institucionId",$institucionId,PDO::PARAM_INT);
		$query->execute();
		return $query->fetch(PDO::FETCH_CLASS,"InstitucionDto");
	}

	function ObtenerInstitucionByRegion($regionId){
		$query = $this->db->prepare("SELECT * FROM institucion WHERE region_sanitaria_id= :reqionId");
		$query->bindParam(":reqionId",$regionId,PDO::PARAM_INT);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_CLASS,"InstitucionDto");
	}

}