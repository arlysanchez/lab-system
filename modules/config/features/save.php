<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
error_reporting(0);
$idb = $conn;
//echo '<pre>';
//print_r($_POST);
//echo '</pre>';

$id_features = $_POST['id_features'];
$id_test = $_POST['id_test'];
$description = $_POST['description'];
$reference_value = $_POST['reference_value'];
$boton =   $_POST['boton'];
//delete
$boton =  $_REQUEST['boton'];
$id_features1 = $_REQUEST['id_features'];

switch ($boton) {
	case 'Registrar':
		for($i=0; $i < count($description); $i++){
          $sql = "INSERT INTO tbl_features (id_test,description,reference_value, status) values( ?, ?, ?, ?)";
          $query = $idb->prepare($sql);
          $result = $query->execute(array($id_test, $description[$i],$reference_value[$i], 1)); 
          }
          if($result){
          echo "OK";
	    }else{
          echo "error";
	    }
		break;
	
	case 'Actualizar':
		$sql = "UPDATE tbl_features  set id_test = ?, description = ?, reference_value = ?, status = ?  WHERE id_features = ?";
	    $query = $idb->prepare($sql);
	    $result = $query->execute(array($id_test, $description, $reference_value, 1, $id_features));
	    if($result){
          echo "OK";
	    }else{
          echo "error";
	    }
		break;
      
      case 'delete_features':
        if (isset($_REQUEST['id_features'])) {
            $sql = "UPDATE  tbl_features set status=0 WHERE id_features = '$id_features1'";
		    $q = $idb->prepare($sql);
		    $q->execute(array($id_features1));
		   }
        break;
    }


?>