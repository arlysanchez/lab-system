<?php
 require_once '../../../sesion.php';
require '../../../config/conexion.php';
error_reporting(0);
$idb = $conn;

$id_type_area = $_POST['id_type_area'];
$description = $_POST['description'];
$status = $_POST['status'];
$boton =  $_POST['boton'];
//delete
$boton =  $_REQUEST['boton'];
$id_type_area1 = $_REQUEST['id_type_area'];

switch ($boton) {
	case 'Registrar':
	$sql = "INSERT INTO tbl_type_area (description, status) values(?, ?)";
    $query = $idb->prepare($sql);
    $result= $query->execute(array($description, $status));
    if($result){
    	echo "OK";
    }else{
    	echo "error";
    }
	break;
	case 'Actualizar':	
	$sql = "UPDATE tbl_type_area  set description = ?, status = ? WHERE id_type_area = ?";
    $query = $idb->prepare($sql);
    $result=$query->execute(array($description, $status, $id_type_area));
    if($result){
    	echo "OK";
    }else{
    	echo "error";
    }
		break;

    case 'delete_typeAreas':
        if (isset($_REQUEST['id_type_area'])) {
            $sql = "DELETE FROM tbl_type_area WHERE id_type_area = '$id_type_area1'";
            $q = $idb->prepare($sql);
            $q->execute();
        }
        break;
  }

   

?>
