<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
error_reporting(0);
$numero = 1;
if (isset($_GET['cod'])) {
    $id_lab_order = $_GET['cod'];
    $sql = "select b.id_test, b.description as test, c.id_features, c.description as feature, c.reference_value from tbl_detail_order a, tbl_test b, tbl_features c where b.id_test = a.id_test and b.id_test = c.id_test and a.id_lab_order = $id_lab_order";
    $query = $idb->prepare($sql);
    $query->execute();
    $resultado = $query->fetchAll();
}
?>

<div class="container-fluid">
    <div class="card card-default"> 
            <div class="row">
            <div class="col-11"><div class="card-header"><h3 class="card-title d-flex justify-content-center ">REGISTRAR RESULTADOS</h3></div></div>

                 <div class="col-1 d-flex justify-content-center" >
                 <div class='col-sm-12'>
                     <br>
                 <button type="button" class="btn btn-danger float-right" style="margin-right: 5px;"onclick='loadpage("laboratory/result/index.php")' >
                  CANCELAR</button>
                  </div>
                </div>
           </div>
        <form method="post" id="formmodulos" action="save.php">
                <div class="card-body">
                     <div class="row">
                      <input type="hidden" name="id_lab_order" value="<?php echo $id_lab_order ?>">  
                    <div class="col-md-3"><label class="control-label" for="inputSuccess1">TEST <i></i></label></div>
                     <div class="col-md-3"><label class="control-label" for="inputSuccess1">CARACTERÍSTICAS <i></i></label></div>
                     <div class="col-md-3"><label class="control-label" for="inputSuccess1">RESULTADO <i></i></label></div>
                      <div class="col-md-3"><label class="control-label" for="inputSuccess1">REFERENCIA <i></i></label></div>
                     </div>
                 <?php 
                 foreach ($resultado as $f) {
                    $id_test= $f['id_test'];
                    $test= $f['test'];
                    $id_features = $f['id_features'];
                    $feature = $f['feature'];
                    $reference_value = $f['reference_value'];
    
                  ?>
                  <div class="row">
                 <div class="col-md-3"><input class="form-control" type="text"  value="<?php echo $test ?>" readonly="readonly"><br></div>
                 <div class="col-md-3"><input class="form-control" type="text" name="feature" value="<?php echo $feature ?>" readonly="readonly">
                <input class="form-control" type="hidden" name="id_features[]" value="<?php echo $id_features ?>" readonly="readonly"><br></div>
                 <div class="col-md-3"><input class="form-control" type="text" name="results[]" id="result" ><br></div>
                 <div class="col-md-3"><textarea class="form-control" type="text"  style="font-size: 14px" readonly="readonly"> <?php echo $reference_value ?></textarea>
                 </div>
                </div>
                
            <?php }?>
            </div>
            <div class="form-actions center">
             <center><input type="submit" value="REGISTRAR" id="boton" name="boton" class="btn btn-sm btn-primary"></center>
            </div><br>
        </form> 
    </div> 
    </div>

<script>
    
    $(function () {
    $('#boton').attr('disabled', true);
    $('#result').change(function () {
        if ($('#result').val() != '') {
            $('#boton').attr('disabled', false);
        } else {
            $('#boton').attr('disabled', true);
        }
    });
 });


    $(document).ready(function() {
        $("#formmodulos").validate({
            rules: {
                results: {required: true}             
            },
            messages: {
                // descripcion: "Debe seleccionar una opcion.'",

            }, submitHandler: function(form) {
                $.ajax({
                    url: "./modules/laboratory/result/" + $("#formmodulos").attr("action"),
                    data: $("#formmodulos").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar

                    success: function(result) {
                       // console.log(result);
                        if (result) {
                             toastr.success('Registro Satisfactorio')
                         }else{
                            toastr.error('Error de registro')
                         }
                        loadpage("laboratory/result/index.php");
                    }
                });
            }
        });
    });
</script>


