<?php
require_once "./view/TwigView.php";

class UsuarioView extends TwigView{

  public function viewUpUsuario($aroles,$roles,$mensaje, $tipo){
    $rolesUserSistema = $_SESSION['rol'];
    $accion= 'insertUsuario';
    foreach( $aroles as $rol) {
      if (!in_array($rol, $roles)) {
        $aaroles[]=$rol;
        
      }
    }
    if (!is_null($mensaje) && !is_null($tipo)){

      $mensaje = array('tipoMensaje' => $tipo ,'mensajeAMostrar'=> $mensaje);
      echo self::getTwig()->render('curd-usuario.tpl', array('rolesUserSistema'=>$rolesUserSistema,'mensaje'=>$mensaje,
        'accion'=>$accion,'allRoles'=>$aaroles,'roles'=>$roles));
    }
    else{

      $mensaje = array();
      echo self::getTwig()->render('curd-usuario.tpl', array('rolesUserSistema'=>$rolesUserSistema,'mensaje'=>$mensaje,
        'accion'=>$accion,'allRoles'=>$aaroles,'roles'=>$roles));
    }
  }
  public function viewHomePublic($roles,$mensaje){
   
    echo self::getTwig()->render('home-public.tpl', array('mensaje'=>$mensaje,'rolesUserSistema'=>$roles));
   
  }
  public function showListUser($parametros){
    $accion= 'insertUsuario';

    echo self::getTwig()->render('listar-usuario.tpl', array('accion'=>$accion, 'usuarios'=>$parametros['usuarios'],
    "rolesUserSistema"=>$parametros['rolesUserSistema'],"paginas"=>$parametros['paginas'], "pagina_siguiente"=>$parametros['pagina_siguiente'],
    "pagina_anterior"=>$parametros['pagina_anterior'], "ultima_pagina"=>$parametros['ultima_pagina'],
    "pagina_actual"=> $parametros['pagina_actual']));
  }
  public function viewEditarUsuario($usuario,$roles, $aroles ,$rolesUserSistema,$mensaje, $tipo){
    $accion= 'editUser&id='.$usuario->id;
    $aaroles=array();
    //$rolesUserSistema = $_SESSION['rol'];
    // recorro el arreglo y me quedo con todos los roles q existen pero q no tiene el usuario
    foreach( $aroles as $rol) {
      if (!in_array($rol, $roles)) {
        $aaroles[]=$rol;
        
      }
    }


    if (!empty($mensaje) && !empty($tipo)){
      $mensaje = array('tipoMensaje' => $tipo ,'mensajeAMostrar'=> $mensaje);
      echo self::getTwig()->render('curd-usuario.tpl', array('accion'=>$accion,'rolesUserSistema'=>$rolesUserSistema,'usuario'=>$usuario,'mensaje'=>$mensaje, 'roles'=>$roles, 'allRoles'=>$aaroles));
    }
    else{

      echo self::getTwig()->render('curd-usuario.tpl', array('accion'=>$accion,'rolesUserSistema'=>$rolesUserSistema,'usuario'=>$usuario, 'roles'=>$roles, 'allRoles'=>$aaroles));
    }
  }
  public function viewUsuario($usuario,$roles, $aroles ,$mensaje, $tipo){
    $accion='viewUsuarios';
    $rolesUserSistema = $_SESSION['rol'];
    
    // recorro el arreglo y me quedo con todos los roles q existen pero q no tiene el usuario
    foreach( $aroles as $rol) {
      if (!in_array($rol, $roles)) {
        $aaroles[]=$rol;
        
      }
    }


    if (!empty($mensaje) && !empty($tipo)){
      $mensaje = array('tipoMensaje' => $tipo ,'mensajeAMostrar'=> $mensaje);
      echo self::getTwig()->render('curd-usuario.tpl', array('rolesUserSistema'=>$rolesUserSistema,'accion'=>$accion,'usuario'=>$usuario,'mensaje'=>$mensaje, 'roles'=>$roles, 'allRoles'=>$aaroles));
    }
    else{

      echo self::getTwig()->render('curd-usuario.tpl', array('rolesUserSistema'=>$rolesUserSistema,'accion'=>$accion,'usuario'=>$usuario, 'roles'=>$roles, 'allRoles'=>$aaroles));
    }
  }
}
