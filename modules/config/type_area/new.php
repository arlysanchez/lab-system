<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
?>

<div class="container-fluid">
    <div class="card card-default"> 
    <div class="card-header">
            <h3 class="card-title">Registrar Tipo area</h3>
    </div>
        <form method="post" id="formid" action="save.php">
        <div class="row">
            <div class='col-sm-3'>
            </div>
            <div class="col-sm-6">
                <div class="card-body">

                    <div class="form-group input-group-sm">
                        <label>Descripcion: </label>
                        <input  id="description" name="description" type="text" class="form-control" placeholder="Escriba la descripcion"/>
                        <span class="help-block"></span>

                    </div>
                    <div class="form-group input-group-sm">
                        <label>
                            <?php
                            echo '<input class="ace id="status" name="status" checked="checked"  type="checkbox" value="1" />';
                            ?>                                      
                            <span class="lbl"> Estado</span>
                        </label>
                    </div>
                    <div class="form-actions center">
                        <center>
                            <input type="submit" value="Registrar" id="boton" name="boton"  class="btn btn-sm btn-success boton">
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

<script type="text/javascript">

    $(document).ready(function() {
        $("#formid").validate({
            rules: {
                description: {required: true, minlength: 3}
            },
            messages: {
                // descripcion: "Debe seleccionar una opcion.'",

            }, submitHandler: function(form) {
                $.ajax({
                    url: "./modules/config/type_area/" + $("#formid").attr("action"),
                    data: $("#formid").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                    success: function(result) {
                        if (result) {
                             toastr.success('Registro Satisfactorio')
                         }else{
                            toastr.error('Error de registro')
                         }
                        loadpage("config/type_area/index.php");
                    }
                });
            }
        });
    });

</script>

<?php //require_once '../../../pie.php' ?>
