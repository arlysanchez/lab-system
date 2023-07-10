<?php
require '../../../config/conexion.php';
$idb = $conn;
if (isset($_GET['term'])) {
    $return_arr = array();
    $array_json = array();
    try {
        $stmt = $idb->prepare('
            select p.id_persona, p.nombre, p.apellido_pat, p.apellido_mat
            FROM tbl_persona p 
            where nombre LIKE :term');
        $stmt->execute(array('term' => '%' . $_GET['term'] . '%'));
        while ($row = $stmt->fetch()) {
            $return_arr["id"] = $row['id_persona'];
            $return_arr["value"] = $row['nombre'] . ' ' . $row['apellido_pat'] . ' ' . $row['apellido_mat'];
            $return_arr["label"] = $row['nombre'] . ' ' . $row['apellido_pat'] . ' ' . $row['apellido_mat'];
            array_push($array_json, $return_arr);
        }
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
    echo json_encode($array_json);
}
?>