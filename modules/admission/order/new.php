<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
error_reporting(0);

$sql = "select p.id_persona, tp.id_patient, CONCAT(p.nombre,' ', p.apellido_pat,' ', p.apellido_mat) as paciente, p.num_doc FROM tbl_persona p, 
tbl_patient tp where p.id_persona = tp.id_person";   //prepared statements 
$numero = 1;
$query = $idb->prepare($sql);
$query->execute();
$resultado1 = $query->fetchAll();

$sql1 = "SELECT MAX(num_order)num_orden FROM tbl_lab_order "; 
$query1 = $idb->prepare($sql1);
$query1->execute();
$resultado2 = $query1->fetchAll();
foreach ($resultado2 as $f) {
        $num_orden = $f['num_orden'];
        $num_order=$num_orden+1;    }
?>


<div class="container-fluid">
    <div class="card card-default"> 
    <div class="card-header">
            <h3 class="card-title">Registrar orden</h3>
    </div>
        <form method="post" id="formmodulos" action="save_order.php" name="order">
                <div class="card-body">
                <div class="row">
              <div class="col-md-6">
                     <div class="form-group">
                                    <label class="control-label" for="inputSuccess1">Paciente</label>
                                    <a href='#'  onclick='loadpage("admission/order/new_patient.php?cod=A")'<span class='green'><i class='fa fa-user-plus fa-sm'></i></span></a>

                                    <div class="input-group input-group-xm">
                                      <input type="hidden"  id="num_order" name="num_order" value="<?php echo $num_order ?>">
                                        <input type="text" id="nombre_pat" name="nombre_pat" class="form-control" placeholder="Buscar paciente" readonly="readonly"  >
                                        <input type="hidden"  id="id_patient" name="id_patient">
                                        <span class="input-group-btn">
                                            <button type="button"  data-toggle="modal" data-target="#myModalpatient" class="btn btn-success boton btn-flat"><i class="fa fa-search" aria-hidden="true"></i></button>
                                        </span>
                                    </div>

                                </div>
                    <label class="control-label" for="inputSuccess1">Descuento</label>
                    <div class="input-group mb-6">
                    <div class="input-group-prepend">
                    <span class="input-group-text">S/.</span>
                   </div>
                        <input type="text" class="form-control my_discount" name="discount" id="discount" value="0.00" placeholder="0.00"  />
                   </div>

                   <label class="control-label" for="inputSuccess1">Total</label>
                    <div class="input-group mb-6">
                    <div class="input-group-prepend">
                    <span class="input-group-text">S/.</span>
                   </div>
                        <input type="text" class="form-control" name="total"  id="total" readonly="readonly" />
                   </div>
                    
                </div>
                    <div class="col-md-6">
                     <center> <h5 style="font-weight: bold;">Seleccione pruebas a realizar</h5></center>
                     <div class="col-md-12">
                        <?php
                          $sql = "select a.* from tbl_area a, tbl_area_test b where a.id_area = b.id_area and a.status = 1 GROUP BY a.id_area";
                          $query = $idb->prepare($sql);
                          $query->execute();
                          $resultado = $query->fetchAll();

                        foreach ($resultado as $f) {
                            $id_area = $f['id_area'];
                            $description = $f['description'];
                         ?>
                    <div class="card card-info collapsed-card">
                      <div class="card-header">
                        <h3 class="card-title">
                      <input type="checkbox" name="area[]" id="area" value="<?php echo $id_area ?>">
                       <?php echo $description ?>
                      </h3>
                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                          </button>
                        </div>
                        <!-- /.card-tools -->
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body" >
                        <?php 
                             $sql2 = "select t.id_test, t.description as test, t.cost FROM tbl_area_test tat, tbl_test t  WHERE  t.id_test=tat.id_test AND t.status = 1 and tat.id_area = $id_area";
                            $query2 = $idb->prepare($sql2);
                            $query2->execute();
                            $resultado2 = $query2->fetchAll();
                            foreach ($resultado2 as $ft) {
                            $id_test = $ft['id_test'];
                            $test = $ft['test'];
                            $cost = $ft['cost'];
                            $has_features = $ft['has_features'];
                            $tem_var = $ft['id_test'].'-'.$id_area
                             ?>  
                                <ul>
                                <li>  
                                <input type="checkbox"  name="test[]" id="test" tu-attr-precio="<?php echo $cost ?>" class="mis-checkboxes" value="<?php echo $tem_var ?>" /> <i></i><?php echo $test ?> <span class="badge btn-info"  style="float: right; border: 3px solid white;">S/.<?php echo $cost ?></span>
                                </li>
                                </ul>
                                <?php }?> 
                      </div>
                      <!-- /.card-body -->
                    </div>

                      <?php }?>
                    <!-- /.card -->
                    </div>

                    <div class="form-actions center">
                        <center>
                             <input type="submit" value="Registrar" id="boton" name="boton"  class="btn btn-sm btn-success boton">
                            <a class="btn btn-sm btn-danger" onclick="loadpage('./admission/order/index.php')" >Cancelar</a>
                        </center>
                    </div>
              </div>
        </div>
        </div>
        </form>
    </div>
