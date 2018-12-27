<?php
require_once "./model/Model.php";


class Consulta extends Model{

  public function updateConsulta($id, $fecha, $motivo_id, $derivacion_id, $articulacion_con_instituciones, 
    $internacion, $diagnostico, $observaciones, $tratamiento_farmacologico_id, $acompanamiento_id)
   {
     try{
      
      $query= $this->db->prepare("UPDATE paciente SET apellido=:apellido ,nombre=:nombre ,fecha_nac=:fecha_nac ,lugar_nac=:lugar_nac , 
      localidad_id=:localidad_id, region_sanitaria_id=:region_sanitaria_id ,domicilio=:domicilio ,genero_id=:genero_id, tiene_documento=:tiene_documento ,
      tipo_doc_id=:tipo_doc_id ,numero=:numero ,tel=:tel ,nro_carpeta=:nro_carpeta ,obra_social_id=:obra_social_id 
      WHERE id = :id");

      $query = $this->db->prepare("UPDATE consulta SET  fecha=:fecha, motivo_id=:motivo_id, derivacion_id=:derivacion_id,
       articulacion_con_instituciones=:articulacion_con_instituciones, internacion=:internacion, diagnostico=:diagnostico, 
       observaciones=:observaciones, tratamiento_farmacologico_id=:tratamiento_farmacologico_id, acompanamiento_id=:acompanamiento_id
        WHERE  id=:id");
      
      
      $query->bindParam(":fecha", $fecha,PDO::PARAM_STR);
      $query->bindParam(":motivo_id", $motivo_id,PDO::PARAM_INT);
      $query->bindParam(":derivacion_id", $derivacion_id,PDO::PARAM_INT);
      $query->bindParam(":articulacion_con_instituciones", $articulacion_con_instituciones,PDO::PARAM_STR);
      $query->bindParam(":internacion", $internacion,PDO::PARAM_STR);
      $query->bindParam(":diagnostico", $diagnostico,PDO::PARAM_STR);
      $query->bindParam(":observaciones", $observaciones,PDO::PARAM_STR);
      $query->bindParam(":tratamiento_farmacologico_id", $tratamiento_farmacologico_id,PDO::PARAM_INT);
      $query->bindParam(":acompanamiento_id", $acompanamiento_id,PDO::PARAM_INT);
      $query->bindParam(":id", $id,PDO::PARAM_INT);
      $query->execute();
      
    
    }

    catch(PDOException $e) {
      
      echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

   }

  public function insertConsulta($paciente_id, $fecha, $motivo_id, $derivacion_id, $articulacion_con_instituciones, 
    $internacion, $diagnostico, $observaciones, $tratamiento_farmacologico_id, $acompanamiento_id)
   {
     try{
      
     

      $query = $this->db->prepare("INSERT INTO consulta ( paciente_id, fecha, motivo_id, derivacion_id,
       articulacion_con_instituciones, internacion, diagnostico, observaciones, tratamiento_farmacologico_id,
        acompanamiento_id) VALUES ( :paciente_id, :fecha, :motivo_id, :derivacion_id, :articulacion_con_instituciones, :internacion, :diagnostico, 
          :observaciones, :tratamiento_farmacologico_id, :acompanamiento_id)");
      $query->bindParam(':paciente_id', $paciente_id);
      $query->bindParam(':fecha', $fecha);
      $query->bindParam(':motivo_id', $motivo_id);
      $query->bindParam(':derivacion_id', $derivacion_id);
      $query->bindParam(':articulacion_con_instituciones', $articulacion_con_instituciones);
      $query->bindParam(':internacion', $internacion);
      $query->bindParam(':diagnostico', $diagnostico);
      $query->bindParam(':observaciones', $observaciones);
      $query->bindParam(':tratamiento_farmacologico_id', $tratamiento_farmacologico_id);
      $query->bindParam(':acompanamiento_id', $acompanamiento_id);
      $query->execute();
      
    
    }

    catch(PDOException $e) {
      
      echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

   }
   function motivos(){
    try{

      $query = $this->db->prepare("SELECT * FROM motivo_consulta");
      $query->execute();
        while ($rol =$query->fetchObject()){
            $roles[]=$rol;
        } 
        return $roles;
      }
      catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
      }
  }
  function tratamiento(){
    try{

      $query = $this->db->prepare("SELECT * FROM tratamiento_farmacologico");
      $query->execute();
        while ($rol =$query->fetchObject()){
            $roles[]=$rol;
        } 
        return $roles;
      }
      catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
      }
  }
   function acompanamiento(){
    try{

      $query = $this->db->prepare("SELECT * FROM acompanamiento");
      $query->execute();
        while ($rol =$query->fetchObject()){
            $roles[]=$rol;
        } 
        return $roles;
      }
      catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
      }
  }
  function instituciones(){
    try{

      $query = $this->db->prepare("SELECT * FROM institucion");
      $query->execute();
        while ($rol =$query->fetchObject()){
            $roles[]=$rol;
        } 
        return $roles;
      }
      catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
      }
  }
  function getInstitucionesIdUser($idUser){
    try{
        $roles=array();
        $query = $this->db->prepare("SELECT c.id as id, c.internacion as internacion, a.nombre as acompanamientoNombre, tf.nombre as tratamientoNombre, m.nombre as nombreMotivo,
         c.fecha as fecha, i.telefono as telefono, i.nombre as nombre , i.director as director, i.nombre as nombreDerivacion,
         i.latitud as latitud, i.longitud as logitud FROM consulta c INNER JOIN institucion i on i.id = c.derivacion_id 
         INNER JOIN motivo_consulta m on c.motivo_id = m.id INNER JOIN tratamiento_farmacologico tf on c.tratamiento_farmacologico_id = tf.id
         INNER JOIN acompanamiento a on a.id  = c.acompanamiento_id 
        WHERE c.paciente_id=?");
        $query->execute(array($idUser));
        //while ($rol =$query->fetchObject()){
        //    $roles[]=$rol;
        //} 
        return $query->fetchAll();
      }
      catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
      }
  }
  function getAllConsultas(){
    try{
        $consulta=array();
        $query = $this->db->prepare("SELECT c.id as id, c.internacion as internacion, a.nombre as acompanamientoNombre, tf.nombre as tratamientoNombre, m.nombre as nombreMotivo,
         c.fecha as fecha, i.telefono as telefono, i.nombre as nombre , i.director as director, i.nombre as nombreDerivacion,
         i.latitud as latitud, i.longitud as logitud FROM consulta c INNER JOIN institucion i on i.id = c.derivacion_id 
         INNER JOIN motivo_consulta m on c.motivo_id = m.id INNER JOIN tratamiento_farmacologico tf on c.tratamiento_farmacologico_id = tf.id
         INNER JOIN acompanamiento a on a.id  = c.acompanamiento_id 
        ");
        $query->execute();
        while ($rol =$query->fetchObject()){
            $consulta[]=$rol;
        } 
        return $consulta;
      }
      catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
      }
  }
  function borrarConsulta($id){
    try{
      $query = $this->db->prepare("DELETE FROM consulta WHERE id=?");
      $query->execute(array($id));

    }
    catch(PDOException $e){
      echo '{"ERROR":{"text":'. $e->getMessage() .'}}';
    }
  }
  function buscarConsulta($id){
    try{
      $query = $this->db->prepare("SELECT * FROM consulta WHERE id=?");
       $query->execute(array($id));
       return $query->fetchObject();

    }
    catch(PDOException $e){
      echo '{"ERROR":{"text":'. $e->getMessage() .'}}';
    }
  }
  function buscarPaciente($id){
    $consulta=array();
    try{
      $query = $this->db->prepare("SELECT p.nombre as nombre , p.apellido as apellido, p.dni as dni FROM consulta c INNER JOIN paciente p on p.id = c.paciente_id WHERE c.id=?");
      $query->execute();
        while ($rol =$query->fetchObject()){
            $consulta[]=$rol;
        } 
        return $consulta;

    }
    catch(PDOException $e){
      echo '{"ERROR":{"text":'. $e->getMessage() .'}}';
    }
  }
  function paginar_registro($paginaActual){
     // $paginaActual = pagina actual a mostrar
      // array qeu contienen los datos
      //obtengo cantidad de paginas a listar desde la configuracion
       $conf = new Configuracion;
       $cantidadRegistrosPorListado = $conf->getConfiguracion("cantidad_elementos_pagina");
       $porPagina =$cantidadRegistrosPorListado;
       $paginasLista    = array();
       $listaRegistro     = array();
        // pasar a entero el número de página
        $nTPaginas = (int)$paginaActual;
        // Validar que la página sea uno en caso de un menor que este
        if($nTPaginas < 1)
          $nTPaginas = 1;

        $offSet = ($nTPaginas-1)*$porPagina;

        $consulta_General = "SELECT c.id as id, c.internacion as internacion, a.nombre as acompanamientoNombre, tf.nombre as tratamientoNombre, m.nombre as nombreMotivo,
         c.fecha as fecha, i.telefono as telefono, i.nombre as nombre , i.director as director, i.nombre as nombreDerivacion,
         i.latitud as latitud, i.longitud as logitud FROM consulta c INNER JOIN institucion i on i.id = c.derivacion_id 
         INNER JOIN motivo_consulta m on c.motivo_id = m.id INNER JOIN tratamiento_farmacologico tf on c.tratamiento_farmacologico_id = tf.id
         INNER JOIN acompanamiento a on a.id  = c.acompanamiento_id LIMIT $offSet,$porPagina
        ";
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

       $paginasLista['paginas']     = $paginas;
       $paginasLista['listaRegistro']   = $listaRegistro;
       $paginasLista['nTPaginas']     = $nTPaginas;
        return $paginasLista;
      }
}