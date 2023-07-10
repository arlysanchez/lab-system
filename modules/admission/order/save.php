<?php
 require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
error_reporting(0);

   $fecha =date("Y-m-d");
   $id_persona = $_POST['id_persona'];
   $id_person = $_POST['id_person'];
   $nombre = $_POST['nombre'];
   $apellido_pat = $_POST['apellido_pat'];
   $apellido_mat = $_POST['apellido_mat'];
   $id_tipo_doc = $_POST['id_tipo_doc'];
   $num_doc = $_POST['num_doc'];
   $fecha_nac = $_POST['fecha_nac'];
   $genero = $_POST['genero'];
   $direccion= $_POST['direccion'];
   $num_celular = $_POST['num_celular'];
   $estado    =$_POST['estado'];
   $boton= $_POST['boton'];
   $flag= $_POST['flag'];


switch ($boton) {
	case 'Registrar paciente':
    $sql22 = "Select * from tbl_persona where num_doc = $num_doc";
    $quer22 = $idb->prepare($sql22);
    $quer22 ->execute();
    $rowcount = $quer22->rowCount();
    if ($rowcount >= 1) {
      echo "E";
    }else{

    $sql = "INSERT INTO tbl_persona (nombre,apellido_pat,apellido_mat,id_tipo_doc,num_doc,fecha_nac,genero,direccion,num_celular, estado) values(?, ?, ?, ?, ?, ?, ?,?,?,?)";
    $query = $idb->prepare($sql);
    $result= $query->execute(array($nombre, $apellido_pat, $apellido_mat, $id_tipo_doc, $num_doc, $fecha_nac, $genero,$direccion, $num_celular,$estado));
       if($result){
    	echo $flag;
    }else{
    	echo "error";
    }

    $sql8 = "SELECT MAX(id_persona)persona FROM tbl_persona";
       $query8 = $idb->prepare($sql8);
       $query8->execute();
       $resultado1 = $query8->fetchAll();
            foreach ($resultado1 as $value) {
             $id_paciente_recuperado = $value['persona'];
          $sql11 = "INSERT INTO tbl_patient (id_person , status) values( ?, ?)";
          $query11 = $idb->prepare($sql11);
          $result =$query11->execute(array($id_paciente_recuperado, 1)); 
            
        }


    }
   
		break;

	case 'Actualizar':
  $sql = "UPDATE tbl_persona  set nombre = ?,apellido_pat = ?,apellido_mat = ?,id_tipo_doc = ?,num_doc = ?,fecha_nac = ?,genero = ?,direccion = ?,num_celular = ?, estado = ? WHERE id_persona = ?";
      $query = $idb->prepare($sql);
       $result = $query->execute(array($nombre, $apellido_pat, $apellido_mat, $id_tipo_doc, $num_doc, $fecha_nac, $genero,$direccion, $num_celular,$estado, $id_persona));
       if($result){
          echo "OK";
      }else{
          echo "error";
      }
	 
		break;
    
    case 'Registrar':

          $sql17 = "INSERT INTO tbl_patient (id_person, status) values(?, ?)";
         $query17= $idb->prepare($sql17);
          $result= $query17->execute(array($id_persona, 1));
       if($result){
      echo $flag;
    }else{
      echo "error";
    }
      break;
}

?>
