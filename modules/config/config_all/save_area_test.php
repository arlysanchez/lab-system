<?php
 require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
$e = $_POST['e'];
$ct = $_POST['ct'];
$ca = $_POST['ca'];

//die($ctu);
if ($e == 1) {
    $sql = "call insert_test_area('$ct','$ca')";
    echo " <div class='alert alert-info alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Permiso asignado correctamente  </div>";
} else {
    $sql = "call delete_test_area('$ct','$ca')";
    echo"<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Permiso quitado correctamente</div>";
}

$query = $idb->prepare($sql);
$query->execute();
//$resultado = $query->fetchAll();
?>

