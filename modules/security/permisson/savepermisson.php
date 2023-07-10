<?php
 require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
$e = $_POST['e'];
$ctu = $_POST['ctu'];
$cm = $_POST['cm'];

//die($ctu);
if ($e == 1) {
    $sql = "call insertapermiso('$ctu','$cm')";
} else {
    $sql = "call eliminapermiso('$ctu','$cm')";
}

$query = $idb->prepare($sql);
$result=$query->execute();

    if($result){
    	echo "OK";
         }else{
    	echo "error";
      }

?>

