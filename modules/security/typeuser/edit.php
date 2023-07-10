<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
if (isset($_GET['cod'])) {
    $id_tipousuario = $_GET['cod'];
    $sql = "SELECT * FROM tbl_tipousuario WHERE id_tipousuario = $id_tipousuario";
    $query = $idb->prepare($sql);
    $query->execute();
    $resultado = $query->fetchAll();
    foreach ($resultado as $f) {
        $descripcion = $f['descripcion'];
        $estado = $f['estado'];
    }
}
?>
<div class="container-fluid">
    <div class="card card-default"> 
    <div class="card-header">
            <h3 class="card-title">Actualizar tipo de usuario</h3>
    </div>
        <form method="post" id="formmodules" action="save.php">
        <div class="row">
            <div class='col-sm-3'>
            </div>
            <div class="col-sm-6">
                <div class="card-body">
                    <input type="hidden" id="id_tipousuario" name="id_tipousuario"  value="<?php echo $id_tipousuario ?>"  >
                    <div class="form-group input-group-sm">
                        <label>Descripcion: </label>
                        <input type="text" name="descripcion"class="form-control" placeholder="Escriba la descripcion" value="<?php echo $descripcion; ?>" maxlength="20" />
                    </div>
                    <div class="form-group input-group-sm">
                        <label >
                            <?php
                            echo '<input class="ace id="estado" name="estado" checked="checked"  type="checkbox" value="1" />';
                            ?>                                      
                            <span class="lbl"> Estado</span>
                        </label>
                    </div>

                    <div class="form-actions center">
                        <center>
                            <input type="submit" value="Actualizar" id="boton" name="boton"  class="btn btn-sm btn-success boton">
                            <a class="btn btn-sm btn-danger" onclick="loadpage('./security/typeuser/index.php')" >Cancelar</a>  
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
        $("#formmodules").validate({
            rules: {
                description: {required: true, minlength: 3}
            },
            messages: {
                // descripcion: "Debe seleccionar una opcion.'",

            }, submitHandler: function(form) {
                $.ajax({
                    url: "./modules/security/typeuser/" + $("#formmodules").attr("action"),
                    data: $("#formmodules").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                    success: function(result) {
                        if (result) {
                             toastr.info('Registro actualizado')
                         }else{
                            toastr.error('Error de actualizacion')
                         }
                        loadpage("security/typeuser/index.php");
                    }
                });
            }
        });
    });
</script>