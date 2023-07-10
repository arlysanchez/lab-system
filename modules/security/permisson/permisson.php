<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
$id_tipousuario = $_GET["cod"];
$sql5 = "SELECT * FROM tbl_tipousuario where id_tipousuario=$id_tipousuario";
$query5 = $idb->prepare($sql5);
$query5->execute();
$resultado5 = $query5->fetchAll();
foreach ($resultado5 as $j) {
    $descripcion1 = $j['descripcion'];
}
?>
<div class="card card-widget widget-user">
          <input type="hidden" id='id' name='id' value="<?php echo $id_tipousuario ?>">
            <div class="box-header with-border"> <br>
              <center><h3 class="box-title">Asignar permiso al tipo de usuario <b><?php echo $descripcion1 ?></b></h3></center>
            
     </div>

<?php 


echo "<ul id='menu'>";
cargarmod("0", $id_tipousuario, $idb);
echo " </ul>";

function cargarmod($id, $u, $idb) {
    $sql = "select * from tbl_modulos where idpadre='$id'";
    $query = $idb->prepare($sql);
    $query->execute();
    $resultado = $query->fetchAll();

    foreach ($resultado as $f) {
        $m = $f['codmodulo'];
        $descripcion = $f['descripcion'];
        $url = $f['url'];

        $sql2 = "select * FROM modulo_tipousuario WHERE codmodulo=$m and id_tipousuario=$u";
        $query2 = $idb->prepare($sql2);
        $query2->execute();
        $resultado2 = $query2->fetchAll();

        if (!empty($resultado2)) {
            $check = "checked='checked'";
        } else {
            $check = "";
        }

        if ($url == "#") {
            echo "<div>";
      
            echo"<br>";
            echo "<a href='#' class='dropdown-toggle'>
                  <input  type='checkbox'  $check name='permiso$u$m' id='permiso$u$m' value='' onclick='graba_permiso($u,$m,this)'/>
                  <span class='menu-text'>" . $descripcion . "</span>
                  </a>";
            echo '<ul>';

            cargarmod($m, $u, $idb);

            echo "</ul>";
        
            echo "</div>";
        } else {
            echo "<div ><input type='checkbox' $check name='permiso$u$m' id='permiso$u$m' value='' onclick='graba_permiso($u,$m,this)' /> <i class='menu-icon fa fa-caret-right'></i>" . " " . "$descripcion</div>";
        }
    }
}


?> 
      </div>
