<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
$sql = "select a.id_area, a.description, a.status, ta.description as type_area, ta.id_type_area, s.description as samples
from tbl_area a, tbl_type_area ta, tbl_type_sample s
where ta.id_type_area = a.id_type_area AND s.id_type_sample = a.id_type_sample  AND a.status = 1";
$numero = 1;
$query = $idb->prepare($sql);
$query->execute();
$resultado = $query->fetchAll();
?>
<div class="card">
<div class="row">
   <div class="col-11"><div class="card-header"><h3 class="card-title d-flex justify-content-center ">Areas</h3></div></div>

                 <div class="col-1 d-flex justify-content-center" >
                 <div class='col-sm-12'>
                     <br>
                 <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;"onclick='loadpage("config/area/new.php")' >
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
                                    <th>TIPO AREA</th> 
                                    <th>TIPO MUESTRA</th>
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
                                    print "<td>" . $v["type_area"] . "</td>";
                                    print "<td>" . $v["samples"] . "</td>";
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
                                       <a href='#' onclick='loadpage(" . '"config/area/edit.php?cod=' . $v['id_area'] . '"' . ")'><span class='right badge badge-success'><i class='fa fa-pen'></i></span></a>
                                       <a href='#' onclick='AlertarEliminar(" . $v['id_area'] .")'><span class='right badge badge-danger'><i class='fa fa-trash'></i></span></a>
                                       </td>";
                                    } elseif ($_SESSION['tipousuario_slug'] == 'Adm') {
                                        print "<td>
                                       <a href='#' onclick='loadpage(" . '"config/area/edit.php?cod=' . $v['id_area'] . '"' . ")'><span class='right badge badge-success'><i class='fa fa-pen'></i></span></a>
                                       <a href='#' onclick='AlertarEliminar(" . $v['id_area'] .")'><span class='right badge badge-danger'><i class='fa fa-trash'></i></span></a>
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

   function DeleteArea(id_area){
    parametros = {"id_area": id_area}
    $.ajax({
      data:parametros,
      url: './modules/config/area/save.php?boton=delete_Areas',
      beforeSend:function(){},
      success:function(){
        loadpage("config/area/index.php");
         Swal.fire(
            'Eliminado!',
            'El registro fue eliminado correctamente.',
            'success'
          )
      }
    })

  }

  function AlertarEliminar(id_area){
      Swal.fire({
        title: 'Estas seguro de eliminar?',
        text: "No volveras a usar esta Area!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si Borralo!'
      }).then((result) => {
        if (result.isConfirmed) {
           DeleteArea(id_area);
        }
      })
  }
</script>



                       