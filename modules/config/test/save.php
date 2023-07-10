<?php

require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
error_reporting(0);


$id_test = $_POST['id_test'];
$description = $_POST['description'];
$id_area = $_POST['id_area'];
$cost = $_POST['cost'];
$features = $_POST['features'];
$reference_value = $_POST['reference_value'];
$status = $_POST['status'];
$boton =  $_POST['boton'];

//delete 
$boton =  $_REQUEST['boton'];
$id_test1 = $_REQUEST['id_test'];


switch ($boton) {
  case 'Registrar':
    $sql = "INSERT INTO tbl_test (description,cost,status) values( ?, ?, ?)";
    $query = $idb->prepare($sql);
    $result = $query->execute(array($description, $cost, $status));
    if ($result) {
      echo "OK";
    }else{
      echo "error";
    }

       $sql3 = "SELECT MAX(id_test)test FROM tbl_test";
       $query8 = $idb->prepare($sql3);
       $query8->execute();
       $resultado1 = $query8->fetchAll();
        for($i=0; $i < count($features); $i++){
            foreach ($resultado1 as $value) {
             $id_test_recuperado1 = $value['test'];
          $sql11 = "INSERT INTO tbl_features (id_test ,description,reference_value, status) values( ?, ?, ?, ?)";
          $query11 = $idb->prepare($sql11);
          $result =$query11->execute(array($id_test_recuperado1, $features[$i],$reference_value[$i], 1)); 
            
        }
    }
  
    break;
    case 'Actualizar':
    $sql14 = "UPDATE tbl_test set description = ? , cost = ?, status = ? WHERE id_test = ?";
    $query14 = $idb->prepare($sql14);
    $result = $query14->execute(array($description, $cost, $status, $id_test));
    if ($result) {
      echo "OK";
    }else{
      echo "error";
    }
   
    break;
    
    case 'delete_tests':
        if (isset($_REQUEST['id_test'])) {
            $sql = "UPDATE  tbl_test set status=0 WHERE id_test = '$id_test1'";
            $q = $idb->prepare($sql);
            $q->execute(array($id_test1));
        }
        break;
  


}

?>
