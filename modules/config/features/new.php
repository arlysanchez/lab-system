<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
?>
<div class="container-fluid">
    <div class="card card-default"> 
    <div class="card-header">
            <h3 class="card-title">Registrar Caracteristicas</h3>
    </div>
<form method="post" id="formmodulos" action="save.php">
                <div class="card-body">
                <div class="row">
              <div class="col-md-6">
                    <div class="form-group">
                  <label>Prueba</label>
                  <select name="id_test" class="form-control select2" style="width: 100%;">
                    <option selected="selected">Seleccione</option>
                    <?php
                            $query = "select * from tbl_test where status=1 ";
                            $data = $idb->prepare($query);
                            $data->execute();
                           while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                            if ($id_test == $row['id_test']) {
                                 echo "<option value='" . $row['id_test'] . "' selected='selected'>" . $row['description'] . "</option>";
                                } else {
                                    echo "<option value='" . $row['id_test'] . "'>" . $row['description'] . "</option>";
                                }
                            }
                    ?>
                  </select>
                </div>
                </div>
                    <div class="col-md-6">
                    
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                <label class="control-label" for="inputSuccess1">Caracteristica</label>
                                 <input id="description" name="description[]" type="text" placeholder="Ingrese nombre de Caracteristica" maxlength="100"  class="form-control" />
                               </div>
                              </div>
                              <div class="col-md-5">
                                <div class="form-group">
                                <label class="control-label" for="inputSuccess1">Valor de referencia</label>
                                 <input id="reference_value[]" name="reference_value[]" type="text" placeholder="Ingrese el valor de la referencia" maxlength="100"  class="form-control" />
                               </div>
                              </div>
                              <div class="col-md-1">
                               <label for="code" class="text-left"></label><br>
                              <button type="button" class="btn add-btn btn-success">
                              <i class="fa fa-plus fa-sm"></i>
                              </button>
                           </div>
                         </div>
                       <div class="newData"></div><br>
                     </div>
            </div>
            <div class="form-actions center">
                        <center>
                            <input type="submit" value="Registrar" id="boton"  name="boton" class="btn btn-sm btn-success boton">
                            <a class="btn btn-sm btn-danger" onclick="loadpage('./config/features/index.php')" >Cancelar</a>
                        </center>
                    </div>
        </div>
        </form>
      </div>
    </div>

   <script>
    $(document).ready(function() {
        $('#tablapersona').DataTable();
    });

    $(document).ready(function() {
        $("#formmodulos").validate({
            rules: {
                description: {required: true, minlength: 3}
            },
            messages: {
                // descripcion: "Debe seleccionar una opcion.'",

            }, submitHandler: function(form) {
                $.ajax({
                    url: "./modules/config/features/" + $("#formmodulos").attr("action"),
                    data: $("#formmodulos").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                    success: function(result) {
                        if (result) {
                             toastr.success('Registro Satisfactorio')
                         }else{
                            toastr.error('Error de registro')
                         }
                        loadpage("config/features/index.php");
                    }
                });
            }
        });
    });

$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

  })
$(function () { 
      var i = 1;
      $('.add-btn').click(function (e) {
        e.preventDefault();
          i++;

        $('.newData').append('<div id="newRow'+i+'" class="form-row">'
            +'<div class="col-md-6">'
              +'<label>Caracteristicas</label>'
              +'<input type="text" name="description[]" class="form-control" placeholder="Ingrese nombre de Caracteristica">'
            +'</div>'
            +'<div class="col-md-5">'
            +'<label>Valor de referencia</label>'
             +'<input type="text" name="reference_value[]" class="form-control" placeholder="Ingrese el valor de la referencia">' 
            +'</div>'
            +'<div class="col-md-1"><a href="#" class="remove-lnk" id="'+i+'"><span class="right badge badge-danger"><i class="fa fa-trash"></i></span></a></div>'
            +'</div>'
          );  
      });
 

       $(document).on('click', '.remove-lnk', function(e) {
         e.preventDefault();
          var id = $(this).attr("id");
           $('#newRow'+id+'').remove();
        });
 
    });
</script>

  



