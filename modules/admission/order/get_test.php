<?php 
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
//error_reporting(0);

$id_area = $_POST['area'];

$sql = "select t.id_test, t.description as test, t.cost from tbl_area a, tbl_test t, tbl_area_test tblat where a.id_area = tblat.id_area AND t.id_test = tblat.id_test AND t.status = 1 AND a.id_area =$id_area" ;
$data = $idb->prepare($sql);
$data->execute();

?>
<div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Test<i>*</i></label>
                        <select name="test_edit"   class="form-control"  > 
             <?php 
	        while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
               if ($id_test == $row['id_test']) {
                 echo "<option value='" . $row['id_test'] . "' selected='selected'>" . $row['test'] . "</option>";
                                } else {
                                    echo "<option value='" . $row['id_test'] . '-'.$row['cost']."'>" . $row['test'] . "</option>";
                                }
                            }

    ?>
 </select>
  </div>