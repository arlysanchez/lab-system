<?php
 require_once '../../../sesion.php';
require '../../../config/conexion.php';
error_reporting(0);
$idb = $conn;
$codmodulo = $_POST['codmodulo'];
$descripcion = $_POST['descripcion'];
$url = $_POST['url'];
$idpadre = $_POST['idpadre'];
$icono = $_POST['icono'];
$order_list = $_POST['order_list'];
$estado = $_POST['estado'];
$boton=   $_POST['boton'];

 switch ($boton) {
 	case 'Registrar':
 	      $sql = "INSERT INTO tbl_modulos (descripcion,url,idpadre,icono, order_list, estado) values(?, ?, ?, ?, ?, ?)";
          $query = $idb->prepare($sql);
          $result = $query->execute(array($descripcion, $url, $idpadre, $icono, $order_list, $estado));
           if($result){
    	    echo "OK";
             }else{
    	   echo "error";
            }
 		break;
 	case 'Actualizar':
          $sql = "UPDATE tbl_modulos  set descripcion = ?, url = ?, idpadre = ?, icono = ?, order_list = ?, estado = ?  WHERE codmodulo = ?";
          $query = $idb->prepare($sql);
          $result = $query->execute(array($descripcion, $url, $idpadre, $icono, $order_list, $estado, $codmodulo));
          if($result){
    	    echo "OK";
             }else{
    	   echo "error";
            }
 		break;
 }

?>
