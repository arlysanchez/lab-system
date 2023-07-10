<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
?>

<div class="container-fluid">
    <div class="card card-default"> 
    <div class="card-header">
            <h3 class="card-title">Registrar modulos</h3>
    </div>
        <form method="post" id="formid" action="save.php">
        <div class="card-body">
            <div class='row'>
            <div class="col-sm-6">
                    <div class="form-group input-group-sm">
                        <label>Modulo: </label><br>
                        <input id="descripcion" name="descripcion" type="text" class="form-control"  placeholder="ingrese el nombre del modulo" maxlength="40" onkeyup="validacion('descripcion');" />
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group input-group-sm">
                        <label>Url: </label><br>
                        <input id="url" name="url" type="text" class="form-control"  placeholder="ingrese la url del modulo" maxlength="100" onkeyup="validacion('url');" />
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group input-group-sm">
                        <label>Modulo general: </label><br>
                        <select name="idpadre" id = "idpadre" class="form-control"> 
                            <option value="0">MODULO PADRE </option>
                            <?php
                            $query = "select * from tbl_modulos where idpadre=0";
                            $data = $idb->prepare($query);
                            $data->execute();
                            while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $row['codmodulo'] . '">' . $row['descripcion'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
            </div>
              <div class="col-sm-6">
                    <div class="form-group input-group-sm">
                        <label>icono: </label><br>
                        <input type="text" name="icono" class="form-control"   placeholder="Nombre de icono" maxlength="30" />
                    </div>
                    <div class="form-group input-group-sm">
                        <label>Orden: </label><br>
                        <input type="number" name="order_list" class="form-control"   maxlength="30" />
                    </div>
                    <div class="form-group input-group-sm">
                        <label>
                            <?php
                            echo '<input class="ace" id="estado" name="estado" checked="checked"  type="checkbox" value="1" />';
                            ?>                                      
                            <span class="lbl"> Estado</span>
                        </label>
                    </div>
                    <div class="form-actions center">
                        <center>
                            <input type="submit" value="Registrar" id="boton" name="boton" class="btn btn-sm btn-success boton">
                            <a class="btn btn-sm btn-danger" onclick="loadpage('./security/module/index.php')" >Cancelar</a>
                        </center>
                    </div>
                </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {
        $("#formid").validate({
            rules: {
                descripcion: {required: true},
                url: {required: true},
                idpadre: {required: true},
            },
            messages: {
                // descripcion: "Debe seleccionar una opcion.'",

            }, submitHandler: function(form) {
                $.ajax({
                    url: "./modules/security/module/" + $("#formid").attr("action"),
                    data: $("#formid").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                    success: function(result) {
                        if (result) {
                             toastr.success('Registro Satisfactorio')
                         }else{
                            toastr.error('Error de registro')
                         }
                        loadpage("security/module/index.php");
                    }
                });
            }
        });
    });
</script>

