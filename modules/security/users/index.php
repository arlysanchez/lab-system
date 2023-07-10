<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
$sql = "SELECT tu.id_usuario, tu.usuario, ttu.descripcion tu, p.nombre, p.apellido_pat, p.apellido_mat, tu.estado
FROM tbl_usuarios tu, tbl_tipousuario ttu, tbl_persona p
WHERE ttu.id_tipousuario = tu.id_tipousuario and p.id_persona = tu.id_persona and tu.estado='1'";   //prepared statements 
$numero = 1;
$query = $idb->prepare($sql);
$query->execute();
$resultado = $query->fetchAll();
?>
<div class="card">

  <div class="row">
   <div class="col-11"><div class="card-header"><h3 class="card-title d-flex justify-content-center ">Usuarios</h3></div></div>

                 <div class="col-1 d-flex justify-content-center" >
                 <div class='col-sm-12'>
                     <br>
                 <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;"onclick='loadpage("security/users/new.php")' >
                    <i class="fas fa-plus"></i>NUEVO
                  </button>
                  </div>
    </div>
   </div>

    <div class="card-body">
        <div class='col-sm-12'>

            <table id="example1" class="table table-bordered table-striped">
                <thead >
                    <tr class="tre">
                        <th>Nro.</th> 
                        <th>Nombres</th>
                        <th>Usuario</th> 
                        <th>Tipo de usuario</th> 
                        <th>Estado</th> 
                        <?php if ($_SESSION['tipousuario_slug'] == 'S_Admin') { ?>
                            <th>ACCIONES</th>
                        <?php } elseif ($_SESSION['tipousuario_slug'] == 'Adm') { ?>
                            <th>ACCIONES</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>        
                    <?php
                    foreach ($resultado as $v) {
                        echo "<tr>";
                        echo "<td>" . $numero . "</td>";
                        echo '<td>' . $v['nombre'] . ' ' . $v['apellido_pat'] . ' ' . $v['apellido_mat'] . '</td>';
                        echo "<td>" . ' ' . $v["usuario"] . "</td>";
                        echo "<td>" . ' ' . $v["tu"] . "</td>";
                        $activo = '<span  class="right badge badge-primary">Activo</span>';
                        $inactivo = '<span class="right badge badge-danger"><i class="ace-icon fa fa-exclamation-triangle bigger-120"></i>Desactivo</span>';
                        if ($v['estado'] == 1) {
                            $estado = $activo;
                        } else {
                            $estado = $inactivo;
                        }
                        echo "<td>" . $estado . "</td>";
                        if ($_SESSION['tipousuario_slug'] == 'S_Admin') {

                            echo "<td>
                                      <a href='#' onclick='loadpage(" . '"security/users/edit.php?cod=' . $v['id_usuario'] . '"' . ")'><span class='right badge badge-success'><i class='fas fa-pen'></i></span></a>
                                       <a href='#' onclick='loadpage(" . '"security/users/delete.php?cod=' . $v['id_usuario'] . '"' . ")'><span class='right badge badge-danger'><i class='fa fa-trash'></i></span></a>
                                       </td>";
                        } elseif ($_SESSION['tipousuario_slug'] == 'Adm') {
                            echo "<td>
                                      <a href='#' onclick='loadpage(" . '"security/users/edit.php?cod=' . $v['id_usuario'] . '"' . ")'><span class='right badge badge-success'><i class='fa fa-pen'></i></span></a>
                                       <a href='#' onclick='loadpage(" . '"security/users/delete.php?cod=' . $v['id_usuario'] . '"' . ")'><span class='right badge badge-danger'><i class='fa fa-trash'></i></span></a>
                                       </td>";
                        }
                        echo "</tr>";
                        $numero++;
                    }
                    ?>    
                </tbody>


            </table>
        </div>

    </div>
    <!-- /.box-body -->
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
                    