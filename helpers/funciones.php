<?php

    class Funciones{

        public function sanitizar($dato){
            $dato=strip_tags($dato);
            return $dato;
          }
        public function validar($params){
         $result=true;
         while(($result)&&(list ($key, $val) = each($params))){
             if((empty($val))or($val==null)){
                 $result=false;
             }
         }
         return $result;
       }
       public function validarAcceso($session,$accion)
       {

          foreach ($session['permisos'] as $permiso) {


              if($permiso->nombre == $accion | $permiso->nombre == 'todos'){

                return true;
              }

            // code...
          }
          return false;

          //$modelUusuario = new Usuario;
          //$usuario=$modelUusuario->getUsuarioByIdAccion($idUsu,$accion);


          //return $usuario;
       }
       function paginar_registro($paginaActual, $consulta){
       // $paginaActual = pagina actual a mostrar
  	    // array qeu contienen los datos
         $porPagina = 1;
  	     $paginasLista 		= array();
  	     $listaRegistro 		= array();
  	      // pasar a entero el número de página
  	      $nTPaginas = (int)$paginaActual;
  	      // Validar que la página sea uno en caso de un menor que este
  	      if($nTPaginas < 1)
  		      $nTPaginas = 1;

  	      $offSet = ($nTPaginas-1)*$porPagina;
          $consulta_General = "SELECT SQL_CALC_FOUND_ROWS u.username, u.first_name, u.last_name, u.activo,
              u.email, u.id FROM usuario u LIMIT $offSet,$porPagina";
  	      $consulta_Total = "SELECT FOUND_ROWS() AS Total";
  	      // ejecutamos querys

  	      $consulta_Filas = $this->db->prepare($consulta_General);
  	      $consulta_FilasTotal = $this->db->prepare($consulta_Total);
          $consulta_Filas->execute();
          $consulta_FilasTotal->execute();
  	      // retornamos objeto
  	      $rowsTotal = $consulta_FilasTotal ->fetchObject();
          //retornamos la consulta en un array
  	      $listaRegistro = $consulta_Filas->fetchAll();
   	      // Total de filas
  	      $totalFilas = $rowsTotal->Total;
          $i=0;
          foreach ($listaRegistro as $user){
            $i++;
            $roles[$i]=($user["roles"]);
          }
          $listaRegistro[0]["roles"]=$roles;

  	      // Calculamos el número total de páginas
  	      $nTPaginas = ceil($totalFilas/$porPagina);
  	      $paginas = array();
  	      // armamos links ?pag=1
  	      for($no=1;$no<=$nTPaginas;$no++){
  		        $paginas[$no] = '&id='.$no;
  	       }

  	     $paginasLista['paginas'] 		= $paginas;
  	     $paginasLista['listaRegistro'] 	= $listaRegistro;
  	     $paginasLista['nTPaginas'] 		= $nTPaginas;
  	      return $paginasLista;
        }
    }
