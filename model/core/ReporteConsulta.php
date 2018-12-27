<?php 

require_once "./model/Model.php";

/**
 * 
 */
class ReporteConsulta extends Model
{
	function GetCantidadesConsultaPorMotivo(){
		$query= $this->db->prepare("SELECT m.id ,COUNT(c.id) as Cantidad
							FROM consulta c
							INNER JOIN motivo_consulta m ON c.motivo_id = m.id
							GROUP BY motivo_id");

		$query->execute();

		return $query->fetchAll();
	}

	function GetCantidadesConsultaPorGenero(){

		$query= $this->db->prepare("SELECT  p.genero_id as id ,COUNT(c.id) as Cantidad
									FROM consulta c
									INNER JOIN paciente p ON c.paciente_id = p.id
									GROUP BY p.genero_id");

		$query->execute();

		return $query->fetchAll();

	}

	function GetCantidadesConsultaPorLocalidad(){

		$query= $this->db->prepare("SELECT  p.localidad_id as id ,COUNT(c.id) as Cantidad
									FROM consulta c
									INNER JOIN paciente p ON c.paciente_id = p.id
									GROUP BY p.localidad_id");

		$query->execute();

		return $query->fetchAll();

	}	


	/* COUNTS */

	function GetCantidadesConsultaPorGeneroCount(){

		$query= $this->db->prepare("SELECT count(A.id) as Cant
									FROM (SELECT
									    p.genero_id AS id,
									    COUNT(c.id) AS Cantidad
									FROM
									    consulta c
										INNER JOIN paciente p ON
									    c.paciente_id = p.id
									GROUP BY p.genero_id) A");

		$query->execute();

		//devuelvo la cantidad que esta en la primer fila de la consulta
		return $query->fetchColumn();;
	}


	function GetCantidadesConsultaPorMotivoCount(){

		$query= $this->db->prepare("SELECT
									    COUNT(A.id) as Cant
									FROM
									    (
									    SELECT
									        m.id,
									        COUNT(c.id) AS Cantidad
									    FROM
									        consulta c
									    INNER JOIN motivo_consulta m ON
									        c.motivo_id = m.id
									    GROUP BY
									        motivo_id
									) A");

		$query->execute();

		//devuelvo la cantidad que esta en la primer fila de la consulta
		return $query->fetchColumn();;
	}


	function GetCantidadesConsultaPorLocalidadCount(){

		$query= $this->db->prepare("SELECT
									    COUNT(A.id) as Cant
									FROM
									    (
										SELECT  p.localidad_id as id ,COUNT(c.id) as Cantidad
										FROM consulta c
										INNER JOIN paciente p ON c.paciente_id = p.id
										GROUP BY p.localidad_id) A");

		$query->execute();

		//devuelvo la cantidad que esta en la primer fila de la consulta
		return $query->fetchColumn();;
	}


	/* Paginados */	

	function GetCantidadesConsultaPorGeneroPaginado($desde,$cantidadDePaginas){

		$query= $this->db->prepare("SELECT A.*
									FROM (SELECT
										g.nombre as Nombre,
									    COUNT(c.id) AS Cantidad,
                                      	((COUNT(c.id)* 100) / (SELECT count(id) FROM consulta)) as Porcentaje,
                                      	AVG(c.id) as Promedio
									FROM
									    consulta c
										INNER JOIN paciente p ON
									    c.paciente_id = p.id
									    INNER JOIN genero g ON g.id = p.genero_id
									GROUP BY p.genero_id) A
									LIMIT :desde, :cantidad");

		$query->bindParam(":desde",$desde,PDO::PARAM_INT);
		$query->bindParam(":cantidad",$cantidadDePaginas,PDO::PARAM_INT);


		$query->execute();

		//devuelvo la cantidad que esta en la primer fila de la consulta
		return $query->fetchAll();;
	}


	function GetCantidadesConsultaPorMotivoPaginado($desde,$cantidadDePaginas){

		$query= $this->db->prepare("SELECT A.*
									FROM (SELECT
									        m.id,
									        m.nombre as Nombre,
									        COUNT(c.id) AS Cantidad,
                                      		((COUNT(c.id)* 100) / (SELECT count(id) FROM consulta)) as Porcentaje,
                                      		AVG(c.id) as Promedio
									    FROM
									        consulta c
									    INNER JOIN motivo_consulta m ON
									        c.motivo_id = m.id
									    GROUP BY
									        motivo_id) A
									LIMIT :desde, :cantidad");

		$query->bindParam(":desde",$desde,PDO::PARAM_INT);
		$query->bindParam(":cantidad",$cantidadDePaginas,PDO::PARAM_INT);


		$query->execute();

		//devuelvo la cantidad que esta en la primer fila de la consulta
		return $query->fetchAll();;

	}


	function GetCantidadesConsultaPorLocalidadPaginado($desde,$cantidadDePaginas){

		$query= $this->db->prepare("SELECT A.*
									FROM (SELECT  p.localidad_id as id ,
											COUNT(c.id) as Cantidad,
                              				((COUNT(c.id)* 100) / (SELECT count(id) FROM consulta)) as Porcentaje,
                              				AVG(c.id) as Promedio									
											FROM consulta c
											INNER JOIN paciente p ON c.paciente_id = p.id
											GROUP BY p.localidad_id) A
									LIMIT :desde, :cantidad");

		$query->bindParam(":desde",$desde,PDO::PARAM_INT);
		$query->bindParam(":cantidad",$cantidadDePaginas,PDO::PARAM_INT);


		$query->execute();

		//devuelvo la cantidad que esta en la primer fila de la consulta
		return $query->fetchAll();;

	}



	function  GetCountConsultas(){

		$query= $this->db->prepare("SELECT COUNT(c.id) as cantidadConsultas
									FROM consulta c");

		$query->execute();
		return $query->fetchColumn();

	}

}