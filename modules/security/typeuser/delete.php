<?php
require_once '../../../sesion.php';
require '../../../config/Conexion.php';
$idb = $conn;
$id = 0;
if (!empty($_GET['cod'])) {
    $id = $_REQUEST['cod'];
}
if (!empty($_POST)) {
    $id = $_POST['id'];
    $sql = "UPDATE  tbl_tipousuario set estado=0 WHERE id_tipousuario = '$id'";
    $q = $idb->prepare($sql);
    $q->execute(array($id));
}
?>            <br>
<div class="container-fluid">
  <div class="card card-default"> 
   <div class="card-body">
    <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <form class="form-horizontal"  id="formmodulos" action="delete.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        <div class="alert alert-danger">
            Esta seguro que desea dar de baja al tipo de usuario seleccionado?
        </div>
        <center>
        <input type="button" value="Aceptar" id="boton" class="btn btn-sm btn-info">
         <a class="btn btn-sm btn-danger" onclick="loadpage('./security/typeuser/index.php')" >Cancelar</a>
        </center>
      </form>
    </div>
 <div class="col-sm-3"></div>
</div>
</div>
</div>
</div>
<script>
    jQuery(function ($) {
        $("#boton").on("click", function () {
            $.ajax({
                url: "./modules/security/typeuser/" + $("#formmodulos").attr("action"),
                data: $("#formmodulos").serialize(), //cuando vas a editar
                type: "POST", //cuando vas a editar
                success: function (result) {
                    loadpage("security/typeuser/");
                }
            });
        });
    })
</script>
</html>

