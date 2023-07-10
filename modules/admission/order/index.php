<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
$sql = "select tlo.id_lab_order, tlo.date_register_order, tlo.status_order, tper.num_doc, CONCAT(tper.nombre,' ',tper.apellido_pat,' ',tper.apellido_mat)full_name, tlo.total
       FROM tbl_lab_order tlo, tbl_patient tp, tbl_persona tper
       WHERE tper.id_persona = tp.id_person AND  tlo.id_patient = tp.id_patient ORDER BY tlo.date_register_order DESC ";   //prepared statements 
$numero = 1;
$query = $idb->prepare($sql);
$query->execute();
$resultado = $query->fetchAll();
?>
<div class="card">
<div class="row">
   <div class="col-11"><div class="card-header"><h3 class="card-title d-flex justify-content-center ">Orden de laboratorio</h3></div></div>

                 <div class="col-1 d-flex justify-content-center" >
                 <div class='col-sm-12'>
                     <br>
                 <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;"onclick='loadpage("admission/order/new.php")' >
                    <i class="fas fa-plus"></i>NUEVO
                  </button>
                  </div>
    </div>
   </div>
   <div class="card-body">
        <div class='col-sm-12'>
            <table id="example1" class="table table-bordered table-striped">
          <thead >
                                <tr class='tre'>                                
                                    <th>NRO</th>
                                    <th>FECHA_REGISTRO</th> 
                                    <th>DOCUMENTO</th>
                                    <th>PACIENTE</th> 
                                    <th>TOTAL</th>
                                     <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>        
                                <?php
                                foreach ($resultado as $v) {
                                    print "<tr>";
                                    print "<td>" . $numero . "</td>";
                                    print "<td>" . $v["date_register_order"] . "</td>";
                                    print "<td>" . $v["num_doc"] . "</td>";
                                    print "<td>" . $v["full_name"] . "</td>";
                                    print "<td>" . $v["total"] . "</td>";
                                    $status_order_P = '<span class="right badge badge-danger"><i class="ace-icon fa fa-user bigger-120"></i>Pendiente</span>';
                                    $status_order_T = '<span class="right badge badge-success"><i class="ace-icon fa fa-check bigger-120"></i>Finalizado</span>';
                                    if ($v['status_order'] == 'P' OR $v['status_order'] == 'R' ) {
                                       $status_order = $status_order_P;
                                         print "<td>
                                        <span>$status_order</span>
                                        <a href='#' onclick='loadpage(" . '"admission/order/edit.php?cod=' . $v['id_lab_order'] . '"' . ")'><span class='right badge badge-success'><i class='fa fa-pen'></i></span></a>"
                                       ?>

                                       <a href="#" data-toggle="modal" data-target="#ViewPrint<?php echo $v['id_lab_order'] ?>"><span class="right badge badge-warning"><i class="fa fa-print"></i></span></a>
                                       
                                       </td>
                                      <?php
                                     }else{
                                      $status_order = $status_order_T;
                                       print "<td>"
                                      ?>
                                      <!--<a href="#" data-toggle="modal" data-target="#ViewPrintResult<?php echo $v['id_lab_order'] ?>"><span class="right badge badge-primary"><i class="fa fa-print"></i></span></a>-->
                                       <a class='btn btn-warning btn-xs' href="modules/admission/patient/reporte_pdf.php?cod=<?php echo $v['id_lab_order'] ?>">&nbsp;PDF&nbsp;</a>
                                      <?php
                                      print "</td>";
                                    } 
                                   
                                    print "</tr>";
                                    $numero++;
                                    include('modal_print.php'); 
                                    //include('../../../modules/laboratory/result/modal_view_print.php');
                                    
                                }
                                ?>    
                            </tbody>


            </table>
        </div>

    </div>
</div>
</div>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
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
</script>



                       