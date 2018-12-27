<?php 

require_once './model/core/ReporteConsulta.php';
require_once './view/ReporteConsultaView.php';
require_once './model/core/Configuracion.php';
require_once './model/core/ApiReferencias.php';
require_once './controller/HomeController.php';

/**
 * este controlador es el encargado de manejar el listado de consultas
 */
class ReporteConsultaController
{

	

	function ShowConsultasMotivo(){

		if ($this->ValidarPermiso('reporte_motivo_show')) {
			//pagina actual del listado
			//por defecto esta en uno 
			$pagina = 1;
			if (isset($_GET["pagina"])) {
				$pagina = $_GET["pagina"];
			}


		    $viewConsulta = new ReporteConsultaView;

			$reporteModel = new ReporteConsulta;


			$conf = new Configuracion;
			$cantidadRegistrosPorListado = $conf->getConfiguracion("cantidad_elementos_pagina");


			$cantidadDatos = $reporteModel->GetCantidadesConsultaPorMotivoCount();


			$desde = ($pagina -1)* $cantidadRegistrosPorListado;


			$datos = $reporteModel->GetCantidadesConsultaPorMotivoPaginado($desde,$cantidadRegistrosPorListado);
			
			//ceil redondea fracciones hacia arriba
			$total_paginas=ceil($cantidadDatos/$cantidadRegistrosPorListado);

		    $viewConsulta->ShowConsultasMotivo($cantidadDatos,$total_paginas,$cantidadRegistrosPorListado,$pagina,$datos);
		}
	}

	function ShowConsultasLocalidad(){


		if ($this->ValidarPermiso('reporte_genero_show')) {

			//pagina actual del listado
			//por defecto esta en uno 
			$pagina = 1;
			if (isset($_GET["pagina"])) {
				$pagina = $_GET["pagina"];
			}


		    $viewConsulta = new ReporteConsultaView;

			$reporteModel = new ReporteConsulta;


			$conf = new Configuracion;
			$cantidadRegistrosPorListado = $conf->getConfiguracion("cantidad_elementos_pagina");


			$cantidadDatos = $reporteModel->GetCantidadesConsultaPorLocalidadCount();


			$desde = ($pagina -1)* $cantidadRegistrosPorListado;


			$locs = $reporteModel->GetCantidadesConsultaPorLocalidadPaginado($desde,$cantidadRegistrosPorListado);


			$api = new ApiReferencias;

			//var_dump($datos);

			$datos = array();

			foreach ($locs as $key => $value) {

				if(isset($value["id"])){

					//obtengo la localidad de la api y lo decodifico de formato json
					$localidad = json_decode($api->ObtenerLocalidades($value["id"])) ;
					$localidad->{'nombre'};

					$arrayName = array(	'Cantidad' => $value['Cantidad'],
										'Promedio'=> $value['Promedio'],
										'Porcentaje'=> $value['Porcentaje'],
										'Nombre'=> $localidad->{'nombre'});

					array_push($datos, $arrayName);
				}
				else {
					$arrayName = array(	'Cantidad' => $value['Cantidad'],
										'Promedio'=> $value['Promedio'],
										'Porcentaje'=> $value['Porcentaje'],
										'Nombre'=> "Sin Localidad");
					array_push($datos, $arrayName);
				}

			}



			//ceil redondea fracciones hacia arriba
			$total_paginas=ceil($cantidadDatos/$cantidadRegistrosPorListado);

		    $viewConsulta->ShowConsultasLocalidad($cantidadDatos,$total_paginas,$cantidadRegistrosPorListado,$pagina,$datos);
		}
	}

	function ShowConsultaGenero(){

		if ($this->ValidarPermiso('reporte_localidad_show')) {

			//pagina actual del listado
			//por defecto esta en uno 
			$pagina = 1;
			if (isset($_GET["pagina"])) {
				$pagina = $_GET["pagina"];
			}


		    $viewConsulta = new ReporteConsultaView;

			$reporteModel = new ReporteConsulta;


			$conf = new Configuracion;
			$cantidadRegistrosPorListado = $conf->getConfiguracion("cantidad_elementos_pagina");


			$cantidadDatos = $reporteModel->GetCantidadesConsultaPorGeneroCount();


			$desde = ($pagina -1)* $cantidadRegistrosPorListado;


			$datos = $reporteModel->GetCantidadesConsultaPorGeneroPaginado($desde,$cantidadRegistrosPorListado);
			
			//ceil redondea fracciones hacia arriba
			$total_paginas=ceil($cantidadDatos/$cantidadRegistrosPorListado);

		    $viewConsulta->ShowConsultasGenero($cantidadDatos,$total_paginas,$cantidadRegistrosPorListado,$pagina,$datos);
		}
	}


	function ObtenerCantidadConsultaMotivos(){

		$reporteModel = new ReporteConsulta;

		$datos= $reporteModel->GetCantidadesConsultaPorMotivo();

		$cantidades = $this->GenerateArrayToSend($datos);

		echo json_encode($cantidades);		
	}

	function  ObtenerCantidadConsultaGeneros(){

		$reporteModel = new ReporteConsulta;

		$datos= $reporteModel->GetCantidadesConsultaPorGenero();

		$cantiades = $this->GenerateArrayToSend($datos);

		echo json_encode($cantiades);		

	}

	function  ObtenerCantidadConsultaLocalidad(){

		$reporteModel = new ReporteConsulta;

		$datos= $reporteModel->GetCantidadesConsultaPorLocalidad();

		$cantiades = $this->GenerateArrayToSend($datos);

		echo json_encode($cantiades);		
	}


	private function GenerateArrayToSend($datos){

		$cantidades = array();
		foreach ($datos as $key => $value) {

			//if(isset($value["id"])){
				$p = array( 'id' =>$value["id"] , 'cantidad' => $value["Cantidad"] );
				array_push($cantidades, $p);
			//}

		}
		return $cantidades;
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