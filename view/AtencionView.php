<?php
require_once "./view/TwigView.php";

class AtencionView extends TwigView{

	public function viewModificacionAtencion($mensaje,$consulta, $paciente, $motivos, $tratamiento,$acompanamiento,$instituciones,$rolesUserSistema){
		
			
		  		echo self::getTwig()->render('curd-atencion.tpl', array('mensaje' => $mensaje,'paciente' => $paciente,'consulta' => $consulta,'mensaje' => $mensaje,'rolesUserSistema' => $rolesUserSistema,
	  			'motivos' => $motivos,'tratamiento' => $tratamiento, 'acompanamiento' => $acompanamiento,'instituciones' => $instituciones));
	
  	}
	public function viewAtencion($mensaje,$motivos, $tratamiento,$acompanamiento,$instituciones,$rolesUserSistema){

				
	  		echo self::getTwig()->render('curd-atencion.tpl', array('mensaje' => $mensaje,'rolesUserSistema' => $rolesUserSistema,
	  			'motivos' => $motivos,'tratamiento' => $tratamiento, 'acompanamiento' => $acompanamiento, 'instituciones' => $instituciones));
	
  	}
  	public function viewAtencionListar($mensaje,$motivos, $tratamiento,$acompanamiento,$instituciones,$parametros,$rolesUserSistema){
		
				
	  		echo self::getTwig()->render('listar-consultas.tpl', array('mensaje' => $mensaje,'rolesUserSistema' => $rolesUserSistema,
	  			'motivos' => $motivos,'tratamiento' => $tratamiento, 'acompanamiento' => $acompanamiento, 'instituciones' => $instituciones,
	  			'consultas' => $parametros['consultas'],'pagina_actual'=> $parametros['pagina_actual'],'pagina_anterior'=>$parametros['pagina_anterior'],
	  			'pagina_siguiente'=> $parametros['pagina_siguiente'],'ultima_pagina'=> $parametros['ultima_pagina']));
	
  	}

}