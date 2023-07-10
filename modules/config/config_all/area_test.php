<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
$id_area = $_GET["cod"];
$sql5 = "SELECT * FROM tbl_area where id_area=$id_area";
$query5 = $idb->prepare($sql5);
$query5->execute();
$resultado5 = $query5->fetchAll();
foreach ($resultado5 as $j) {
    $description1 = $j['description'];
}
?>
<div class="card card-widget widget-user">
          <input type="hidden" id='id' name='id' value="<?php echo $id_area ?>">
            <div class="box-header with-border"> <br>
              <center><h3 class="box-title">Asignar test al area:  <b><?php echo $description1 ?></b></h3></center>
            
     </div>

<?php 
echo "<ul id='dibuja_areas'>";
cargarmod($id_area, $idb);
echo " </ul>";


function cargarmod($a, $idb) {
$sql = "select * from tbl_test WHERE status = 1";
    $query = $idb->prepare($sql);
    $query->execute();
    $resultado = $query->fetchAll();

    foreach ($resultado as $f) {
        $t = $f['id_test'];
        $description = $f['description'];

        $sql2 = "select * FROM tbl_area_test WHERE id_test=$t and id_area=$a";
        $query2 = $idb->prepare($sql2);
        $query2->execute();
        $resultado2 = $query2->fetchAll();

        if (!empty($resultado2)) {
            $check = "checked='checked'";
        } else {
            $check = "";
        }
         echo "<div ><input type='checkbox' $check name='permiso$a$t' id='permiso$a$t' value='' onclick='graba_area_test($a,$t,this)' /> <i class='menu-icon fa fa-caret-right'></i>" . " " . "$description</div>";
        }
    }



?> 
      </div>
