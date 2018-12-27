<?php
require_once './view/PacienteView.php';
require_once './controller/HomeController.php';
require_once './model/core/Paciente.php';
require_once './model/core/Configuracion.php';
require_once './model/core/ApiReferencias.php';
require_once "./helpers/funciones.php";

/**
 * esta clase modela el controlador de paciente
 */
class PacienteController
{
	function Index($mensaje= null){

		if($this->ValidarPermiso('paciente_index')){
			$pacientemModel = new Paciente();
			$generos = $pacientemModel->getGeneros();
			$pacienteView = new PacienteView();
			$pacienteView->Index($generos,null,$mensaje);
		}
	}

	/**
	 * Este metodo invca al model de paciente para agregarlo
	 */
	function AgregarPaciente(){

		if($this->ValidarPermiso('paciente_new')){
			try {

				$apellido= $_POST['Apellido'];
				$nombre= $_POST['Nombre'];
				$genero_id= $_POST['Genero'];
				$fecha_nac =$_POST['FechaNacimiento'];
				$lugar_nac = !isset($_POST['LugarNacimiento']) ? null : $_POST['LugarNacimiento'];;
				$localidad_id = !isset($_POST['Localidad']) ? null : $_POST['Localidad'];
				$region_sanitaria_id = !isset($_POST['RegionSanitaria']) || empty($_POST['RegionSanitaria']) ? null : $_POST['RegionSanitaria'];
				$domicilio =$_POST['Domicilio'];
				$tiene_documento = !isset($_POST['SiTienDocumento']) ? false : $_POST['SiTienDocumento'];
				$tipo_doc_id =$_POST['TipoDocumento'];
				$numero =$_POST['NumDocumento'];
				$nro_historia_clinica =$_POST['NumHistoriaClinica'];
				$nro_carpeta =$_POST['NumCarpeta'];
				$tel =$_POST['Tel'];
				$obra_social_id = !isset($_POST['ObraSocial']) || empty($_POST['ObraSocial']) ? null : $_POST['ObraSocial'];


				//creo el objeto paciente
				$paciente = new Paciente;

				//invoco al metodo que crea al paciente
				$paciente->insert( $apellido, $nombre, $fecha_nac,
						 $lugar_nac, $localidad_id, $region_sanitaria_id,
						 $domicilio, $genero_id, 
						 $tiene_documento, $tipo_doc_id, $numero,
						 $tel, $nro_historia_clinica,
						 $nro_carpeta, $obra_social_id);

				$mensaje = array('tipoMensaje' => 1, 'mensajeAMostrar'=> "El Paciente fue agregado con éxito");
				$this->ShowListadoPaciente($mensaje);
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
	}

	function ShowListadoPaciente($mensaje=null){

		if($this->ValidarPermiso('paciente_index')){

			$pacienteView = new PacienteView();

			$funciones = new Funciones();

			$pacienteModel = new Paciente;
			$generos = $pacienteModel->getGeneros();

			try {

				$generoId = null;
				$apellido = null;
				$nombre = null;
				$documento = null;
				$tipoDoc = null;
				$numHistClinica = null;


				$siHabilitadoDetalle =  $funciones->validarAcceso($_SESSION,'paciente_show');
				$siHabilitadoActualizacion=  $funciones->validarAcceso($_SESSION,'paciente_update');
				$siHabilitadoBaja =  $funciones->validarAcceso($_SESSION,'paciente_destroy');


				if(isset($_POST["nombre"])){
					$nombre =$_POST["nombre"];
				}
				elseif (isset($_GET["nombre"]) ) {
					$nombre =$_GET["nombre"];
				}

				if(isset($_POST["apellido"])){
					$apellido =$_POST["apellido"];
				}
				elseif (isset($_GET["apellido"])){
					$apellido =$_GET["apellido"];
				}

				if(isset($_POST["genero"])){

					$generoId =$_POST["genero"];
				}
				elseif (isset($_GET["genero"])) {
					$generoId =$_GET["genero"];
				}

				if(isset($_POST["numHistClinica"])){
					$numHistClinica =$_POST["numHistClinica"];
				}
				elseif (isset($_GET["numHistClinica"])) {
					$numHistClinica =$_GET["numHistClinica"];
				}


				if(isset($_POST["numeroDocumento"])){
					$documento =$_POST["numeroDocumento"];
				}
				elseif (isset($_GET["numeroDocumento"])) {
					$documento =$_GET["numeroDocumento"];
				}



				//pagina actual del listado
				//por defecto esta en uno 
				$pagina = 1;
				if (isset($_GET["pagina"])) {
					$pagina = $_GET["pagina"];
				}


				
				//obtengo cantidad de paginas a listar desde la configuracion
				$conf = new Configuracion;
				$cantidadRegistrosPorListado = $conf->getConfiguracion("cantidad_elementos_pagina");

				
				//obtengo la cantidad de pacientes que hay en el la base
				$cantidadPacientes = $pacienteModel->cantidadPacientes($generoId,$apellido,$nombre,$documento,$tipoDoc,$numHistClinica);

				//obtengo los pacientes con fila desde que es pagina -1 
				//con esto obtengo el rango
				$desde = ($pagina -1)* $cantidadRegistrosPorListado;


				$pacientes = $pacienteModel->obtenerPacientesPaginado($desde,$cantidadRegistrosPorListado,$generoId,$apellido,$nombre,$documento,
					$tipoDoc,$numHistClinica);
				
				//ceil redondea fracciones hacia arriba
				$total_paginas=ceil($cantidadPacientes/$cantidadRegistrosPorListado);

				$pacienteView->ShowListadoPaciente($mensaje,$cantidadPacientes,$total_paginas,
					$cantidadRegistrosPorListado,$pagina,$pacientes,$generos,$generoId,$nombre,$apellido,$numHistClinica,$documento,
					$siHabilitadoDetalle,$siHabilitadoActualizacion,$siHabilitadoBaja);
				
			} 
			catch (Exception $e) {
				$mensaje = array('tipoMensaje' => 0, 'mensajeAMostrar'=> $e->getMessage());
				$pacienteView->ShowListadoPaciente($mensaje,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
			}
		}
	}

	function EliminarPaciente(){

		if ($this->ValidarPermiso('paciente_destroy')) {
			try {

				if(!isset($_POST["PacienteId"])){
					throw new Exception("Error en los parametros", 400);
				}
				$pacienteId = $_POST["PacienteId"];
				$pacienteModel = new Paciente;
				$pacienteModel->bajaLogica($pacienteId);

				$mensaje = array('tipoMensaje' => '1', 
					'mensajeAMostrar'=>"Paciente dado de baja con éxito");
				$this->ShowListadoPaciente($mensaje);

			}
			catch (Exception $e) {
				//cualquier error que ocurra
				//se va a encapsular y
				//se va a mostrar en el Index un modal de error
				$mensaje = array('tipoMensaje' => '0', 
					'mensajeAMostrar'=>$e->getMessage());
			    $this->ShowListadoPaciente($mensaje);
			}
		}
	}

	function DetallePaciente(){
		if ($this->ValidarPermiso('paciente_show')) {
			try {

				
				if ( isset($_GET["pacienteId"]) && filter_var($_GET["pacienteId"], FILTER_VALIDATE_INT)) {
					$pacienteId =$_GET["pacienteId"];
				}
				else{
					throw new Exception("Error en parametros", 400);
				}

				$pacienteModel = new Paciente;
				$p= $pacienteModel->obtenerPacientePorId($pacienteId);


				if($p == null){
					//si no encontro el paciente en la base
					throw new Exception("El paciente no existe");
				}

				$api = new ApiReferencias;

				//obtengo el tiepo de documento de la api y lo decodifico de formato json
				$tipoDoc = json_decode($api->ObtenerTipoDocumentos($p["tipo_doc_id"])) ;
				$p['tipoDoc'] = $tipoDoc->{'nombre'};

				if($p["localidad_id"] != null){
					//obtengo el tiepo de documento de la api y lo decodifico de formato json
					$localidad = json_decode($api->ObtenerLocalidades($p["localidad_id"])) ;
					$p['localidad'] = $localidad->{'nombre'};
				}

				

				if($p["localidad_id"] != null){
					$partido = json_decode($api->ObtenerLocalidades($localidad->{'partido_id'})) ;
					$p['partido'] = $partido->{'nombre'};
				}

				if($p["region_sanitaria_id"] != null){
					//obtengo el tiepo de documento de la api y lo decodifico de formato json
					$region = json_decode($api->ObtenerRegioSanitaria($p["region_sanitaria_id"])) ;
					$p['region'] = $region->{'nombre'};

				}

				if($p["obra_social_id"] != null){
					//obtengo el tiepo de documento de la api y lo decodifico de formato json
					$obra = json_decode($api->ObtenerObrasSociales($p["obra_social_id"])) ;
					$p['obra'] = $obra->{'nombre'};

				}

				$pacienteView = new PacienteView;
				$pacienteView->ShowPaciente($p);
			}
			catch (Exception $e) {
				//cualquier error que ocurra
				//se va a encapsular y
				//se va a mostrar en el Index un modal de error
				$mensaje = array('tipoMensaje' => '0', 
					'mensajeAMostrar'=>$e->getMessage());
			    $this->ShowListadoPaciente($mensaje);
			}
		}	
	}


	/**
	* Este metodo muestra la actualizacion del paciente
	**/
	function ShowActualizarPaciente(){

		
        try {
            if (isset($_GET["pacienteId"]) && filter_var($_GET["pacienteId"], FILTER_VALIDATE_INT)) {
                $pacienteId =$_GET["pacienteId"];
            }
            else{
                throw new Exception("Error en parametros", 400);
            }


			$pacienteModel = new Paciente;
			//obtengo el paciente por su id
			$p= $pacienteModel->obtenerPacientePorId($pacienteId);


			if($p == null){
				//si no encontro el paciente en la base
				throw new Exception("El paciente no existe");
			}

			$generos = $pacienteModel->getGeneros();

			$pacienteView = new PacienteView();


			$pacienteView->Index($generos,$p);

        }
        catch (Exception $e) {
            //cualquier error que ocurra
            //se va a encapsular y
            //se va a mostrar en el Index un modal de error
            $mensaje = array('tipoMensaje' => '0', 
                'mensajeAMostrar'=>$e->getMessage());
            $this->Index($mensaje,null);
        }    		
	}

	function ActualizarPaciente(){

		if ($this->ValidarPermiso('paciente_update')) {
	        try {

	            if ( isset($_POST["id"]) && filter_var($_POST["id"], FILTER_VALIDATE_INT)) {
	                $pacienteId =$_POST["id"];
	            }
	            else{
	                throw new Exception("Error en parametros", 400);
	            }

	            $apellido= $_POST['Apellido'];
	            $nombre= $_POST['Nombre'];
	            $genero_id= $_POST['Genero'];
	            $fecha_nac =$_POST['FechaNacimiento'];
	            $lugar_nac =$_POST['LugarNacimiento'];
	            $localidad_id = !isset($_POST['Localidad']) ? null : $_POST['Localidad'];
	            $region_sanitaria_id =$_POST['RegionSanitaria'];
	            $domicilio =$_POST['Domicilio'];
	            $tiene_documento = !isset($_POST['SiTienDocumento']) ? false : $_POST['SiTienDocumento'];
	            $tipo_doc_id =$_POST['TipoDocumento'];
	            $numero =$_POST['NumDocumento'];
	            $nro_historia_clinica =$_POST['NumHistoriaClinica'];
	            $nro_carpeta =  !isset($_POST['NumCarpeta']) ? null : $_POST['NumCarpeta'];
	            $tel = !isset($_POST['Tel']) ? null : $_POST['Tel'];
	            $obra_social_id =  !isset($_POST['ObraSocial']) ? null : $_POST['ObraSocial'];


	            //creo el objeto paciente
	            $paciente = new Paciente;

	            //invoco al metodo que crea al paciente
	            $paciente->update($pacienteId, $apellido, $nombre, $fecha_nac,
	                     $lugar_nac, $localidad_id, $region_sanitaria_id,
	                     $domicilio, $genero_id, 
	                     $tiene_documento, $tipo_doc_id, $numero,
	                     $tel, $nro_historia_clinica,
	                     $nro_carpeta, $obra_social_id);

	            $mensaje = array('tipoMensaje' => 1, 'mensajeAMostrar'=> "El Paciente fue agregado con éxito");
	            $this->ShowListadoPaciente($mensaje);
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