<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
$sql = " select f.id_features, f.description, f.reference_value, f.status, t.id_test, t.description as area FROM tbl_features f, tbl_test t 
WHERE t.id_test = f.id_test AND f.status =1";   //prepared statements 
$numero = 1;
$query = $idb->prepare($sql);
$query->execute();
$resultado = $query->fetchAll();
?>
<div class="card">
<div class="row">
   <div class="col-11"><div class="card-header"><h3 class="card-title d-flex justify-content-center ">Caracteristicas de las pruebas</h3></div></div>

                 <div class="col-1 d-flex justify-content-center" >
                 <div class='col-sm-12'>
                     <br>
                 <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;"onclick='loadpage("config/features/new.php")' >
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
                                    <th>DESCRIPCION</th>
                                    <th>REFERENCIA</th>
                                    <th>PRUEBA</th>
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
                                    print "<td>" . $v["description"] . "</td>";
                                    print "<td>" . $v["reference_value"] . "</td>";
                                     print "<td>" . $v["area"] . "</td>";
                                    $activo = '<span class="right badge badge-primary">Activo</span>';
                                    $inactivo = '<span class="right badge badge-danger"><i class="ace-icon fa fa-exclamation-triangle bigger-120"></i>Desactivo</span>';
                                    if ($v['status'] == 1) {
                                        $status = $activo;
                                    } else {
                                        $status = $inactivo;
                                    }
                                    print "<td>" . $status . "</td>";
                                    if ($_SESSION['tipousuario_slug'] == 'S_Admin') {
                                        print "<td>
                                       <a href='#' onclick='loadpage(" . '"config/features/edit.php?cod=' . $v['id_features'] . '"' . ")'><span class='right badge badge-success'><i class='fa fa-pen'></i></span></a>
                                       <a href='#' onclick='AlertarEliminar(" . $v['id_features'] .")'><span class='right badge badge-danger'><i class='fa fa-trash'></i></span></a>
                                       </td>";
                                    } elseif ($_SESSION['tipousuario_slug'] == 'Adm') {
                                        print "<td>
                                       <a href='#' onclick='loadpage(" . '"config/features/edit.php?cod=' . $v['id_features'] . '"' . ")'><span class='right badge badge-success'><i class='fa fa-pen'></i></span></a>
                                       <a href='#' onclick='AlertarEliminar(" . $v['id_features'] .")'><span class='right badge badge-danger'><i class='fa fa-trash'></i></span></a>
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

  function DeleteFeatures(id_features){
    parametros = {"id_features": id_features}
    $.ajax({
      data:parametros,
      url: './modules/config/features/save.php?boton=delete_features',
      beforeSend:function(){},
      success:function(){
        loadpage("config/features/index.php");
         Swal.fire(
            'Eliminado!',
            'El registro fue eliminado correctamente.',
            'success'
          )
      }
    })

  }

  function AlertarEliminar(id_features){
      Swal.fire({
        title: 'Estas seguro de eliminar?',
        text: "No volveras a usar esta Caracteristica!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si Borralo!'
      }).then((result) => {
        if (result.isConfirmed) {
           DeleteFeatures(id_features);
        }
      })
  }
</script>



                       