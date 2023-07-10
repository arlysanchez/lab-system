<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
if (isset($_GET['cod'])) {
    $id_features = $_GET['cod'];
    $sql = "SELECT * FROM tbl_features WHERE id_features = $id_features";
    $query = $idb->prepare($sql);
    $query->execute();
    $resultado = $query->fetchAll();
    foreach ($resultado as $f) {
        $id_features = $f['id_features'];
        $description = $f['description'];
        $reference_value = $f['reference_value'];
        $id_test = $f['id_test'];
    }
}
?>


<div class="container-fluid">
    <div class="card card-default"> 
    <div class="card-header">
            <h3 class="card-title">Registrar Caracteristicas</h3>
    </div>
<form method="post" id="formid" action="save.php">
                <div class="card-body">
                <div class="row">
              <div class="col-md-6">
                 <input id="id_features" name="id_features" type="hidden" value="<?php echo $id_features ?>"   class="form-control" >
                    <div class="form-group">
                  <label>Prueba</label>
                  <select name="id_test" class="form-control select2" value="<?php echo $id_test ?>" style="width: 100%;">
                    <option selected="selected">Seleccione</option>
                    <?php
                            $query = "select * from tbl_test where status=1";
                            $data = $idb->prepare($query);
                            $data->execute();
                           while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                            if ($id_test == $row['id_test']) {
                                 echo "<option value='" . $row['id_test'] . "' selected='selected'>" . $row['description'] . "</option>";
                                } else {
                                    echo "<option value='" . $row['id_test'] . "'>" . $row['description'] . "</option>";
                                }
                            }
                    ?>
                  </select>
                </div>
                
                </div>
                    <div class="col-md-6">
                      <div class="form-group">
                                <label class="control-label" for="inputSuccess1">Caracteristica</label>
                                 <input id="description" name="description" type="text" value="<?php echo $description ?>" placeholder="Ingrese nombre de Caracteristica" maxlength="100"  class="form-control" />
                               </div>
                                <div class="form-group">
                                <label class="control-label" for="inputSuccess1">Valor de Referencia</label>
                                 <input id="reference_value" name="reference_value" type="text" value="<?php echo $reference_value ?>" placeholder="Ingrese nombre de Caracteristica" maxlength="100"  class="form-control" />
                               </div>
                            </div>
                              
                     </div>
            </div>
            <div class="form-actions center">
                        <center>
                            <input type="submit" value="Actualizar" id="boton"  name="boton" class="btn btn-sm btn-success boton">
                            <a class="btn btn-sm btn-danger" onclick="loadpage('./config/features/index.php')" >Cancelar</a>
                        </center>
              </div>
              <br>
        </form>
      </div>
    </div>

   <script>
    

    $(document).ready(function() {
        $("#formid").validate({
            rules: {

            },
            messages: {
                // descripcion: "Debe seleccionar una opcion.'",

            }, submitHandler: function(form) {
                $.ajax({
                    url: "./modules/config/features/" + $("#formid").attr("action"),
                    data: $("#formid").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                    success: function(result) {
                        if (result) {
                             toastr.info('Registro actualizado')
                         }else{
                            toastr.error('Error de actualizacion')
                         }
                        loadpage("config/features/index.php");
                    }
                });
            }
        });
    });

$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

  })
</script>

  



