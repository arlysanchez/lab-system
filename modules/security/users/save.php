<?php
 require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
error_reporting(0);
//echo '<pre>';
//print_r($_POST);

   $fecha =date("Y-m-d");
   $id_user_created = $_SESSION['id_tipousuario'];
   $id_persona = $_POST['id_persona'];
   $usuario = $_POST['usuario'];
  $id_tipousuario = $_POST['id_tipousuario'];
  $estado = $_POST['estado'];
  $boton= $_POST['boton'];
  $clave= $_POST['clave'];
  $id_usuario = $_POST['id_usuario'];

  /*new user*/
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
   


switch ($boton) {
	case 'Registrar':
	  
		$password = password_hash($clave, PASSWORD_DEFAULT);
    $sql = "INSERT INTO tbl_usuarios (id_persona,usuario,clave,id_tipousuario,fecha_registro,estado,id_user_created) values(?, ?, ?, ?, ?, ?, ?)";
    $query = $idb->prepare($sql);
    $result= $query->execute(array($id_persona, $usuario, $password, $id_tipousuario, $fecha, $estado, $id_user_created));
       if($result){
    	echo "OK";
    }else{
    	echo "error";
    }
   
		break;
	case 'Actualizar':
	 $sql = "UPDATE tbl_usuarios  set id_persona = ?, usuario = ?, id_tipousuario = ?, estado = ?  WHERE id_usuario = ?";
    $query = $idb->prepare($sql);
    $result= $query->execute(array($id_persona, $usuario, $id_tipousuario, $estado, $id_usuario));
     if($result){
    	echo "OK";
      }else{
    	echo "error";
      }
		break;

case 'Registrar usuario':
   $sql1 = "Select * from tbl_persona where num_doc = $num_doc";
    $quer1 = $idb->prepare($sql1);
    $quer1 ->execute();
    $rowcount = $quer1->rowCount();
    if ($rowcount >= 1) {
      echo "E";
     }else{
   $sql = "INSERT INTO tbl_persona (nombre,apellido_pat,apellido_mat,id_tipo_doc,num_doc,fecha_nac,genero,direccion,num_celular, estado) values(?, ?, ?, ?, ?, ?, ?,?,?,?)";
    $query = $idb->prepare($sql);
    $result= $query->execute(array($nombre, $apellido_pat, $apellido_mat, $id_tipo_doc, $num_doc, $fecha_nac, $genero,$direccion, $num_celular,$estado));
      if($result){
      echo "OK";
    }else{
      echo "error";
        }

    }
  break;
    
}

?>
