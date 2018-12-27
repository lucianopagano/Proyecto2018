<?php
require_once "./view/TwigView.php";
class Home extends TwigView{

  public function ShowHomeUser($mensaje = null){
    echo self::getTwig()->render('plantilla-principal.tpl',array('mensaje' => $mensaje ));
  }

  public function ShowHomePublic($mensaje = null){
  	echo self::getTwig()->render('home-public.twig',array('mensaje' => $mensaje ));
  }
}
