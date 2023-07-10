<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
if (isset($_GET['cod'])) {
    $id_patient = $_GET['cod'];
$sql = "select id_lab_order, date_register_order, status_order, num_order, id_patient from tbl_lab_order where id_patient = $id_patient";   //prepared statements 
$numero = 1;
$query = $idb->prepare($sql);
$query->execute();
$resultado = $query->fetchAll();
}
?>
<div class="card">
<div class="row">
   <div class="col-11"><div class="card-header"><h3 class="card-title d-flex justify-content-center ">Historial</h3></div></div>

                 <div class="col-1 d-flex justify-content-center" >
                 <div class='col-sm-12'>
                     <br>
                 <button type="button" class="btn btn-danger float-right" style="margin-right: 5px;"onclick='loadpage("./admission/patient/index.php")' >
                    <i class="fas fa-"></i>CANCELAR
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
                                    <th>FECHA</th>
                                    <th>N° ORDEN</th>
                                     <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>        
                                <?php
                                foreach ($resultado as $v) {
                                    $id_lab_order = $v['id_lab_order'];
                                    print "<tr>";
                                    print "<td>" . $numero . "</td>";
                                    print "<td>" . $v["date_register_order"] . "</td>";
                                    print "<td>" . $v["num_order"] . "</td>";
                                    print "<td>";
                                     if ($v['status_order'] == 'T') {
                                      ?>
                                         <a class='btn btn-success btn-xs' href="modules/admission/patient/reporte_pdf.php?cod=<?php echo $id_lab_order ?>">&nbsp;PDF&nbsp;</a>
                                   <?php
                                 }else{
                                   print "<span class='right badge badge-danger'>Resultado Pediente</span>";
                                 }
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



                       