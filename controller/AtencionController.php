<?php
require_once "./view/LoginView.php";
require_once './view/UsuarioView.php';
require_once './view/AtencionView.php';
require_once "./helpers/funciones.php";
require_once "./model/core/Paciente.php";
require_once "./model/core/Usuario.php";
require_once "./model/core/Consulta.php";
require_once "./model/core/ApiInstituciones.php";

class AtencionController {
			private static $instance;

			public function showAtencion() {
				//session_start();
				if(isset($_SESSION['usuario'])){ //si esta iniciada la sesion

						$usuario = $_SESSION['usuario'];
						$rol = $_SESSION['rol'];
						//$rol = $_SESSION['rol'];

						$funciones = new Funciones();
						$acceso = $funciones->validarAcceso($_SESSION,'usuario_view'); //atencion_show VALIDO EL ACCESO PARA EL USUARIO Y LA ACCION
					
						if($acceso){ //SI TIENE PERMISO PARA ESTE ACCION
								$view = new AtencionView();
								$consulta = new Consulta();
								$motivo = $consulta->motivos();
								$tratamiento = $consulta->tratamiento();
								$acompanamiento = $consulta->acompanamiento();
								//$instituciones = $consulta->instituciones();
								$instModel = new ApiInstituciones;
								$json = $instModel->ObtenerInstituciones();
								$instituciones=json_decode($json, true);
								//die();
								

								$mensajes = array();
								$view->viewAtencion($mensajes,$motivo,$tratamiento,$acompanamiento,$instituciones,$rol);
								
						}
						else{

							$view = new UsuarioView();
							$tipo=0;
							$mensaje='El usuario no dispone permisos necesarios para realizar esta acción';
							//$template = $twig->loadTemplate('backend.twig.html');
							//echo $template->render(array('nombre'=>$usuario,'rol'=>$rol,'mensajeTipo'=>'ERROR','mensajeError'=>$mensaje));

							$mensajes = array('tipoMensaje' => $tipo ,'mensajeAMostrar'=> $mensaje);
							$view->viewHomePublic($rol,$mensajes);
						}
					}
					else{

						$loginview = new LoginView();
						$loginview->Index("¡Error! El usuario debe estar logeado en el sistema!!",1,null);
					}

			}
			public function ingresarAtencion() {
				//session_start();
				if(isset($_SESSION['usuario'])){ //si esta iniciada la sesion

						$usuario = $_SESSION['usuario'];
						$rol = $_SESSION['rol'];
						//$rol = $_SESSION['rol'];

						$funciones = new Funciones();
						$acceso = $funciones->validarAcceso($_SESSION,'usuario_alta'); //atencion_show VALIDO EL ACCESO PARA EL USUARIO Y LA ACCION

						if($acceso){ //SI TIENE PERMISO PARA ESTE ACCION
								
								if (isset($_POST['selectuser_id'])and isset($_POST['nombre'])and isset($_POST['apellido']) and isset($_POST['dni']) and isset($_POST['FechaDeTurno']) and isset($_POST['Motivo']) 
									and isset($_POST['Derivacion'])and isset($_POST['Tratamientofarmacologico']) and  isset($_POST['acompanamiento'])
									){
									$params=ARRAY($_POST['nombre'],$_POST['apellido'],$_POST['dni'],$_POST['FechaDeTurno'],$_POST['Motivo'],$_POST['Derivacion'],$_POST['Tratamientofarmacologico'],
									$_POST['acompanamiento']);
									//$resul = $funciones->validar($params);
									//die($resul);diagnostico
									
									
									if ($funciones->validar($params)){
										$idUser = $_POST['selectuser_id'];
										
										if (!isset($_POST['internacion'])){
											$inter = 0;
										}else{
											$inter = 1;
										}
										
										$params_S=ARRAY(0 => $funciones->sanitizar($_POST['nombre']),1 =>$funciones->sanitizar($_POST['apellido']),
										2 =>$funciones->sanitizar($_POST['dni']),3 =>$funciones->sanitizar($_POST['FechaDeTurno']),
										4 =>$funciones->sanitizar($_POST['Motivo']),5 =>$funciones->sanitizar($_POST['Derivacion']),6 =>$funciones->sanitizar($_POST['Tratamientofarmacologico']),
										7 =>$funciones->sanitizar($inter),8 =>$funciones->sanitizar($_POST['diagnostico']),9 =>$funciones->sanitizar($_POST['observaciones']),
										10 =>$funciones->sanitizar($_POST['tratarcon']),11 =>$funciones->sanitizar($_POST['acompanamiento']));
										
										$consulta = new Consulta();
										
										$consulta->insertConsulta($idUser, $params_S[3], $params_S[4], $params_S[5], $params_S[10], $params_S[7], $params_S[8], $params_S[9], $params_S[6], $params_S[11]);
										//header('Location:/index.php?ctl=showAtencionMedica'); exit();
										$view = new AtencionView();
										$consulta = new Consulta();
										$motivo = $consulta->motivos();
										$tratamiento = $consulta->tratamiento();
										$acompanamiento = $consulta->acompanamiento();
										//$instituciones = $consulta->instituciones();
										$instModel = new ApiInstituciones;
										$json = $instModel->ObtenerInstituciones();
										$instituciones=json_decode($json, true);
										$mensaje="Se realizó con exito la consulta!!";
												
										$tipo=1;
										$mensajes = array('tipoMensaje' => $tipo ,'mensajeAMostrar'=> $mensaje);
										$view->viewAtencion($mensajes,$motivo,$tratamiento,$acompanamiento,$instituciones,$rol);

									}
									else{
										
										
										$tipo=1;
										$mensaje='Los parametros no se pudieron validar';
										$mensajes = array('tipoMensaje' => $tipo ,'mensajeAMostrar'=> $mensaje);
										$view = new AtencionView();
										$consulta = new Consulta();
										$motivo = $consulta->motivos();
										$tratamiento = $consulta->tratamiento();
										$acompanamiento = $consulta->acompanamiento();
										//$instituciones = $consulta->instituciones();
										$instModel = new ApiInstituciones;
										$json = $instModel->ObtenerInstituciones();
										$instituciones=json_decode($json, true);
										$view->viewAtencion($mensajes,$motivo,$tratamiento,$acompanamiento,$instituciones,$rol);
									}
								}
								else{
										
										$mensaje='Los parametros no se pudieron validar, no pueden ser vacios!';
										
										$tipo=0;
										$mensajes = array('tipoMensaje' => $tipo ,'mensajeAMostrar'=> $mensaje);
										$view = new AtencionView();
										$consulta = new Consulta();
										$motivo = $consulta->motivos();
										$tratamiento = $consulta->tratamiento();
										$acompanamiento = $consulta->acompanamiento();
										//USO DE LA API
										$instModel = new ApiInstituciones;
										$json = $instModel->ObtenerInstituciones();
										$instituciones=json_decode($json, true);
										$view->viewAtencion($mensajes,$motivo,$tratamiento,$acompanamiento,$instituciones,$rol);
								}
						}
						else{

							$view = new UsuarioView();
							$tipo=0;
							$mensaje='El usuario no dispone permisos necesarios para realizar esta acción';
							$mensajes = array('tipoMensaje' => $tipo ,'mensajeAMostrar'=> $mensaje);
							//$template = $twig->loadTemplate('backend.twig.html');
							//echo $template->render(array('nombre'=>$usuario,'rol'=>$rol,'mensajeTipo'=>'ERROR','mensajeError'=>$mensaje));
							$view->viewHomePublic($mensajes);
						}
					}
					else{

						$loginview = new LoginView();
						$loginview->Index("¡Error! El usuario debe estar logeado en el sistema!!",1,null);
					}

			}
			public function eliminarConsulta() {
				//session_start();
				if(isset($_SESSION['usuario'])){ //si esta iniciada la sesion

						$usuario = $_SESSION['usuario'];
						$rol = $_SESSION['rol'];
						//$rol = $_SESSION['rol'];

						$funciones = new Funciones();
						$acceso = $funciones->validarAcceso($_SESSION,'usuario_baja'); //atencion_show VALIDO EL ACCESO PARA EL USUARIO Y LA ACCION
					
						if($acceso){ //SI TIENE PERMISO PARA ESTE ACCION
								$idConsulta = $_GET['id'];
								$pagina =1;
								$tipo=0;
								$mensaje="ERROR, No se puede eliminar un parametro vacio!!";
								$consulta = new Consulta();
								if(	isset($idConsulta) && !empty($idConsulta)){
										
										//elimino datos
										
										$consulta->borrarConsulta($idConsulta);
										//$view = new UsuarioView();
										$tipo=1;
										$mensaje='"Se eliminó con éxito la consulta!!!!';
										$mensajes=array('tipoMensaje' => $tipo ,'mensajeAMostrar'=> $mensaje);
	//										$view->viewHomePublic($rol,$mensajes);

								}
								// llama	r función para realizar la recopilación de datos y números de página
								
								
								$lista_paginada = $consulta->paginar_registro($pagina);
									// verificamos que no sea la última pagina
								if($lista_paginada['nTPaginas'] < $pagina ){
										$pagina = $lista_paginada['nTPaginas'];
										$lista_paginada = $consulta->paginar_registro($pagina);
								}
								// creamos variables que contengan la página siguiente y página anterior
								// Calculamos pagina siguiente y anterior
								$paginaSiguiente = $pagina +1;
								$paginaAnterior	= $pagina -1;
								//$parametros['rolesUserSistema'] = $rol;
								$parametros['consultas'] = $lista_paginada['listaRegistro'];
								$parametros['paginas'] = $lista_paginada['paginas'];
								$parametros['pagina_siguiente'] = $paginaSiguiente;
								$parametros['pagina_anterior'] = $paginaAnterior;
								$parametros['ultima_pagina'] = $lista_paginada['nTPaginas'];
								$parametros['pagina_actual'] = 1;
								$view = new AtencionView();
								$consulta = new Consulta();
								
								$motivo = $consulta->motivos();
								$tratamiento = $consulta->tratamiento();
								$acompanamiento = $consulta->acompanamiento();
								//USO DE LA API
								$instModel = new ApiInstituciones;
								$json = $instModel->ObtenerInstituciones();
								$instituciones=json_decode($json, true);
								$consultas = $consulta->getAllConsultas();
								
								
								$mensajes = array('tipoMensaje' => $tipo ,'mensajeAMostrar'=> $mensaje);
								//$view->viewAtencionlistar($motivo,$tratamiento,$acompanamiento,$instituciones,$consultas);
								$view->viewAtencionlistar($mensajes,$motivo,$tratamiento,$acompanamiento,$instituciones,$parametros,$rol);
						}
						else{

							$view = new UsuarioView();
							$tipo=0;
							$mensaje='El usuario no dispone permisos necesarios para realizar esta acción';
							$mensajes=array('tipoMensaje' => $tipo ,'mensajeAMostrar'=> $mensaje);
							$view->viewHomePublic($rol,$mensajes);
						}
					}
					else{

						$loginview = new LoginView();
						$loginview->Index("¡Error! El usuario debe estar logeado en el sistema!!",1,null);
					}

			}
			public function showEditarConsulta() {
				//session_start();
				if(isset($_SESSION['usuario'])){ //si esta iniciada la sesion

						$usuario = $_SESSION['usuario'];
						$rol = $_SESSION['rol'];
						//$rol = $_SESSION['rol'];

						$funciones = new Funciones();
						$acceso = $funciones->validarAcceso($_SESSION,'usuario_edit'); //atencion_show VALIDO EL ACCESO PARA EL USUARIO Y LA ACCION
					
						if($acceso){ //SI TIENE PERMISO PARA ESTE ACCION
								
								if (isset($_GET['id']) and !empty($_GET['id'])){
									$id_consulta=$_GET['id'];
									
									$consulta = new Consulta();
									$paciente = new Paciente();
									$view = new AtencionView();
									$motivo = $consulta->motivos();
									$tratamiento = $consulta->tratamiento();
									$acompanamiento = $consulta->acompanamiento();
									$instituciones = $consulta->instituciones();
									$u_consulta = $consulta->buscarConsulta($id_consulta);

									$u_paciente = $paciente->obtenerPacientePorId($u_consulta->paciente_id);
									$mensajes=array();
									$view->viewModificacionAtencion($mensajes,$u_consulta,$u_paciente,$motivo,$tratamiento,$acompanamiento,
										$instituciones,$rol);




								}
								else{
									
									$view = new UsuarioView();
									$tipo=0;
									$mensaje='Los parametros no se pudieron validar, no pueden ser vacios';
									
									$mensajes=array('tipoMensaje' => $tipo ,'mensajeAMostrar'=> $mensaje);
									$view->viewHomePublic($rol,$mensajes);
								}
								
						}
						else{

							$view = new UsuarioView();
							$tipo=0;
							$mensaje='El usuario no dispone permisos necesarios para realizar esta acción';
							//$template = $twig->loadTemplate('backend.twig.html');
							//echo $template->render(array('nombre'=>$usuario,'rol'=>$rol,'mensajeTipo'=>'ERROR','mensajeError'=>$mensaje));
							$mensajes=array('tipoMensaje' => $tipo ,'mensajeAMostrar'=> $mensaje);
							$view->viewHomePublic($rol,$mensajes);
						}
					}
					else{

						$loginview = new LoginView();
						$loginview->Index("¡Error! El usuario debe estar logeado en el sistema!!",1,null);
					}

			}
			public function editarConsulta() {
				//session_start();
				if(isset($_SESSION['usuario'])){ //si esta iniciada la sesion

						$usuario = $_SESSION['usuario'];
						$rol = $_SESSION['rol'];
						//$rol = $_SESSION['rol'];

						$funciones = new Funciones();
						$acceso = $funciones->validarAcceso($_SESSION,'usuario_edit'); //atencion_show VALIDO EL ACCESO PARA EL USUARIO Y LA ACCION
					
						if($acceso){ //SI TIENE PERMISO PARA ESTE ACCION
								
								if (isset($_POST['consulta_id'])and isset($_POST['nombre'])and isset($_POST['apellido']) and isset($_POST['dni']) and isset($_POST['FechaDeTurno']) and isset($_POST['Motivo']) 
									and isset($_POST['Derivacion'])and isset($_POST['Tratamientofarmacologico']) and  isset($_POST['acompanamiento'])
									){
									$params=ARRAY($_POST['nombre'],$_POST['apellido'],$_POST['dni'],$_POST['FechaDeTurno'],$_POST['Motivo'],$_POST['Derivacion'],$_POST['Tratamientofarmacologico'],
									$_POST['acompanamiento']);
									//$resul = $funciones->validar($params);
									//die($resul);diagnostico
									
									$id_consulta = $_POST['consulta_id'];
									if ($funciones->validar($params)){
										
										
										if (!isset($_POST['internacion'])){
											$inter = 0;
										}else{
											$inter = 1;
										}
										
										$params_S=ARRAY(0 => $funciones->sanitizar($_POST['nombre']),1 =>$funciones->sanitizar($_POST['apellido']),
										2 =>$funciones->sanitizar($_POST['dni']),3 =>$funciones->sanitizar($_POST['FechaDeTurno']),
										4 =>$funciones->sanitizar($_POST['Motivo']),5 =>$funciones->sanitizar($_POST['Derivacion']),6 =>$funciones->sanitizar($_POST['Tratamientofarmacologico']),
										7 =>$funciones->sanitizar($inter),8 =>$funciones->sanitizar($_POST['diagnostico']),9 =>$funciones->sanitizar($_POST['observaciones']),
										10 =>$funciones->sanitizar($_POST['tratarcon']),11 =>$funciones->sanitizar($_POST['acompanamiento']));
										
										$consulta = new Consulta();
										//var_dump($params_S[5]);
										//var_dump($id_consulta,$params_S[3],$params_S[4],$params_S[5],$params_S[10],$params_S[7],$params_S[8],$params_S[9],$params_S[6],$params_S[11]);
										//die();
										$consulta->updateConsulta($id_consulta, $params_S[3], $params_S[4], $params_S[5], $params_S[10], $params_S[7], $params_S[8], $params_S[9], $params_S[6], $params_S[11]);
										//header('Location:/index.php?ctl=showAtencionMedica'); exit();
										$view = new AtencionView();
										$consulta = new Consulta();
										$paciente = new Paciente();
										$motivo = $consulta->motivos();
										$tratamiento = $consulta->tratamiento();
										$acompanamiento = $consulta->acompanamiento();
										//USO DE LA API
										$instModel = new ApiInstituciones;
										$json = $instModel->ObtenerInstituciones();
										$instituciones=json_decode($json, true);
										//$instituciones=$consulta->instituciones();
										$u_consulta = $consulta->buscarConsulta($id_consulta);

										$u_paciente = $paciente->obtenerPacientePorId($u_consulta->paciente_id);

										$tipo=1;
										$mensaje='Se realizó con éxito la modificación!!';
									
										$mensajes=array('tipoMensaje' => $tipo ,'mensajeAMostrar'=> $mensaje);
										$view->viewModificacionAtencion($mensajes,$u_consulta,$u_paciente,$motivo,$tratamiento,$acompanamiento,
										$instituciones,$rol);


									}
									else{
										$consulta = new Consulta();
										$paciente = new Paciente();
										$motivo = $consulta->motivos();
										$tratamiento = $consulta->tratamiento();
										$acompanamiento = $consulta->acompanamiento();
										//USO DE LA API
										$instModel = new ApiInstituciones;
										$json = $instModel->ObtenerInstituciones();
										$instituciones=json_decode($json, true);
										//$instituciones=$consulta->instituciones();
										$u_consulta = $consulta->buscarConsulta($id_consulta);
										
										$u_paciente = $paciente->obtenerPacientePorId($u_consulta->paciente_id);
										$view = new UsuarioView();
										$tipo=0;
										$mensaje='Los parametros no se pudieron validar';
										$mensajes=array('tipoMensaje' => $tipo ,'mensajeAMostrar'=> $mensaje);
										$view->viewModificacionAtencion($mensajes,$u_consulta,$u_paciente,$motivo,$tratamiento,$acompanamiento,
										$instituciones,$rol);
									}
								}
								else{
									$view = new UsuarioView();
							$tipo=0;
							$mensaje='El usuario no dispone permisos necesarios para realizar esta acción';
							$mensajes=array('tipoMensaje' => $tipo ,'mensajeAMostrar'=> $mensaje);
							//$template = $twig->loadTemplate('backend.twig.html');
							//echo $template->render(array('nombre'=>$usuario,'rol'=>$rol,'mensajeTipo'=>'ERROR','mensajeError'=>$mensaje));
							$view->viewHomePublic($rol,$mensajes);
								}
								
						}
						else{

							$view = new UsuarioView();
							$tipo=0;
							$mensaje='El usuario no dispone permisos necesarios para realizar esta acción';
							$mensajes=array('tipoMensaje' => $tipo ,'mensajeAMostrar'=> $mensaje);
							//$template = $twig->loadTemplate('backend.twig.html');
							//echo $template->render(array('nombre'=>$usuario,'rol'=>$rol,'mensajeTipo'=>'ERROR','mensajeError'=>$mensaje));
							$view->viewHomePublic($rol,$mensajes);
						}
					}
					else{

						$loginview = new LoginView();
						$loginview->Index("¡Error! El usuario debe estar logeado en el sistema!!",1,null);
					}

			}
			public function listarConsultas() {
				//session_start();
				if(isset($_SESSION['usuario'])){ //si esta iniciada la sesion

						$usuario = $_SESSION['usuario'];
						$rol = $_SESSION['rol'];
						//$rol = $_SESSION['rol'];

						$funciones = new Funciones();
						$acceso = $funciones->validarAcceso($_SESSION,'usuario_list'); //atencion_show VALIDO EL ACCESO PARA EL USUARIO Y LA ACCION
					
						if($acceso){ //SI TIENE PERMISO PARA ESTE ACCION
								$pagina =1;
								if(isset($_GET['id']) && !empty($_GET['id'])){
									$pagina = $_GET['id'];


								}
								// llamar función para realizar la recopilación de datos y números de página
									$rolesUserSistema = $_SESSION['rol'];
									$consulta = new Consulta();
									$lista_paginada = $consulta->paginar_registro($pagina);
									// verificamos que no sea la última pagina
									if($lista_paginada['nTPaginas'] < $pagina ){
											$pagina = $lista_paginada['nTPaginas'];
											$lista_paginada = $consulta->paginar_registro($pagina);
										 }
									 // creamos variables que contengan la página siguiente y página anterior
									 // Calculamos pagina siguiente y anterior
									$paginaSiguiente = $pagina +1;
									$paginaAnterior	= $pagina -1;
									//$parametros['rolesUserSistema'] = $rol;
									$parametros['consultas'] = $lista_paginada['listaRegistro'];
									$parametros['paginas'] = $lista_paginada['paginas'];
									$parametros['pagina_siguiente'] = $paginaSiguiente;
									$parametros['pagina_anterior'] = $paginaAnterior;
									$parametros['ultima_pagina'] = $lista_paginada['nTPaginas'];
									$parametros['pagina_actual'] = 1;
									//$viewUser = new UsuarioView();
									//$viewUser->showListUser($parametros);
									$view = new AtencionView();
									
									$motivo = $consulta->motivos();
									$tratamiento = $consulta->tratamiento();
									$acompanamiento = $consulta->acompanamiento();
									//USO DE LA API
									$instModel = new ApiInstituciones;
									$json = $instModel->ObtenerInstituciones();
									$instituciones=json_decode($json, true);
									
									$mensajes=array();
									$view->viewAtencionlistar($mensajes,$motivo,$tratamiento,$acompanamiento,$instituciones,$parametros,$rolesUserSistema);
								
						}
						else{

							$view = new UsuarioView();
							$tipo=0;
							$mensaje='El usuario no dispone permisos necesarios para realizar esta acción';
							$mensajes=array('tipoMensaje' => $tipo ,'mensajeAMostrar'=> $mensaje);
							$view->viewHomePublic($mensajes);
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

					$user = new Paciente();
					$searching=$user->buscarPaciente($search);
					if ($searching != null ){
						echo json_encode($searching);
					}

				}
			}
			public function searchPaciente(){

				if(isset($_POST['search'])){
					$idUser = $_POST['search'];
					
					$user = new Paciente();
					$userSearch=$user->getPacienteById($idUser);
					//die('lalalalalalaalalal');
					echo json_encode($userSearch);
					}

				}
			public function getInstitucionesId(){

				if(isset($_POST['search'])){
					$idUser = $_POST['search'];
					
					$consulta = new Consulta();
					$insti=$consulta->getInstitucionesIdUser($idUser);

					//die('lalalalalalaalalal');
					echo json_encode($insti);
					}

				}
}