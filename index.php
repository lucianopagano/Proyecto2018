<?php

  //die("entro");

  require_once __DIR__ . '/controller/ConfiguracionController.php';
  require_once __DIR__ . '/controller/PacienteController.php';
  require_once __DIR__ . '/controller/LoginController.php';
  require_once __DIR__ . '/controller/UsuarioController.php';
  require_once __DIR__ . '/controller/ApiReferenciasController.php';
  require_once __DIR__ . '/controller/HomeController.php';
  require_once __DIR__ . '/controller/AtencionController.php';
  require_once __DIR__ . '/controller/ReporteConsultaController.php';

  //este metodo inicia o reanuda la sesion
  session_start();

  $conf = new ConfiguracionController();

  
  $map = array(
    //RUTAS DE CONFIGURACION
    'mantenimiento' => array('controller' => 'ConfiguracionController', 'action'=>'ShowMantenimiento'),
    'inicio' => array('controller' =>'HomeController', 'action' =>'Index'),
    'mantenimientoUpdate' => array('controller' =>'ConfiguracionController', 'action' =>'Update'),
    'configuracion' => array('controller' =>'ConfiguracionController', 'action' =>'Index'),
    //RUTAS LOGIN
    'showLogin' => array('controller' =>'LoginController', 'action' =>'index'),
    'login' => array('controller' =>'LoginController', 'action' =>'login'),
    'logout' => array('controller' =>'LoginController', 'action' =>'logout'),

    //RUTAS DE ATENCION MEDICA
    'showAtencionMedica' => array('controller' =>'AtencionController', 'action' =>'showAtencion'),
    'ingresarAtencionMedica' => array('controller' =>'AtencionController', 'action' =>'ingresarAtencion'),
    'searchPaciente' => array('controller' =>'AtencionController', 'action' =>'searchPaciente'),
    'searchInstituciones' => array('controller' =>'AtencionController', 'action' =>'getInstitucionesId'),
    'listarConsultas' => array('controller' =>'AtencionController', 'action' =>'listarConsultas'),
    'eliminarConsulta' => array('controller' =>'AtencionController', 'action' =>'eliminarConsulta'),
    'editarConsulta' => array('controller' =>'AtencionController', 'action' =>'editarConsulta'),
    'showEditarConsulta' => array('controller' =>'AtencionController', 'action' =>'showEditarConsulta'),
    'autocompletarPaciente' => array('controller' =>'AtencionController', 'action' =>'autocompletar'),

    //RUTAS DE USUARIO
    'showAltaUsuario' => array('controller' =>'UsuarioController', 'action' =>'showAltaUsuario'), //vista
    'listUsuarios' => array('controller' =>'UsuarioController', 'action' =>'listarUsuarios'), //vista
    'insertUsuario' => array('controller' =>'UsuarioController', 'action' =>'insertUsuario'),
    'editarUsuario' => array('controller' =>'UsuarioController', 'action' =>'showEditarUsuario'), //vista
    'viewUsuario' => array('controller' =>'UsuarioController', 'action' =>'viewUsuario'),
    'editUser' => array('controller' =>'UsuarioController', 'action' =>'editarUsuario'),
    'eliminarUsuario' => array('controller' =>'UsuarioController', 'action' =>'borrarUsuario'),
    'autocompletarUsuario' => array('controller' =>'UsuarioController', 'action' =>'autocompletar'),
    'searchUsuario' => array('controller' =>'UsuarioController', 'action' =>'searchUsuario'),
    //RUTAS PACIENTE
    'altaPacienteIndex' => array('controller' =>'PacienteController', 'action' =>'Index'),
    'GetPartidos' => array('controller' =>'ApiReferenciasController', 'action' =>'GetPartidos'),
    'GetLocalidadesByPartido' => array('controller' =>'ApiReferenciasController', 'action' =>'GetLocalidadesByPartido'),
    'GetRegionSanitaria' => array('controller' =>'ApiReferenciasController', 'action' =>'GetRegionSanitaria'),
    'GetObrasSociales' => array('controller' =>'ApiReferenciasController', 'action' =>'GetObrasSociales'),
    'GetTipoDocumentos' => array('controller' =>'ApiReferenciasController', 'action' =>'GetTipoDocumentos'),
    'GetLocalidades' => array('controller' =>'ApiReferenciasController', 'action' =>'GetLocalidades'),
    'AgregarPaciente' => array('controller' =>'PacienteController', 'action' =>'AgregarPaciente'),
    'ShowListadoPaciente' => array('controller' =>'PacienteController', 'action' =>'ShowListadoPaciente'),
    'EliminarPaciente'=> array('controller' =>'PacienteController', 'action' =>'EliminarPaciente'),
    'DetallePaciente'=> array('controller' =>'PacienteController', 'action' =>'DetallePaciente'),
    'ShowActualizarPaciente'=> array('controller' =>'PacienteController', 'action' =>'ShowActualizarPaciente'),
    'ActualizarPaciente'=> array('controller' =>'PacienteController', 'action' =>'ActualizarPaciente'),
    
    //rutas reportes
    'ObtenerCantidadConsultaMotivos'=>array('controller' =>'ReporteConsultaController', 'action' =>'ObtenerCantidadConsultaMotivos'),
    'ObtenerCantidadConsultaGeneros'=>array('controller' =>'ReporteConsultaController', 'action' =>'ObtenerCantidadConsultaGeneros'),
    'ObtenerCantidadConsultaLocalidad'=>array('controller' =>'ReporteConsultaController', 'action' =>'ObtenerCantidadConsultaLocalidad'),
    
    'ShowConsultasMotivo'=> array('controller' =>'ReporteConsultaController', 'action' =>'ShowConsultasMotivo'),
    'ShowConsultasLocalidad'=>array('controller' =>'ReporteConsultaController', 'action' =>'ShowConsultasLocalidad'),
    'ShowConsultaGenero'=>array('controller' =>'ReporteConsultaController', 'action' =>'ShowConsultaGenero'));
  


  if($conf->SiModoMantenimiento() == false){
    // Parseo de la ruta
    if (isset($_GET['ctl'])) {

        if (isset($map[$_GET['ctl']])) {
            $ruta = $_GET['ctl'];
        }
        else {
          header('Status: 404 Not Found');
          $msj= 'Error 404: No existe la ruta lalalaka ' .$_GET['ctl'];
          return $msj;
        }
    }
    else {
        $ruta = 'inicio';
    }
  }

  else if(isset($_GET['ctl']) && ($_GET['ctl'] == "login" || $_GET['ctl'] == "showLogin" || $_GET['ctl'] == "mantenimientoUpdate") && isset($map[$_GET['ctl']])){

    //ingresar al sistema en modo mantenimiento
    $ruta = $_GET['ctl'];
  }
  else{

    $ruta ='mantenimiento';
  }

  $controlador = $map[$ruta];

  // Ejecución del controlador asociado a la ruta
  if (method_exists($controlador['controller'],$controlador['action'])) {
      call_user_func(array(new $controlador['controller'], $controlador['action']));
  }
  else {
    header('Status: 404 Not Found');
    $msj= 'Error 404: El controlador ' .$controlador['controller'] .'->' .$controlador['action'] .' no existe';
    return $msj;
  }
