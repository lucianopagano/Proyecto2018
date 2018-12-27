<?php 
require_once "./view/TwigView.php";
class PacienteView extends TwigView{

  public function Index($generos,$paciente, $mensaje= null){
    $roles=$_SESSION['rol'];
  	$parametros = array( 'generos' => $generos,
     'mensaje'=>$mensaje,
     'paciente'=>$paciente,
     'rolesUserSistema'=>$roles);

    echo self::getTwig()->render('alta-paciente.tpl',$parametros,$mensaje);
  }

  public function ShowListadoPaciente($mensaje,$cantidadPacientes,$total_paginas,
    $cantidadRegistrosPorListado,$pagina,$pacientes,
    $generos,$generoSeleccionado,$nombre,$apellido,$num_historia_clinica,$numDocumento,
    $siHabilitadoDetalle, $siHabilitadoActualizacion, $siHabilitadoBaja){
    $roles=$_SESSION['rol'];
  	$array = array('mensaje'=> $mensaje,
  		'generos'=>$generos,
  		'num_filas'=> $cantidadPacientes,
  		'total_paginas'=>$total_paginas,
      'tamagno_paginas'=>$cantidadRegistrosPorListado,
  		'pagina'=> $pagina,
  		'pacientes'=>$pacientes,
      'generoSeleccionado'=> $generoSeleccionado,
      'nombre'=> $nombre,
      'apellido'=> $apellido,
      'num_historia_clinica' =>$num_historia_clinica,
      'numDocumento'=>$numDocumento,
      'siHabilitadoDetalle'=> $siHabilitadoDetalle,
      'siHabilitadoActualizacion'=>$siHabilitadoActualizacion,
      'siHabilitadoBaja'=> $siHabilitadoBaja,
      'rolesUserSistema'=>$roles);

    echo self::getTwig()->render('listado-pacientes.tpl',$array);
  }

  public function ShowPaciente($paciente){
    $array  = array('paciente' => $paciente );

    echo self::getTwig()->render('detalle-paciente.tpl',$array);
  }

}