</div>
 <div class="modal fade" id="myModalpatient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header color ">
                   <center>BUSCAR PACIENTE</center> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                <div class="modal-body">
                 <table id="example1" class="table table-bordered table-striped">
                <thead >
                                <tr class='tre'>                                
                                    <th>NRO</th>
                                    <th>PACIENTE</th> 
                                    <th>DOCUMENTO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>        
                                <?php
                                foreach ($resultado1 as $v) {
                                    print "<tr>";
                                    print "<td>" . $numero . "</td>";
                                    print "<td>" . $v["paciente"] . "</td>";
                                    print "<td>" . $v["num_doc"] . "</td>";
                                     print '<td><a data-dismiss="modal" aria-label="Close" href="#"  onclick="seleccionarPatient(' . $v['id_patient'] . ',\'' . str_replace("'", "\'", $v['paciente']) . '\')"><span class="glyphicon glyphicon-circle-arrow-up"></span> Elegir</a></td></td>';
                                    print "</tr>";
                                    $numero++;
                                }
                                ?>    
                            </tbody>


            </table>

                </div>                            
            </div>
        </div>
    </div>

<!--<script src="jquery-ui.js"></script>-->
<script type="application/javascript">
    
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

    
$(document).ready(function() {
        $("#formmodulos").validate({
            rules: {
                nombre_pat: {required: true},
                area: {required: true},
                test: {required: true},
                total: {required: true},
                discount: {required: true}              
            },
            messages: {
                // descripcion: "Debe seleccionar una opcion.'",

            }, submitHandler: function(form) {
                $.ajax({
                    url: "./modules/admission/order/" + $("#formmodulos").attr("action"),
                    data: $("#formmodulos").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar

                    success: function(result) {
                        //console.log(result);
                        if (result) {
                             toastr.success('Registro Satisfactorio')
                         }else{
                            toastr.error('Error de registro')
                         }
                        loadpage("admission/order/index.php");
                    }
                });
            }
        });
    });
    
  $(document).ready(function() {
 
     $(document).on('click keyup','.mis-checkboxes,.my_discount',function() {
   calcular();
    });

   });

 function calcular() {
  var tot = $('#total');
  tot.val(0);
  $('.mis-checkboxes,.my_discount').each(function() {
    if($(this).hasClass('mis-checkboxes')) {
      tot.val(($(this).is(':checked') ? parseFloat($(this).attr('tu-attr-precio')) : 0) + parseFloat(tot.val()));  
    }
    else {
      tot.val(parseFloat(tot.val()) - (isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val())));
    }
  });
  var totalParts = parseFloat(tot.val()).toFixed(2).split('.');
  tot.val(totalParts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '.' +  (totalParts.length > 1 ? totalParts[1] : '00'));  
}

function seleccionarPatient(id, nombrecompleto) {
        $("#nombre_pat").val(nombrecompleto);
        $("#id_patient").val(id);
        $("#myModalpatient").modal('hide');
    }
  
   


</script>



