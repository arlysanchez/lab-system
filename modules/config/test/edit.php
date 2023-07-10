<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
if (isset($_GET['cod'])) {
    $id_test = $_GET['cod'];
    $sql = "select * from tbl_test where id_test = $id_test ";
    $query = $idb->prepare($sql);
    $query->execute();
    $resultado = $query->fetchAll();
    foreach ($resultado as $f) {
        $id_test = $f['id_test'];
        $description = $f['description'];
        $cost = $f['cost'];
        
    }
}
?>

<div class="container-fluid">
    <div class="card card-default"> 
    <div class="card-header">
            <h3 class="card-title">Registrar Test</h3>
    </div>
        <form method="post" id="formmodulos" action="save.php">
                <div class="card-body">
                <div class="row">
              <div class="col-md-6">
                    <div class="form-group">
                    <input id="id_test" name="id_test" type="hidden" value="<?php echo $id_test ?>"   class="form-control" >
                        <label class="control-label" for="inputSuccess1">Nombre de la Prueba</label>
                        <input id="description" name="description" type="text" value="<?php echo $description ?>" placeholder="Ingrese nombre de la prueba" maxlength="100"  class="form-control" />
                        <span class="help-block"></span>
                    </div>
                  </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess1">Costo de la prueba</label>
                        <input id="cost" name="cost" type="number" value="<?php echo $cost ?>" placeholder="Ingrese el costo de la prueba" maxlength="100"  class="form-control" />
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group input-group-sm">
                        <label >
                            <?php
                            echo '<input class="ace id="status" name="status" checked="checked"  type="checkbox" value="1" />';
                            ?>                                      
                            <span class="lbl"> Estado</span>
                        </label>
                    </div>
                    </div>
                     </div>
                     <br>
                    <div class="form-actions center">
                        <center>
                            <input type="submit" value="Actualizar" id="boton" name="boton" class="btn btn-sm btn-success boton">
                            <a class="btn btn-sm btn-danger" onclick="loadpage('./config/test/index.php')" >Cancelar</a>
                        </center>
                    </div>
                
           
        </form>
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
                    url: "./modules/config/test/" + $("#formmodulos").attr("action"),
                    data: $("#formmodulos").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                    success: function(result) {
                       // console.log(result);
                      if (result) {
                             toastr.info('Registro Actualizado')
                         }else{
                            toastr.error('Error de actualizacion')
                         }
                        loadpage("config/test/index.php");
                    }
                });
            }
        });
    });


</script>



