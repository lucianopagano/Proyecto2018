<?php
require_once './view/Home.php';
require_once './view/LoginView.php';
class ResourceController {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }



    public function index() {
        session_start();
        if(!isset($_SESSION)) {
            $usuario=$_SESSION['uid'];
        } else{
            $usuario=null;
        }
        $view = new Home();
        $view->Index($usuario);
    }

}
