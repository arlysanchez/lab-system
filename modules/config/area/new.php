<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
?>

<div class="container-fluid">
    <div class="card card-default"> 
    <div class="card-header">
            <h3 class="card-title">Registrar areas</h3>
    </div>
        <form method="post" id="formid" action="save.php">
        <div class="row">
            <div class='col-sm-6'>
                <div class="card-body">
            <div class="form-group input-group-sm">
                        <label>Descripcion: </label>
                        <input  id="description" name="description" type="text" class="form-control" placeholder="Escriba la descripcion"/>
                        <span class="help-block"></span>
                </div>
                 <div class="form-group" >
                        <label class="control-label" for="inputSuccess1">Tipo de muestra</label>
                        <select name="id_type_sample" id="id_type_sample"  class="form-control"  > 
                            <option>Seleccione</option>
                            <?php
                            $query = "select * from tbl_type_sample";
                            $data = $idb->prepare($query);
                            $data->execute();
                            while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                if ($id_type_sample == $row['id_type_sample']) {
                                    echo "<option value='" . $row['id_type_sample'] . "' selected='selected'>" . $row['description'] . "</option>";
                                } else {
                                    echo "<option value='" . $row['id_type_sample'] . "'>" . $row['description'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
            </div>
          </div>
            <div class="col-sm-6">
                <div class="card-body">
                    
                      <div class="form-group" >
                        <label class="control-label" for="inputSuccess1">Tipo Area</label>
                        <select name="id_type_area" id="id_type_area"  class="form-control"  > 
                            <option>Seleccione</option>
                            <?php
                            $query1 = "select * from tbl_type_area where status=1";
                            $data1 = $idb->prepare($query1);
                            $data1->execute();
                            while ($row1 = $data1->fetch(PDO::FETCH_ASSOC)) {
                                if ($id_type_area == $row1['id_type_area']) {
                                    echo "<option value='" . $row1['id_type_area'] . "' selected='selected'>" . $row1['description'] . "</option>";
                                } else {
                                    echo "<option value='" . $row1['id_type_area'] . "'>" . $row1['description'] . "</option>";
                                }
                            }
                            ?>
                        </select>
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
                            <input type="submit" value="Registrar" id="boton" name="boton" class="btn btn-sm btn-success boton">
                            <a class="btn btn-sm btn-danger" onclick="loadpage('./config/area/index.php')" >Cancelar</a>
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
                description: {required: true, minlength: 3},
                id_type_area: {required: true},
                id_type_sample: {required: true}
            },
            messages: {
                // descripcion: "Debe seleccionar una opcion.'",

            }, submitHandler: function(form) {
                $.ajax({
                    url: "./modules/config/area/" + $("#formid").attr("action"),
                    data: $("#formid").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                    success: function(result) {
                       console.log(result);
                        if (result) {
                             toastr.success('Registro Satisfactorio')
                         }else{
                            toastr.error('Error de registro')
                         }
                        loadpage("config/area/index.php");
                    }
                });
            }
        });
    });
</script>
