<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
$sql = "select tlo.id_lab_order, tlo.date_register_order, tlo.date_register_result, tper.num_doc, tlo.status_order, CONCAT(tper.nombre,' ',tper.apellido_pat,' ',tper.apellido_mat)full_name, tlo.total
       FROM tbl_lab_order tlo, tbl_patient tp, tbl_persona tper
       WHERE tper.id_persona = tp.id_person AND  tlo.id_patient = tp.id_patient ORDER BY tlo.date_register_order DESC";   //prepared statements 
$numero = 1;
$query = $idb->prepare($sql);
$query->execute();
$resultado = $query->fetchAll();
?>
<div class="card">
<div class="row">
   <div class="col-12"><div class="card-header"><h3 class="card-title d-flex justify-content-center ">Resultados de laboratorio</h3></div></div>
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
                                    $status_order_P = '<span class="right badge badge-warning"><i class="ace-icon bigger-120"></i>Pendiente</span>';
                                    $status_order_R = '<span class="right badge badge-info"></i>Registrado</span>';
                                    $status_order_T = '<span class="right badge badge-success"><i class="ace-icon fa fa-check bigger-120"></i>Finalizado</span>';
                                    if ($v['status_order'] == "P") {
                                       $status_order_P_1 = $status_order_P;
                                       print "<td>
                                        <span>$status_order_P_1</span>"
                                         ?>

                                       <a href="#" data-toggle="modal" data-target="#ViewTest<?php echo $v['id_lab_order'] ?>"><span class="right badge badge-info"><i class="fa fa-eye"></i></span></a>
                                       <?php 
                                       print "<a href='#' onclick='loadpage(" . '"laboratory/result/save_result.php?cod=' . $v['id_lab_order'] . '"' . ")'><span class='right badge badge-success'><i class='fa fa-cog fa-fw'></i></span></a>"
                                        ?>
                                       </td>
                                       <?php 
                                     }elseif ($v['status_order'] == "R"){
                                       $status_order_R_1 = $status_order_R;
                                       print "<td>
                                        <span>$status_order_R_1 </span>
                                        <a href='#' onclick='loadpage(" . '"laboratory/result/edit.php?cod=' . $v['id_lab_order'] . '"' . ")'><span class='right badge badge-warning'><i class='fa fa-cog fa-pen'></i></span></a>
                                        <a href='#' onclick='AlertarImprimir(" . $v['id_lab_order'] .")'><span class='right badge badge-danger'>Confirmar<i class='fa fa-check'></i></span></a>"
                                        ?>
                                       <?php
                                        print "</td>";
                                     }elseif ($v['status_order'] == "T"){
                                      $status_order_T_1  = $status_order_T;
                                      print "<td>"
                                     ?>
                                     <!--<a href="#" data-toggle="modal" data-target="#ViewPrintResult<?php echo $v['id_lab_order'] ?>"><span class="right badge badge-info"><i class="fa fa-print"></i></span></a>-->
                                     <a class='btn btn-success btn-xs' href="modules/admission/patient/reporte_pdf.php?cod=<?php echo $v['id_lab_order'] ?>">&nbsp;PDF&nbsp;</a>
                                     <?php
                                     print "</td>";
                                     }
                                    print "</tr>";
                                    $numero++;
                                    include('modal_view_test.php');
                                    //include('modal_view_print.php');
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


    function AlertarImprimir(id_lab_order){
      Swal.fire({
        title: 'Estas seguro de Confirmar el resultado?',
        text: "Al confirmar no podra editar este resultado!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si Confírmalo!'
      }).then((result) => {
        if (result.isConfirmed) {
           ViewPrint(id_lab_order);
        }
      })
  }

  function ViewPrint(id_lab_order){
    parametros = {"id_lab_order": id_lab_order}
    $.ajax({
      data:parametros,
      url: './modules/laboratory/result/save.php?boton=PrintResult',
      beforeSend:function(){},
      success:function(){
        loadpage("laboratory/result/index.php");
        }
    })

  }
</script>



                       