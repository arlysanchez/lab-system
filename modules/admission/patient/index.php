<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
$sql = "select tper.num_doc, CONCAT(tper.nombre,' ',tper.apellido_pat,' ',tper.apellido_mat)full_name,tper.genero,tper.id_persona,tp.id_patient
       FROM tbl_patient tp, tbl_persona tper
       WHERE tper.id_persona = tp.id_person ";   //prepared statements 
$numero = 1;
$query = $idb->prepare($sql);
$query->execute();
$resultado = $query->fetchAll();
?>
<div class="card">
<div class="row">
   <div class="col-11"><div class="card-header"><h3 class="card-title d-flex justify-content-center ">Pacientes</h3></div></div>

                 <div class="col-1 d-flex justify-content-center" >
                 <div class='col-sm-12'>
                     <br>
                 <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;"onclick='loadpage("admission/order/new_patient.php?cod=P")' >
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
                                    <th>DOCUMENTO</th>
                                    <th>PACIENTE</th> 
                                    <th>GENERO</th>
                                     <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>        
                                <?php
                                foreach ($resultado as $v) {
                                    print "<tr>";
                                    print "<td>" . $numero . "</td>";
                                    print "<td>" . $v["num_doc"] . "</td>";
                                    print "<td>" . $v["full_name"] . "</td>";
                                    print "<td>" . $v["genero"] . "</td>";
                                    print "<td>
                                        <a href='#' onclick='loadpage(" . '"admission/patient/edit.php?cod=' . $v['id_patient'] . '"' . ")'><span class='right badge badge-success'><i class='fa fa-pen'></i></span></a>
                                        <a href='#' onclick='loadpage(" . '"admission/patient/history.php?cod=' . $v['id_patient'] . '"' . ")'><span class='right badge badge-warning'><i class='fa fa-cog fa-fw'></i></span></a>";
                                    print "</td>";
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



                       