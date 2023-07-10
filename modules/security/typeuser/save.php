<?php
 require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
error_reporting(0);
$descripcion = $_POST['descripcion'];
$estado = $_POST['estado'];
$slug   = $descripcion."_slug";
$boton =  $_POST['boton'];
$id_tipousuario = $_POST['id_tipousuario'];

switch ($boton) {
	case 'Registrar':
		$sql = "INSERT INTO tbl_tipousuario (descripcion, slug, estado) values(?, ?, ?)";
       $query = $idb->prepare($sql);
       $result= $query->execute(array($descripcion, $slug, $estado));
           if($result){
        	echo "OK";
        }else{
        	echo "error";
        }
		break;
	case 'Actualizar':
		$sql = "UPDATE tbl_tipousuario  set descripcion = ?, estado = ? WHERE id_tipousuario = ?";
        $query = $idb->prepare($sql);
        $result= $query->execute(array($descripcion, $estado, $id_tipousuario));
         if($result){
    	echo "OK";
         }else{
    	echo "error";
        }
		break;
	
}

