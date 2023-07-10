<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
if (isset($_GET['cod'])) {
    $id_type_area = $_GET['cod'];
    $sql = "SELECT * FROM tbl_type_area WHERE id_type_area = $id_type_area";
    $query = $idb->prepare($sql);
    $query->execute();
    $resultado = $query->fetchAll();
    foreach ($resultado as $f) {
        $description = $f['description'];
        $status = $f['status'];
    }
}
?>
<div class="container-fluid">
    <div class="card card-default"> 
    <div class="card-header">
            <h3 class="card-title">Actualizar tipo de area</h3>
    </div>
        <form method="post" id="formmodule" action="save.php">
        <div class="row">
            <div class='col-sm-3'>
            </div>
            <div class="col-sm-6">
                <div class="card-body">
                    <input type="hidden" id="id_type_area" name="id_type_area"  value="<?php echo $id_type_area ?>"  >
                    <div class="form-group input-group-sm">
                        <label>Descripcion: </label>
                        <input type="text" name="description"class="form-control" placeholder="Escriba la descripcion" value="<?php echo $description; ?>" maxlength="20" />
                    </div>
                    <div class="form-group input-group-sm">
                        <label >
                            <?php
                            echo '<input class="ace id="status" name="status" checked="checked"  type="checkbox" value="1" />';
                            ?>                                      
                            <span class="lbl"> Estado</span>
                        </label>
                    </div>

                    <div class="form-actions center">
                        <center>
                             <input type="submit" value="Actualizar" id="boton" name="boton"  class="btn btn-sm btn-success boton">
                            <a class="btn btn-sm btn-danger" onclick="loadpage('./config/type_area/index.php')" >Cancelar</a>  
                        </center>
                    </div>
                </div>
            </div>
            <div class='col-sm-3'>
            </div>
        </div>
        </form>
    </div>
</div>


<script>
     $(document).ready(function() {
        $("#formmodule").validate({
            rules: {
                description: {required: true, minlength: 3}
            },
            messages: {
                // descripcion: "Debe seleccionar una opcion.'",

            }, submitHandler: function(form) {
                $.ajax({
                    url: "./modules/config/type_area/" + $("#formmodule").attr("action"),
                    data: $("#formmodule").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                    success: function(result) {
                        if (result) {
                             toastr.info('Registro actualizado')
                         }else{
                            toastr.error('Error de actualizacion')
                         }
                        loadpage("config/type_area/index.php");
                    }
                });
            }
        });
    });
</script>
<?php // require_once '../../../pie.php' ?>
