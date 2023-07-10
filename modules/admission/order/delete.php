<?php
require_once '../../../sesion.php';
require '../../../config/Conexion.php';
$idb = $conn;
$id = 0;
if (!empty($_GET['cod'])) {
    $id = $_REQUEST['cod'];
}


$sql1 = "select lab.id_lab_order, lab.total, t.id_test, t.description as test, t.cost from tbl_detail_order tbl, tbl_test t, tbl_lab_order lab where t.id_test = tbl.id_test and lab.id_lab_order = tbl.id_lab_order and tbl.id_detail_order= $id";   //
$numero = 1;
$query1 = $idb->prepare($sql1);
$query1->execute();
$resultado1 = $query1->fetchAll();
foreach ($resultado1 as $f) {
        $id_lab_order= $f['id_lab_order'];
        $id_test= $f['id_test'];
        $cost = $f['cost'];
        $test = $f['test'];
        $total = $f['total'];
        $total_delete_update = $total-$cost;
    }

?>            <br>
<div class="container-fluid">
  <div class="card card-default"> 
   <div class="card-body">
    <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <form class="form-horizontal"  id="formmodulos" action="save_order.php" method="post">
        <input type="hidden" name="id_detail_order" value="<?php echo $id; ?>"/>
        <input type="hidden" name="total_delete_update" value="<?php echo $total_delete_update; ?>"/>
        <input type="hidden" name="id_lab_order" value="<?php echo $id_lab_order; ?>"/>
        <div class="alert alert-danger">
            Esta seguro de eliminar el Test " <?php echo $test; ?>" de la orden?
            
        </div>
        <center>
         <input type="submit" value="Eliminar" id="boton" name="boton"  class="btn btn-sm btn-info boton">
        <?php 
        print "<input type='button' value='Cancelar' class='btn btn-sm btn-danger' onclick='loadpage(" . '"admission/order/edit.php?cod=' . $id_lab_order . '"' . ")'>"
         ?>
        </center>
      </form>
    </div>
 <div class="col-sm-3"></div>
</div>
</div>
</div>
</div>
<script>
   $(document).ready(function() {
        $("#formmodulos").validate({
            rules: {

                
            },
            messages: {
                // descripcion: "Debe seleccionar una opcion.'",

            }, submitHandler: function(form) {
                $.ajax({
                    url: "./modules/admission/order/" + $("#formmodulos").attr("action"),
                    data: $("#formmodulos").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                   
                    success: function(result) {
                        if (result =="OK") {
                             toastr.success('Se eliminó satisfactoriamente')
                         }else{
                            toastr.error('Error de registro')
                         }
                         loadpage("admission/order/index.php");
                    }
                });
            }
        });
    });
</script>
</html>

