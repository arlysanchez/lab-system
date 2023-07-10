<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
if (isset($_GET['cod'])) {
    $id_area = $_GET['cod'];
    $sql = "SELECT * FROM tbl_area WHERE id_area = $id_area";
    $query = $idb->prepare($sql);
    $query->execute();
    $resultado = $query->fetchAll();
    foreach ($resultado as $f) {
        $description = $f['description'];
        $id_type_area = $f['id_type_area'];
        $id_type_sample = $f['id_type_sample'];
    }
}
?>
<div class="container-fluid">
    <div class="card card-default"> 
    <div class="card-header">
            <h3 class="card-title">Actualizar area</h3>
    </div>
        <form method="post" id="formmodule" action="save.php">
        <div class="row">
            <div class='col-sm-6'>
                <div class="card-body">
                <div class="form-group input-group-sm">
                        <label>Descripcion: </label>
                        <input type="text" name="description"class="form-control" placeholder="Escriba la descripcion" value="<?php echo $description; ?>" maxlength="20" />
                    </div>
                   <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Tipo muestra</label>
                        <select name="id_type_sample" value="<?php echo $id_type_sample ?>"   class="form-control"  > 
                            <option>Seleccione</option>
                            <?php
                            $query = "select * from tbl_type_sample ";
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
                    <input type="hidden" id="id_area" name="id_area"  value="<?php echo $id_area ?>"  >
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Tipo area</label>
                        <select name="id_type_area" value="<?php echo $id_type_area ?>"   class="form-control"  > 
                            <option>Seleccione</option>
                            <?php
                            $query1 = "select * from tbl_type_area";
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
                        <label >
                            <?php
                            echo '<input class="ace id="status" name="status" checked="checked"  type="checkbox" value="1" />';
                            ?>                                      
                            <span class="lbl"> Estado</span>
                        </label>
                    </div>

                    <div class="form-actions center">
                        <center>
                            <input type="submit" value="Actualizar" id="boton" name="boton" class="btn btn-sm btn-info boton">
                            <a class="btn btn-sm btn-danger" onclick="loadpage('./config/area/index.php')" >Cancelar</a>  
                        </center>
                    </div>
                </div>
            </div>
            
        </div>
        </form>
    </div>
</div>


<script>
   $(document).ready(function() {
        $("#formmodule").validate({
            rules: {

            },
            messages: {
                // descripcion: "Debe seleccionar una opcion.'",

            }, submitHandler: function(form) {
                $.ajax({
                    url: "./modules/config/area/" + $("#formmodule").attr("action"),
                    data: $("#formmodule").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                    success: function(result) {
                        if (result) {
                             toastr.info('Registro actualizado')
                         }else{
                            toastr.error('Error de actualizacion')
                         }
                        loadpage("config/area/index.php");
                    }
                });
            }
        });
    });
</script>
