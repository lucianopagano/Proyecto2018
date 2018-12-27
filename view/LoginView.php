<?php
require_once "./view/TwigView.php";
class LoginView extends TwigView
{
  public function Index($mensaje,$tipo,$desc){
    echo self::getTwig()->render('log-in.tpl',array('mensaje'=>$mensaje,'tipo'=>$tipo,'desc'=>$desc));
  }

}
