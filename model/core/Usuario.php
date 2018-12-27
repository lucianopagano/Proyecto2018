<?php
require_once "./model/Model.php";

class Usuario extends Model{

  /* User Login */
  function userLogin($usernameEmail,$password)
  {
    try{

      //preparo la consulta a realizar
      $stmt = $this->db->prepare('SELECT id FROM usuario WHERE (username=:usernameEmail or email=:usernameEmail) AND password=:password AND activo=1');
      //bindeo los parametros
      $stmt->bindParam("usernameEmail", $usernameEmail,PDO::PARAM_STR) ;
      $stmt->bindParam("password", $password,PDO::PARAM_STR) ;
      //excuto la consulta
      $stmt->execute();
      $count=$stmt->rowCount();
      $data=$stmt->fetch(PDO::FETCH_OBJ);


      if($count == 1){
        return true;
      }
      else{
        return false;
      }
    }
    catch(PDOException $e) {
      echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
  }
  function getAllRoles(){
    $query = $this->db->prepare("SELECT r.nombre, r.id
                                FROM rol r");

    $query->execute();
    while ($rol =$query->fetchObject()){
        $roles[]=$rol;
    }
    return $roles;
  }
  function getRoles($usuarioId){
    $query = $this->db->prepare("SELECT r.nombre, r.id
                                FROM rol r
                                INNER JOIN usuario_tiene_rol utr on r.id = utr.rol_id
                                WHERE utr.usuario_id = :usuarioId ");
    $query-> bindParam(":usuarioId",$usuarioId);
    $query->execute();
    $roles=array();
    while ($rol =$query->fetchObject()){
        $roles[]=$rol;
    }
    return $roles;
    
  }

  function siTieneRol($usuarioId,$rolNombre){

    $query = $this->db->prepare("SELECT r.id
                                FROM rol r
                                INNER JOIN usuario_tiene_rol utr on r.id = utr.rol_id
                                WHERE utr.usuario_id = :usuarioId and r.nombre = :rolNombre");
    $query->bindParam(":usuarioId",$usuarioId);
    $query->bindParam(":rolNombre",$rolNombre);
    $query->execute();
    if($query->rowCount() == 1){
      return true;
    }
    else{
      return false;
    }
  }
  function existeUsuario($usuarioNombre,$email){
    try{
    $query = $this->db->prepare("SELECT u.id
                                FROM usuario u
                                WHERE u.username = :username and u.email = :emil");
    $query->bindParam(":username",$usuarioNombre);
    $query->bindParam(":emil",$email);
    $query->execute();
    if($query->rowCount() == 1){
      return true;
    }
    else{
      return false;
    }
  }
  catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}';
  }
  }
  public function getUsuarioByIdAccion($idUsu,$accion)
  {
    try{

     $query = $this->db->prepare("SELECT * FROM usuario u INNER JOIN usuario_tiene_rol ur ON u.id=ur.usuario_id
                     INNER JOIN rol r ON r.id=ur.rol_id INNER JOIN rol_tiene_permiso re on r.id=re.rol_id INNER JOIN permiso p on re.permiso_id=p.id
                     WHERE (u.id=?) AND (p.nombre=? OR p.nombre='todos')");
     $query->execute(array($idUsu,$accion));

     $result=($query->fetchObject());


     return $result;
   }
   catch(PDOException $e) {
       echo '{"error":{"text":'. $e->getMessage() .'}}';
     }
  }
  function buscarUsuario($parametro){
    try{

      $query = $this->db->prepare('SELECT * FROM usuario u WHERE u.username LIKE :search');

    $query->execute(array(':search' => '%'.$parametro.'%'));

    if($query->rowCount() != 0){
      while ($usuario =$query->fetchObject()){
          $response[] = array("value"=>$usuario->id,"label"=>$usuario->username);
      }

      return $response;
    }
    else{
      return null;
    }
  }
  catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}';
  }
  }
  function getUsuario($usuarioNombre){
    try{

    $query = $this->db->prepare("SELECT *
                                FROM usuario u
                                WHERE u.username = :username ");
    $query->bindParam(":username",$usuarioNombre);
    $query->execute();
    if($query->rowCount() == 1){

      return ($query->fetchObject());
    }
    else{
      return null;
    }
  }
  catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}';
  }
  }
  function getUsuarioId($usuarioNombre){
    try{

    $query = $this->db->prepare("SELECT u.id
                                FROM usuario u
                                WHERE u.username = :username ");
    $query->bindParam(":username",$usuarioNombre);
    $query->execute();
    if($query->rowCount() == 1){
      return (($query->fetchObject())->id);
    }
    else{
      return null;
    }
  }
  catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}';
  }
  }
    public function getAddRoles($id, $role)
   {
     try{
        $query = $this->db->prepare("INSERT INTO usuario_tiene_rol( usuario_id, rol_id)
         VALUES ( :usuario_id, :rol_id)");
      $query->bindParam(':usuario_id', $id);
      $query->bindParam(':rol_id', $role);
      $query->execute();
         if($query->rowCount() == 1){

          return true;
          }
          else{
            return false;
          }
          }  
      catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}';
      }

    }
   
    public function getDeleteRoles($id)
   {
     try{
        if(!empty($id)){
            $query = $this->db->prepare("DELETE from usuario_tiene_rol where usuario_id=?");
            $query->execute(array($id));
            
            if($query->rowCount() == 1){

                return true;
            }
            else{
              return false;
            }  

        }
        else{
          return false;
        }
      }
      catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}';
      }


   
  }
  public function getUsuarioPermisos($id)
  {

     $query = $this->db->prepare("SELECT p.nombre
       FROM usuario u INNER JOIN usuario_tiene_rol ur ON u.id=ur.usuario_id
       INNER JOIN rol r ON r.id=ur.rol_id
       INNER JOIN rol_tiene_permiso re on r.id=re.rol_id
       INNER JOIN permiso p on re.permiso_id=p.id
       WHERE u.id=?");

     $query->execute(array($id));
     while ($permiso =$query->fetchObject()){
         $permisos[]=$permiso;
     }
     //$usuarioO=$query->fetchAll();

     return $permisos;
  }
  public function getUsuarioById($id)
  {
     /*$query = $this->db->prepare("SELECT u.username, u.first_name, u.last_name, u.activo, u.password,
       u.email, u.id, r.nombre as	roles, r.id as rId FROM usuario u INNER JOIN usuario_tiene_rol ur ON u.id=ur.usuario_id
                       INNER JOIN rol r ON r.id=ur.rol_id WHERE u.id=?");*/
      $query = $this->db->prepare("SELECT u.username, u.first_name, u.last_name,
        u.activo, u.password, u.email, u.id FROM usuario u WHERE u.id=?");

     $query->execute(array($id));
     $usuarioAll=$query->fetchObject();
/*
     $i=0;
     foreach ($usuarioAll as $user){
       $i++;
       $roles[$i]=($user["roles"]);
     }
     $usuarioAll[0]["roles"]=$roles;
*/
     return $usuarioAll;
  }
  public function getListarUsuarios()
   {
     try{
        $query = $this->db->prepare("SELECT u.username, u.first_name, u.last_name, u.activo,
          u.email, u.id FROM usuario u ORDER BY id DESC ");
        $query->execute();
        return $query->fetchAll();

        }
      catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}';
      }


   }

  public function insertUsuario($email,$username,$pass,$fname,$lname)
   {
     try{

       $activo=1;
       $update=gmDate("Y-m-d H:i:s");
       $created=gmDate("Y-m-d H:i:s");
      if (! $this->existeUsuario($username,$email)){

      $query = $this->db->prepare("INSERT INTO usuario( email, username, password, activo, updated_at,
         created_at, first_name, last_name)
         VALUES ( :email, :username, :pass, :act, :updat, :created, :first_name, :last_name)");
      $query->bindParam(':email', $email);
      $query->bindParam(':username', $username);
      $query->bindParam(':pass', $pass);
      $query->bindParam(':act', $activo);
      $query->bindParam(':updat', $update);
      $query->bindParam(':created', $created);
      $query->bindParam(':first_name', $fname);
      $query->bindParam(':last_name', $lname);
      $query->execute();
        return true;
      }
      else{
        return false;
      }
    }
    catch(PDOException $e) {
      echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

   }

   public function editUsuario($email,$username,$pass,$fname,$lname,$id,$activo)
   {
      try{

        
        $update=gmDate("Y-m-d H:i:s");
        //$created=gmDate("Y-m-d H:i:s");
        $query = $this->db->prepare("UPDATE usuario SET email=?, username=?, password=?,
        activo=?, updated_at=?, first_name=?, last_name=? WHERE id=?");
        $query->execute(array($email,$username,$pass,$activo,$update,$fname,$lname,$id));
    }
    catch(PDOException $e) {
      echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
   }



     public function deleteUsuario($id)
   {

     try{
      $this->getDeleteRoles($id);
      $query =  $this->db->prepare("DELETE FROM usuario WHERE id=? ");
      $query->execute(array($id));
      
    }
    catch(PDOException $e) {
      echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

   }
   // Paginación
     // $porPagina = catidad de elemento por pagina_actual
     function paginar_registro($paginaActual){
     // $paginaActual = pagina actual a mostrar
	    // array qeu contienen los datos
      //obtengo cantidad de paginas a listar desde la configuracion
       $conf = new Configuracion;
       $cantidadRegistrosPorListado = $conf->getConfiguracion("cantidad_elementos_pagina");
       $porPagina =$cantidadRegistrosPorListado;
	     $paginasLista 		= array();
	     $listaRegistro 		= array();
	      // pasar a entero el número de página
	      $nTPaginas = (int)$paginaActual;
	      // Validar que la página sea uno en caso de un menor que este
	      if($nTPaginas < 1)
		      $nTPaginas = 1;

	      $offSet = ($nTPaginas-1)*$porPagina;

        $consulta_General = "SELECT SQL_CALC_FOUND_ROWS u.username, u.first_name,
        u.last_name, u.activo, u.email, u.id  FROM usuario u  LIMIT $offSet,$porPagina";
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
