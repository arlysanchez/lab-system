<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
error_reporting(0);
$numero = 1;
if (isset($_GET['cod'])) {
    $id_lab_order = $_GET['cod'];
    $sql = "SELECT * FROM tbl_lab_order WHERE id_lab_order = $id_lab_order";
    $query = $idb->prepare($sql);
    $query->execute();
    $resultado = $query->fetchAll();
    foreach ($resultado as $f) {
        $id_lab_order= $f['id_lab_order'];
        $id_patient = $f['id_patient'];
        $total = $f['total'];
        $discount = $f['discount'];
    }
}



$sql1 = "select tp.nombre, tp.apellido_pat, tp.apellido_mat from tbl_persona tp, tbl_patient pac where  tp.id_persona= pac.id_person AND pac.id_patient = $id_patient";
$query1 = $idb->prepare($sql1);
$query1->execute();
$resultado1 = $query1->fetchAll();
foreach ($resultado1 as $t) {
    $nombres = $t['nombre'] . ' ' . $t['apellido_pat'] . ' ' . $t['apellido_mat'];
}

$sql2 = "select tbld.id_detail_order, tbld.id_lab_order, a.id_area, a.description as area, t.id_test, t.description as test, t.cost from tbl_detail_order tbld, tbl_area a, tbl_test t where a.id_area=tbld.id_area and t.id_test = tbld.id_test and tbld.id_lab_order = $id_lab_order";
$query2 = $idb->prepare($sql2);
$query2->execute();
$resultado2 = $query2->fetchAll();
 


$sql3 = "select * from tbl_area where status = 1";
$query3 = $idb->prepare($sql3);
$query3->execute();
$area = $query3->fetchAll();

?>

        <form method="post" id="formmodulos" action="save_order.php" name="order">
    <div class="card card-success card-outline"> 
    <div class="card-header">
            <div class="row">
   <div class="col-11"><h3 class="card-title d-flex justify-content-center ">Editar order</h3></div>

                 <div class="col-1 d-flex justify-content-center" >
                 <div class='col-sm-12'>
                 <button type="button" class="btn btn-warning float-right" onclick='loadpage("admission/order/index.php")' >
                    CANCELAR
                  </button>
                  </div>
    </div>
   </div>
    </div>
          <div class="card-body">
                <div class="row">
              <div class="col-md-6">
                    <div class="form-group">
                      <input id="id_lab_order" name="id_lab_order" type="hidden" value="<?php echo $id_lab_order ?>"   class="form-control" >
                        <label class="control-label" for="inputSuccess1">Paciente</label>
                        <input id="nombres" name="nombres" type="text" value="<?php echo $nombres ?>" readonly="readonly" class="auto form-control">
                    <input id="id_patient" name="id_patient" type="hidden" value="<?php echo $id_patient ?>"    class="form-control1" id="inputSuccess1">
                    </div>

                    

                   <label class="control-label" for="inputSuccess1">Total</label>
                    <div class="input-group mb-6">
                    <div class="input-group-prepend">
                    <span class="input-group-text">S/.</span>
                   </div>
                        <input type="text" class="form-control" name="total"  id="total" value="<?php echo $total ?>" readonly="readonly" />
                   </div>
                </div>
                    <div class="col-md-6">
                     <label class="control-label" for="inputSuccess1">Descuento</label>
                    <div class="input-group mb-6">
                    <div class="input-group-prepend">
                    <span class="input-group-text">S/.</span>
                   </div>
                        <input type="text" class="form-control my_discount" name="discount" value="<?php echo $discount ?>" placeholder="0.00"  />
                   </div>
                    
              </div>
        </div>
      </div>
    </div>
    <div class="card card-primary card-outline"> 
    <div class="card-header">
            <h3 class="card-title">Añadir Test a la orden de Laboratorio</h3>
    </div>
    <div class="card-body">
        <div class="row">
          <div class="col-md-6">
             <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Area<i></i></label>
                        <select name="area" id="area"  class="form-control"  > 
                            <option value="0"> Seleccionar</option>
                          <?php
                          foreach ($area as $a) {
                              ?>
                              <option value="<?php echo $a['id_area']; ?>"><?php echo $a['description']; ?></option>
                              <?php
                          }
                          ?>
                        </select>
                  </div>
            
          </div>
          <div class="col-md-4">
            <div id="test">
            </div>
          </div>
          <div class="col-md-2">
            <br>
            <input type="submit" value="Agregar" id="boton" name="boton"  class="btn btn-ms btn-primary boton">
          </div>

        </div>
      </div>
      </div>
        </form>
         <div class="card card-danger card-outline"> 
          <div class="card-header">
            <h3 class="card-title">Test Añadidos</h3>
          </div>
        <div class="row">
          <table id="example1" class="table table-bordered table-striped">
          <thead >
                                <tr class='tre'>                                
                                    <th>NRO</th> 
                                    <th>AREA</th> 
                                    <th>TEST</th>
                                    <th>COSTO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>        
                                <?php
                                foreach ($resultado2 as $v) {
                                    print "<tr>";
                                    print "<td>" . $numero . "</td>";
                                    print "<td>" . $v["area"] . "</td>";
                                    print "<td>" . $v["test"] . "</td>";
                                    print "<td>" . $v["cost"] . "</td>";

                                   print "<td>
                                       <a href='#' onclick='loadpage(" . '"admission/order/delete.php?cod=' . $v['id_detail_order'] . '"' . ")'><span class='right badge badge-danger'><i class='fa fa-trash'></i></span></a>
                                       </td>";
                                    print "</tr>";
                                    $numero++;
                                }
                                ?>    
                            </tbody>


            </table>
          
          
        </div>

        </div>

<!--<script src="jquery-ui.js"></script>-->
<script type="text/javascript">
  //llamar a los test
  $(document).ready(function(){
    //$('#lista1').val(1);
    cargaTest();

    $('#area').change(function(){
      cargaTest();
    });
  })
  function cargaTest(){
    $.ajax({
      type:"POST",
      url:"./modules/admission/order/get_test.php",
      data:"area=" + $('#area').val(),
      success:function(r){
        $('#test').html(r);
      }
    });
  }

  //*/

    $(document).ready(function() {
        $('#tablapersona').DataTable();
    });

    
$(document).ready(function() {
        $("#formmodulos").validate({
            rules: {
                nombre: {required: true},
                usuario: {required: true},
                id_tipousuario: {required: true},
                
            },
            messages: {
                // descripcion: "Debe seleccionar una opcion.'",

            }, submitHandler: function(form) {
                $.ajax({
                    url: "./modules/admission/order/" + $("#formmodulos").attr("action"),
                    data: $("#formmodulos").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                   
                    success: function(result) {
                      var id = result; 
                       //console.log(id);
                        if (result) {
                             toastr.success('Registro Satisfactorio')
                         }else{
                            toastr.error('Error de registro')
                         }
                         loadpage("admission/order/edit.php?cod=" + id);
                    }
                });
            }
        });
    });
    $(function() {
        //autocomplete
        $(".auto").autocomplete({
            source: "./modules/admission/order/search.php",
            minLength: 1,
            select: function(event, ui) {
                var idregistro = ui.item.id;
                $("#id_patient").val(idregistro);
            }
        });

    });
  
$(function () {
    $('#boton').attr('disabled', true);
    $('#area').change(function () {
        if ($('#area').val() != 0) {
            $('#boton').attr('disabled', false);
        } else {
            $('#boton').attr('disabled', true);
        }
    });
 });
</script>


