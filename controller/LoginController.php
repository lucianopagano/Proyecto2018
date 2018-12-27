<?php
require_once "./view/LoginView.php";
require_once "./model/core/Usuario.php";
require_once "./model/core/Configuracion.php";
require_once "./controller/ConfiguracionController.php";
class LoginController{

  private static $instance;

  /*
    este metodo incializa una nueva instancia del controlador
    aplica el patron singleton
  */
  public static function getInstance(){
      if(!isset(self::$instance)){
        self::$instance = new self();
      }
      return self::$instance;
  }

  function index(){
    $view = new LoginView();
    $view->Index(null,null,null);
  }

  /**
  * Valida que el usuario este logueado en el sistema
  **/
  function ValidarSesion(){
    if(isset($_SESSION) && isset($_SESSION['uid']) ) {
        return true;
    }
    $view = new LoginView();
    $view->Index(null,null,null);
    return false;
  }

  function login(){

    try {

      //obtengo el nombre y usuario ingresados en el form
      
      
      if(empty($_POST["usuario"]) or empty($_POST["pass"])){
        $contrasenia = null;
        $usuario = null;
        $view = new LoginView();
        $view->Index("¡Error! El usuario y/o contraseña son incorrectos, intente nuevamente.",0,null);
      }
      else{
        $usuario = $_POST["usuario"];
      
        $contrasenia = $_POST["pass"];
        $m_usuario = new Usuario();

        if(!$m_usuario->userLogin($usuario,$contrasenia)){

        //si el logueo es incorrecto
        //envio los mensajes
        $view = new LoginView();
        $view->Index("¡Error! El usuario y/o contraseña son incorrectos, intente nuevamente.",1,null);
        }
        else{
        
          //guardo el id del usuario en la sesion
          $suser= $m_usuario->getUsuario($usuario);

          $_SESSION['uid']=$suser->id;
          $_SESSION['usuario']=$suser->username;
          $_SESSION['nombre']=$suser->first_name;
          $_SESSION['ape']=$suser->last_name;
          $_SESSION['email']=$suser->email;
          // guardo role
          $_SESSION['rol']=$m_usuario->getRoles($suser->id);
       
          $_SESSION['permisos']=$m_usuario->getUsuarioPermisos($suser->id);
          $conf = new Configuracion();

          if($conf->getConfiguracion("mantenimiento") == true){
          //si esta en modo ´mantenimiento y el usuario tiene rol administrador
          //se muesta la vista de administracion
          $confController = new ConfiguracionController();
          $confController->ShowMantenimiento();
          }
          else{
           $view = new UsuarioView();

           $view->viewHomePublic($_SESSION['rol'],null,null);
          }

        }
      }  
    }
    catch (\Exception $e) {
      $view = new LoginView();
      $view->Index("¡Error! al intentar loguear",1,null);
    }
  }
  public function logout()
  {

     session_destroy();

     $view = new LoginView();
     $tipo = null;
     $mensaje = null;
     $view->Index($mensaje,$tipo,null);

  }
}
