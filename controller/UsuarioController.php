<?php
require_once "./view/LoginView.php";
require_once './view/UsuarioView.php';

require_once "./helpers/funciones.php";

require_once "./model/core/Usuario.php";

class UsuarioController {
			private static $instance;

			public function showAltaUsuario() {
				//session_start();
				if(isset($_SESSION['usuario'])){ //si esta iniciada la sesion

						$usuario = $_SESSION['usuario'];
						$rol = $_SESSION['rol'];
						//$rol = $_SESSION['rol'];

						$funciones = new Funciones();
						$acceso = $funciones->validarAcceso($_SESSION,'usuario_alta'); //VALIDO EL ACCESO PARA EL USUARIO Y LA ACCION
					
						if($acceso){ //SI TIENE PERMISO PARA ESTE ACCION
								$view = new UsuarioView();
								$usuario = new Usuario();
								$aroles=$usuario->getAllRoles();
								$mensaje=null;
								$tipo=null;
								$roles=array();
								$view->viewUpUsuario($aroles,$roles,$mensaje,$tipo);
								
						}
						else{

							$view = new UsuarioView();
							$tipo=0;
							$mensaje='El usuario no dispone permisos necesarios para realizar esta acción';
							//$template = $twig->loadTemplate('backend.twig.html');
							//echo $template->render(array('nombre'=>$usuario,'rol'=>$rol,'mensajeTipo'=>'ERROR','mensajeError'=>$mensaje));
							$view->viewHomePublic($mensaje,$tipo);
						}
					}
					else{

						$loginview = new LoginView();
						$loginview->Index("¡Error! El usuario debe estar logeado en el sistema!!",1,null);
					}

			}
			public function listarUsuarios(){
				//session_start();
				if(isset($_SESSION['usuario'])){ //si esta iniciada la sesion

						$usuario = $_SESSION['usuario'];
						$rol = $_SESSION['rol'];

						$funciones = new Funciones();
						$acceso = $funciones->validarAcceso($_SESSION,'usuario_list'); //VALIDO EL ACCESO PARA EL USUARIO Y LA ACCION
					//
						if($acceso){ //SI TIENE PERMISO PARA ESTE ACCION
							// Inicializamos variables de paginación
								$pagina 	= 1;

								 // validamos la número de página
								if(isset($_GET['id']) && !empty($_GET['id'])){
									$pagina = $_GET['id'];


								}
								// llamar función para realizar la recopilación de datos y números de página

									$user= new Usuario();
									$lista_paginada = $user->paginar_registro($pagina);
									// verificamos que no sea la última pagina
									if($lista_paginada['nTPaginas'] < $pagina ){
											$pagina = $lista_paginada['nTPaginas'];
											$lista_paginada =$user->paginar_registro($pagina);
										 }
									 // creamos variables que contengan la página siguiente y página anterior
									 // Calculamos pagina siguiente y anterior
									$paginaSiguiente 	= $pagina +1;
									$paginaAnterior		= $pagina -1;
									$parametros['rolesUserSistema'] = $rol;
									$parametros['usuarios']= $lista_paginada['listaRegistro'];
									$parametros['paginas']= $lista_paginada['paginas'];
									$parametros['pagina_siguiente']= $paginaSiguiente;
									$parametros['pagina_anterior']= $paginaAnterior;
									$parametros['ultima_pagina']= $lista_paginada['nTPaginas'];
									$parametros['pagina_actual']= 1;
									$viewUser = new UsuarioView();
									$viewUser->showListUser($parametros);

						}
						else{

								$view = new UsuarioView();
								$tipo=0;
								$mensaje='El usuario no dispone permisos necesarios para realizar esta acción';
								$view->viewHomePublic($mensaje,$tipo);
							}
				}
				else{

						$loginview = new LoginView();
						$loginview->Index("¡Error! El usuario debe estar logeado en el sistema!!",1,null);
					}
			}
			public function insertUsuario(){


				//session_start();
				if(isset($_SESSION['usuario'])){ //si esta iniciada la sesion

						$usuario = $_SESSION['usuario'];
						$rol = $_SESSION['rol'];

						$funciones = new Funciones();
						$acceso = $funciones->validarAcceso($_SESSION,'usuario_alta'); //VALIDO EL ACCESO PARA EL USUARIO Y LA ACCION
					//
						if($acceso){ //SI TIENE PERMISO PARA ESTE ACCION

								$funciones = new Funciones();
								$view = new UsuarioView();

								//$template = self::getTwig()->loadTemplate('curd-usuario.tpl');
								//  echo self::getTwig()->render('curd-usuario.tpl', array('accion'=>$accion));
							if (isset($_POST['nombre'])and isset($_POST['apellido']) and isset($_POST['usuario']) and isset($_POST['password']) and isset($_POST['email']) ){
								$params=ARRAY($_POST['nombre'],$_POST['apellido'],$_POST['usuario'],$_POST['password'],$_POST['email']);
								//$resul = $funciones->validar($params);
								//die($resul);
								if ($funciones->validar($params)){
										$params_S=ARRAY(0 => $funciones->sanitizar($_POST['email']),1 =>$funciones->sanitizar($_POST['usuario']),
										2 =>$funciones->sanitizar($_POST['password']),3 =>$funciones->sanitizar($_POST['nombre']),
										4 =>$funciones->sanitizar($_POST['apellido']));
										//die($params_S[0]);
										$user = new Usuario();
										
										$aroles=$user->getAllRoles();
										$roles[]=array();
										if ($user->insertUsuario($params_S[0],$params_S[1],$params_S[2],$params_S[3],$params_S[4])){

												//$all_roles=$user->getAllRoles();
												$idUser=$user->getUsuarioId($_POST['nombre']);
												
												//obtengo todos los nuevos roles para actualizar el usuario
												$nuevo_rol=array();
												if(!empty($_POST['check-'])) {

													foreach($_POST['check-'] as  $key =>  $value){
														//$nuevo_rol[$key] = $value;
														$user->getAddRoles($idUser,$value);
											
													}

												}
												$mensaje= 'El usuario se agrego sin problemas!!';
												$roles=$user->getRoles($idUser);
												$view->viewUpUsuario($aroles,$roles,$mensaje,1);
										}
										else {
											$mensaje= 'No se pudo agregar el  usuario, ya existe en la Bd!!';
											$tipo=0;
											$view->viewUpUsuario($aroles,$roles,$mensaje,$tipo);
										}
								}
								else{
									$user = new Usuario();
									$aroles=$user->getAllRoles();
									$roles=array();
									$mensaje= 'No se pudo agregar el  usuario, ya existe en la Bd!!';
									$tipo=0;

									$view->viewUpUsuario($aroles,$roles,$mensaje,$tipo);
								}
							}
							else{
									$user = new Usuario();
									$aroles=$user->getAllRoles();
									$roles=array();
									$mensaje= 'ERROR!, Debe completar todos los campos del formulario!';
									$tipo=0;

									$view->viewUpUsuario($aroles,$roles,$mensaje,$tipo);
							}
						}
						else{

								$view = new UsuarioView();
								$tipo=0;
								$mensaje='El usuario no dispone permisos necesarios para realizar esta acción';
								//$template = $twig->loadTemplate('backend.twig.html');
								//echo $template->render(array('nombre'=>$usuario,'rol'=>$rol,'mensajeTipo'=>'ERROR','mensajeError'=>$mensaje));
								$view->viewHomePublic($mensaje,$tipo);
							}
					}
					else{
						$loginview = new LoginView();
						$loginview->Index("¡Error! El usuario debe estar logeado en el sistema!!",1,null);
					}
			}
			public function viewUsuario(){
				if(isset($_SESSION['usuario'])){ //si esta iniciada la sesion

							$usuario = $_SESSION['usuario'];
							$funciones = new Funciones();
							$acceso = $funciones->validarAcceso($_SESSION,'usuario_view'); //VALIDO EL ACCESO PARA EL USUARIO Y LA ACCION
						
							if($acceso){ //SI TIENE PERMISO PARA ESTE ACCION
											$funciones = new Funciones();
											$view = new UsuarioView();
											$usuario = new Usuario();
											$user=$usuario->getUsuarioById($_GET['id']);
											$roles=$usuario->getRoles($_GET['id']);
											$aroles=$usuario->getAllRoles();
											$view->viewUsuario($user,$roles,$aroles,null,null);
			 
							}
							else{
									$view = new UsuarioView();
									$tipo=0;
									$mensaje='El usuario no dispone permisos necesarios para realizar esta acción';
									$view->viewHomePublic($mensaje,$tipo);
							}
				}
				else{
							$loginview = new LoginView();
							$loginview->Index("¡Error! El usuario debe estar logeado en el sistema!!",1,null);
				}
			
				
			}
			public function showEditarUsuario(){

					//session_start();
					if(isset($_SESSION['usuario'])){ //si esta iniciada la sesion

							$usuario = $_SESSION['usuario'];
							$rol = $_SESSION['rol'];

							$funciones = new Funciones();
							$acceso = $funciones->validarAcceso($_SESSION,'usuario_edit'); //VALIDO EL ACCESO PARA EL USUARIO Y LA ACCION
						//
							if($acceso){ //SI TIENE PERMISO PARA ESTE ACCION

								$funciones = new Funciones();
								$view = new UsuarioView();
								$usuario = new Usuario();
								$user=$usuario->getUsuarioById($_GET['id']);
								$roles=$usuario->getRoles($_GET['id']);
								$aroles=$usuario->getAllRoles();
							
								$view->viewEditarUsuario($user,$roles,$aroles,$rol,null,null);
			 
							}
							else{
									$acceso = $funciones->validarAcceso($_SESSION,'usuario_view');
									if($acceso){
											$funciones = new Funciones();
											$view = new UsuarioView();
											$usuario = new Usuario();
											$user=$usuario->getUsuarioById($_GET['id']);
											$roles=$usuario->getRoles($_GET['id']);
											$aroles=$usuario->getAllRoles();
											$view->viewUsuario($user,$roles,$aroles,null,null);
									}
									else{
									$view = new UsuarioView();
									$tipo=0;
									$mensaje='El usuario no dispone permisos necesarios para realizar esta acción';
									//$template = $twig->loadTemplate('backend.twig.html');
									//echo $template->render(array('nombre'=>$usuario,'rol'=>$rol,'mensajeTipo'=>'ERROR','mensajeError'=>$mensaje));
									$view->viewHomePublic($mensaje,$tipo);
								}
							}
						}
						else{
							$loginview = new LoginView();
							$loginview->Index("¡Error! El usuario debe estar logeado en el sistema!!",1,null);
						}
			}
			public function editarUsuario(){

					//session_start();
					if(isset($_SESSION['usuario'])){ //si esta iniciada la sesion

							$usuario = $_SESSION['usuario'];
							$rol = $_SESSION['rol'];
							$uid = $_GET['id'];
							$funciones = new Funciones();
							$acceso = $funciones->validarAcceso($_SESSION,'usuario_edit'); //VALIDO EL ACCESO PARA EL USUARIO Y LA ACCION


							if($acceso){ //SI TIENE PERMISO PARA ESTE ACCION

								//creo los objetos necesarios para trabajar
								$funciones = new Funciones();
								$view = new UsuarioView();
								$user = new Usuario();

								$all_roles=$user->getAllRoles();
								
								
								if(!empty($_POST['activo'])) {
									//die('entro null');
										$activo=1;
								}
								else{
									//die('entro else');
								$activo=0;
								}//obtengo todos los nuevos roles para actualizar el usuario
								$nuevo_rol=array();

								if(!empty($_POST['check-'])) {

										foreach($_POST['check-'] as  $key =>  $value){
											$nuevo_rol[$key] = $value;
											
										}

								}

								$params=ARRAY($_POST['nombre'],$_POST['apellido'],$_POST['usuario'],$_POST['password'],$_POST['email']);
								// Valido los parametros q no sean nulos o vacios.
								if ($funciones->validar($params)){
										$params_S=ARRAY(0 => $funciones->sanitizar($_POST['email']),1 =>$funciones->sanitizar($_POST['usuario']),
										2 =>$funciones->sanitizar($_POST['password']),3 =>$funciones->sanitizar($_POST['nombre']),
										4 =>$funciones->sanitizar($_POST['apellido']));
										//die($params_S[0]);
										
										// Actualizo datos del usuario
										$user->editUsuario($params_S[0],$params_S[1],$params_S[2],$params_S[3],$params_S[4],$uid,$activo);
										// actualizo roles del usuario 
										$user->getDeleteRoles($uid);
										// actualizo todos los roles nuevos
										foreach ($nuevo_rol as $key => $value) {
											
											$user->getAddRoles($uid,$value);
										}
										// obtengo los nuevos roles 
										$roles=$user->getRoles($uid);
										
										$mensaje= 'El usuario se actualizo sin problemas!!';
										$view->viewEditarUsuario($user->getUsuarioById($uid),$roles,$all_roles,$rol,$mensaje,1);

									}
								else{
									$mensaje= 'Falta completar algún campo en el formulario!!';
									$tipo=0;
									
									$roles=$user->getRoles($uid);
									

									//$uid= $usuario->getUsuarioId($params[2]);
									$view->viewEditarUsuario($user->getUsuarioById($uid),$roles,$all_roles,$rol,$mensaje,$tipo);

								}
							}
							else{

									$view = new UsuarioView();
									$tipo=0;
									$mensaje='El usuario no dispone permisos necesarios para realizar esta acción';
									//$template = $twig->loadTemplate('backend.twig.html');
									//echo $template->render(array('nombre'=>$usuario,'rol'=>$rol,'mensajeTipo'=>'ERROR','mensajeError'=>$mensaje));
									$view->viewHomePublic($mensaje,$tipo);
								}
						}
						else{
							$loginview = new LoginView();
							$loginview->Index("¡Error! El usuario debe estar logeado en el sistema!!",1,null);
						}
			}
			public function borrarUsuario(){
					//session_start();
					if(isset($_SESSION['usuario'])){ //si esta iniciada la sesion

							$usuario = $_SESSION['usuario'];
							$rol = $_SESSION['rol'];

							$funciones = new Funciones();
							$acceso = $funciones->validarAcceso($_SESSION,'usuario_baja'); //VALIDO EL ACCESO PARA EL USUARIO Y LA ACCION
						
							if($acceso){ //SI TIENE PERMISO PARA ESTE ACCION
								$viewUser = new UsuarioView();
								$funciones = new Funciones();
								$user = new Usuario();
								$user->deleteUsuario($_GET['id']);
								header('Location:/index.php?ctl=listUsuarios'); exit();
								//$usuarios = $user->getListarUsuarios();

								//$viewUser->showListUser($usuarios);

							 }
							else{

								$view = new UsuarioView();
								$tipo=0;
								$mensaje='El usuario no dispone permisos necesarios para realizar esta acción';
								$view->viewHomePublic($mensaje,$tipo);
							}
						}
					else{
							$loginview = new LoginView();
							$loginview->Index("¡Error! El usuario debe estar logeado en el sistema!!",1,null);
					}
			}
			public function autocompletar(){

				if(isset($_POST['search'])){
					$search = $_POST['search'];

					$user = new Usuario();
					$searching=$user->buscarUsuario($search);
					if ($searching != null ){
						echo json_encode($searching);
					}

				}
			}
			public function searchUsuario(){

				if(isset($_POST['search'])){
					$idUser = $_POST['search'];

					$user = new Usuario();
					$userSearch=$user->getUsuarioById($idUser);
					//
					// $pagina = 0;
					// $paginaSiguiente 	= $pagina;
					// $paginaAnterior		= $pagina;
					// $parametros['usuarios']= array($userSearch);
					// $parametros['paginas']= $pagina;
					// $parametros['pagina_siguiente']= $paginaSiguiente;
					// $parametros['pagina_anterior']= $paginaAnterior;
					// $parametros['ultima_pagina']= $pagina;
					// $parametros['pagina_actual']= 0;
					// $viewUser = new UsuarioView();
					// die(lallalal);
					//$viewUser->showListUser($userSearch);
					echo json_encode($userSearch);
					}

				}

}
