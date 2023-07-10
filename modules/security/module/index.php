<?php
//error_reporting(0);
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
  $sql = "SELECT  m.url,m.descripcion as modulo,m.icono,p.descripcion as padre,m.codmodulo, m.estado
        FROM tbl_modulos m LEFT  JOIN tbl_modulos p  ON p.codmodulo = m.idpadre ORDER BY p.descripcion";   //prepared statements 
            $numero = 1;
            $query = $idb->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll();
?>

<div class="card">

  <div class="row">
   <div class="col-11"><div class="card-header"><h3 class="card-title d-flex justify-content-center ">MODULOS</h3></div></div>

                 <div class="col-1 d-flex justify-content-center" >
                 <div class='col-sm-12'>
                     <br>
                 <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;"onclick='loadpage("security/module/new.php")' >
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
                                            <th>MODULO</th> 
                                            <th>URL</th> 
                                            <th>MODULO PADRE</th>
                                            <th>ICONO</th>
                                            <th>ESTADO</th>
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
                                            print "<tr>";
                                            print "<td>" . $numero . "</td>";
                                            print "<td>" . $v["modulo"] . "</td>";
                                            print "<td>" . $v["url"] . "</td>";
                                            print "<td>" . $v["padre"] . "</td>";
                                            print "<td>" . $v["icono"] . "</td>";
                                            $activo = '<span  class="right badge badge-primary">Activo</span>';
                                            $inactivo = '<span class="right badge badge-danger"><i class="ace-icon fa fa-exclamation-triangle bigger-120"></i>Desactivo</span>';
                                            if ($v['estado'] == 1) {
                                                $estado = $activo;
                                            } else {
                                                $estado = $inactivo;
                                            }
                                            print "<td>" . $estado . "</td>";
                                            if ($_SESSION['tipousuario_slug'] == 'S_Admin') {
                                                print "<td>
                                                <a href='#' onclick='loadpage(" . '"security/module/edit.php?cod=' . $v['codmodulo'] . '"' . ")'><span class='right badge badge-success'><i class='fa fa-pen'></i></span></a>
                                                <a href='#' onclick='loadpage(" . '"security/module/delete.php?cod=' . $v['codmodulo'] . '"' . ")'><span class='right badge badge-danger'><i class='fa fa-trash'></i></span></a>
                                                </td>";
                                            } elseif ($_SESSION['tipousuario_slug'] == 'Adm') {
                                                print "<td>
                                               <a href='#' onclick='loadpage(" . '"seguridad/module/edit.php?cod=' . $v['codmodulo'] . '"' . ")'><span class='green'><i class='fa fa-pencil fa-lg'></i></span></a>
                                               <a href='#' onclick='loadpage(" . '"seguridad/module/eliminar.php?cod=' . $v['codmodulo'] . '"' . ")'><span class='reds'><i class='fa fa-trash fa-lg'></i></span></a>
                                       </td>";
                                            }
                                            print "</tr>";
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



