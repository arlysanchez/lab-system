<?php
 require_once '../../../sesion.php';
require '../../../config/conexion.php';
error_reporting(0);
$idb = $conn;

$description = $_POST['description'];
$id_type_area = $_POST['id_type_area'];
$id_type_sample = $_POST['id_type_sample'];
$status  = $_POST['status'];
$boton =   $_POST['boton'];

//delete
$boton =  $_REQUEST['boton'];


   switch ($boton) {
   	case 'Registrar':
   		$sql = "INSERT INTO tbl_area (description, id_type_area, id_type_sample, status) values(?, ?, ?, ?)";
	    $query = $idb->prepare($sql);
	    $result = $query->execute(array($description, $id_type_area, $id_type_sample, $status));
	    
   		break;
   	case 'Actualizar':
     $id_area = $_POST['id_area'];
	   	$sql = "UPDATE tbl_area  set description = ?, id_type_area = ?, id_type_sample = ?, status = ? WHERE id_area = ?";
	    $query = $idb->prepare($sql);
	     $result = $query->execute(array($description, $id_type_area, $id_type_sample, $status, $id_area));
       
   		break;
   		case 'delete_Areas':
     $id_area1 = $_REQUEST['id_area'];
        if (isset($_REQUEST['id_area'])) {
            $sql = "UPDATE  tbl_area set status=0 WHERE id_area = '$id_area1'";
            $q = $idb->prepare($sql);
            $q->execute(array($id_area1));
        }
        break;
  
   }

?>
