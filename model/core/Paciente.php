<?php

require_once "./model/Model.php";
require_once "./helpers/Validaciones.php";
/**
 * clase que modela a un paciente
 */
class Paciente extends Model
{

	/**
	 * obtiene todos los generos de la base
	 */
	function getGeneros(){
		$query = $this->db->prepare("Select * from genero order by nombre");
		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * este realiza el alta de un paciente en el sistema
	 */
	function insert( $apellido, $nombre, $fecha_nac,
		$lugar_nac, $localidad_id, $region_sanitaria_id,
		$domicilio, $genero_id, 
		$tiene_documento, $tipo_doc_id, $numeroDocumento,
		$tel, $nro_historia_clinica,
		$nro_carpeta, $obra_social_id){


		//realizo las validaciones en el modelo
		//$this->validatePaciente($apellido,$nombre,$fecha_nac,$domicilio,$genero_id,$tiene_documento,$tipo_doc_id,
		//$numeroDocumento, $nro_historia_clinica, $nro_carpeta);


		$query = $this->db->prepare("INSERT INTO paciente 
			(apellido, nombre, fecha_nac, lugar_nac, localidad_id, region_sanitaria_id, domicilio, genero_id, tiene_documento, tipo_doc_id, numero, tel, nro_historia_clinica, nro_carpeta, obra_social_id) 
			VALUES (:apellido,:nombre,:fechaNacimiento,:lugarNac,:localidadId,:regionSanitariaId,:domicilio,:generoId,
				:tieneDocumento,:tipoDoc,:numero,:tel,:historiaClinica,:numCarpeta,:obraSocialId)");


		$query->bindParam(":apellido",$apellido,PDO::PARAM_STR);
		$query->bindParam(":nombre",$nombre,PDO::PARAM_STR);
		$query->bindParam(":fechaNacimiento",$fecha_nac,PDO::PARAM_STR);
		$query->bindParam(":lugarNac",$lugar_nac,PDO::PARAM_STR);
		$query->bindParam(":localidadId",$localidad_id,PDO::PARAM_INT);
		$query->bindParam(":regionSanitariaId",$region_sanitaria_id,PDO::PARAM_INT);
		$query->bindParam(":domicilio",$domicilio,PDO::PARAM_STR);
		$query->bindParam(":generoId",$genero_id,PDO::PARAM_INT);
		$query->bindParam(":tieneDocumento",$tiene_documento,PDO::PARAM_BOOL);

		$query->bindParam(":tipoDoc",$tipo_doc_id,PDO::PARAM_INT);
		$query->bindParam(":numero",$numeroDocumento,PDO::PARAM_INT);


		$query->bindParam(":tel",$tel,PDO::PARAM_STR);
		$query->bindParam(":historiaClinica",$nro_historia_clinica,PDO::PARAM_INT);
		$query->bindParam(":numCarpeta",$nro_carpeta,PDO::PARAM_INT);
		$query->bindParam(":obraSocialId",$obra_social_id,PDO::PARAM_INT);



		$query->execute();
	}

	/**
	 * este metodo realiza la baja logica de un paciente seteando fecha_baja al paciente
	 * $idPaciente: id del paciente a dar de baja
	 */
	function bajaLogica($idPaciente){

		//obtengo la fecha de hoy
		$date = date("y-m-d");

		$query = $this->db->prepare("UPDATE paciente SET fecha_baja=:fecha_baja WHERE id=:idPaciente");
		$query->bindParam(":idPaciente",$idPaciente);
		$query->bindParam(":fecha_baja",$date);
		$query->execute();
	}

	/**
	 * este metodo realiza la validacion de un paciente
	 */
	function validatePaciente($apellido,$nombre,$fecha_nac,$domicilio,$genero,$tiene_documento,$tipoDoc,
		$numeroDocumento, $nro_historia_clinica, $nro_carpeta){

		$mensaje = NULL;

		if(empty($apellido)){
			$mensaje .= "Debe informar apellido ";
		}

		if(empty($nombre)){
			$mensaje .= "Debe informar nombre ";
		}

		if(empty($fecha_nac)){
			$mensaje .= "Debe informar fecha de nacimiento\n";
		}
		//elseif(!Validaciones::EsFecha($fecha_nac,'d/m/Y')){
		//	$mensaje .= "Formato de fecha de nacimiento inválido (dd/mm/YY)\r";
		//}

		if(empty($domicilio)){
			$mensaje .= "Debe informar domicilio \n";
		}

		if(empty($genero)){
			$mensaje .= "Debe informar genero \n";
		}


		if(!empty($nro_historia_clinica)){
			
			if(!Validaciones::EsEntero($nro_historia_clinica)){
				$mensaje .= "Número de historia clínica debe ser entero\n";
			}
			elseif ($nro_historia_clinica > 999999) {
				$mensaje .= "Número de historia clínica debe contener hasta 6 cifras\n";
			}
		}

		if(!empty($nro_carpeta)){
			
			if(!Validaciones::EsEntero($nro_carpeta)){
				$mensaje .= "Número de carpeta debe ser entero\n";
			}
			elseif ($nro_carpeta > 99999) {
				$mensaje .= "Número de carpeta debe contener hasta 5 cifras\n";
			}
		}

		if(isset($mensaje)){
			throw new Exception($mensaje, 20);
		}
	}

	/**
	 * este metodo obtiene los pacientes paginados
	 * $cantidad: la cantidad de registros que se quiere obtener
	 * $desde: desde donde se quieren obtener los registros
	 */
	function obtenerPacientesPaginado($filaDesde,$cantidad,$generoId,$apellido,$nombre,$documento,$tipoDoc,$numHistClinica){
		//$cantidad es la cantidad de paginas que se quiere listar
		$stringConsulta= "SELECT * FROM paciente WHERE fecha_baja IS NULL";

		if($generoId != null){
			$stringConsulta .= " AND genero_id =:generoId";
		}
		if($apellido != null){
			$stringConsulta .= " AND apellido =:apellido";
		}

		if($nombre != null){
			$stringConsulta .= " AND nombre =:nombre";
		}

		if($documento != null){
			$stringConsulta .= " AND numero =:documento";
		}

		if($tipoDoc != null){
			$stringConsulta .= " AND tipo_doc_id =:tipoDoc";
		}

		if($numHistClinica != null){
			$stringConsulta .= " AND nro_historia_clinica =:numHistClinica";
		}


		//concateno los limites
		$stringConsulta .= " LIMIT :desde, :cantidad";


		$query= $this->db->prepare($stringConsulta);
		$query->bindParam(":desde",$filaDesde,PDO::PARAM_INT);
		$query->bindParam(":cantidad",$cantidad,PDO::PARAM_INT);

		if($generoId != null){
			$query->bindParam(":generoId",$generoId,PDO::PARAM_INT);
		}

		if($apellido != null){
			$query->bindParam(":apellido",$apellido,PDO::PARAM_STR);
		}

		if($nombre != null){
			$query->bindParam(":nombre",$nombre,PDO::PARAM_STR);
		}

		if($documento != null){
			$query->bindParam(":documento",$documento,PDO::PARAM_INT);
		}

		if($tipoDoc != null){
			$query->bindParam(":tipoDoc",$tipoDoc,PDO::PARAM_INT);
		}

		if($numHistClinica != null){
			$query->bindParam(":numHistClinica",$numHistClinica,PDO::PARAM_INT);
		}

		$query->execute();

		return $query->fetchAll();
	}

	function cantidadPacientes($generoId,$apellido,$nombre,$documento,$tipoDoc,$numHistClinica){
		$stringConsulta= "SELECT COUNT(id) as cant FROM paciente WHERE fecha_baja IS NULL";

		if($generoId != null){
			$stringConsulta .= " AND genero_id =:generoId";
		}
		if($apellido != null){
			$stringConsulta .= " AND apellido =:apellido";
		}

		if($nombre != null){
			$stringConsulta .= " AND nombre =:nombre";
		}

		if($documento != null){
			$stringConsulta .= " AND numero =:documento";
		}

		if($tipoDoc != null){
			$stringConsulta .= " AND tipo_doc_id =:tipoDoc";
		}

		if($numHistClinica != null){
			$stringConsulta .= " AND nro_historia_clinica =:numHistClinica";
		}		


		$query = $this->db->prepare($stringConsulta);

		if($generoId != null){
			$query->bindParam(":generoId",$generoId,PDO::PARAM_INT);
		}

		if($apellido != null){
			$query->bindParam(":apellido",$apellido,PDO::PARAM_STR);
		}

		if($nombre != null){
			$query->bindParam(":nombre",$nombre,PDO::PARAM_STR);
		}

		if($documento != null){
			$query->bindParam(":documento",$documento,PDO::PARAM_INT);
		}

		if($tipoDoc != null){
			$query->bindParam(":tipoDoc",$tipoDoc,PDO::PARAM_INT);
		}

		if($numHistClinica != null){
			$query->bindParam(":numHistClinica",$numHistClinica,PDO::PARAM_INT);
		}



		$query->execute();

		//devuelvo la cantidad que esta en la primer fila de la consulta
		return $query->fetchColumn();
	}

	function obtenerPacientePorId($id){

		$query = $this->db->prepare("select p.*,g.nombre as 'genero' from paciente p inner join genero g on p.genero_id= g.id  where p.id = :id and fecha_baja IS NULL");
		$query->bindParam(":id",$id,PDO::PARAM_INT);
		$query->execute();
		return $query->fetch();
	}


	function update($id,$apellido, $nombre, $fecha_nac,
		$lugar_nac, $localidad_id, $region_sanitaria_id,
		$domicilio, $genero_id, 
		$tiene_documento, $tipo_doc_id, $numeroDocumento,
		$tel, $nro_historia_clinica,
		$nro_carpeta, $obra_social_id){


		$query= $this->db->prepare("UPDATE paciente SET apellido=:apellido ,nombre=:nombre ,fecha_nac=:fecha_nac ,lugar_nac=:lugar_nac , 
			localidad_id=:localidad_id, region_sanitaria_id=:region_sanitaria_id ,domicilio=:domicilio ,genero_id=:genero_id, tiene_documento=:tiene_documento ,
			tipo_doc_id=:tipo_doc_id ,numero=:numero ,tel=:tel ,nro_carpeta=:nro_carpeta ,obra_social_id=:obra_social_id 
			WHERE id = :id");



		$query->bindParam(":apellido",$apellido,PDO::PARAM_STR);
		$query->bindParam(":nombre",$nombre,PDO::PARAM_STR);
		$query->bindParam(":fecha_nac",$fecha_nac,PDO::PARAM_STR);
		$query->bindParam(":lugar_nac",$lugar_nac,PDO::PARAM_STR);
		$query->bindParam(":localidad_id",$localidad_id,PDO::PARAM_INT);
		$query->bindParam(":region_sanitaria_id",$region_sanitaria_id,PDO::PARAM_INT);
		$query->bindParam(":domicilio",$domicilio,PDO::PARAM_STR);
		$query->bindParam(":genero_id",$genero_id,PDO::PARAM_INT);
		$query->bindParam(":tiene_documento",$tiene_documento,PDO::PARAM_BOOL);

		$query->bindParam(":tipo_doc_id",$tipo_doc_id,PDO::PARAM_INT);
		$query->bindParam(":numero",$numeroDocumento,PDO::PARAM_INT);


		$query->bindParam(":tel",$tel,PDO::PARAM_STR);
		$query->bindParam(":nro_carpeta",$nro_carpeta,PDO::PARAM_INT);
		$query->bindParam(":obra_social_id",$obra_social_id,PDO::PARAM_INT);
		$query->bindParam(":id",$id,PDO::PARAM_INT);
		$query->execute();
	}
	function buscarPaciente($parametro){
		try{

			$query = $this->db->prepare('SELECT * FROM paciente p WHERE p.apellido LIKE :search');

			$query->execute(array(':search' => '%'.$parametro.'%'));

			if($query->rowCount() != 0){
				while ($usuario =$query->fetchObject()){
					$response[] = array("value"=>$usuario->id,"label"=>$usuario->apellido);
				}

				return $response;
			}
			else{
				return null;
			}
		}
		catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
	
	public function getPacienteById($id)
  {
     /*$query = $this->db->prepare("SELECT u.username, u.first_name, u.last_name, u.activo, u.password,
       u.email, u.id, r.nombre as	roles, r.id as rId FROM usuario u INNER JOIN usuario_tiene_rol ur ON u.id=ur.usuario_id
                       INNER JOIN rol r ON r.id=ur.rol_id WHERE u.id=?");*/
      $query = $this->db->prepare("SELECT * FROM paciente u WHERE u.id=?");

     $query->execute(array($id));
     $usuarioAll=$query->fetchObject();

     return $usuarioAll;
  }
}