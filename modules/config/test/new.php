<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
?>

    
   </style>
<div class="container-fluid">
    <div class="card card-default"> 
    <div class="card-header">
            <h3 class="card-title">Registrar Prueba</h3>
    </div>
        <form method="post" id="formmodulos" action="save.php">
                <div class="card-body">
                <div class="row">
              <div class="col-md-6">
                    <!--<input id="id_usuario" name="id_usuario" type="hidden" value="" placeholder="Ingrese nombre de insumo"  class="form-control1" id="inputSuccess1">-->
                   
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess1">Nombre de la Prueba</label>
                        <input id="description" name="description" type="text" placeholder="Ingrese nombre de la prueba" maxlength="100"  class="form-control" />
                        <span class="help-block"></span>
                    </div>
                      
                  </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess1">Costo de la prueba</label>
                        <input id="cost" name="cost" type="number" placeholder="Ingrese el costo de la prueba" maxlength="100"  class="form-control" />
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group input-group-sm">
                        <label>
                            <?php
                            echo '<input class="ace id="status" name="status" checked="checked"  type="checkbox" value="1" />';
                            ?>                                      
                            <span class="lbl"> Estado</span>
                        </label>
                    </div>
                    </div>
                     </div>
                     
                        <div id="feature">
                          <center><h4>CARACTERISTICAS DE LA PRUEBA</h4></center>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                <label class="control-label" for="inputSuccess1">Caracteristica</label>
                                 <input id="features" name="features[]" type="text" placeholder="Ingrese nombre de Caracteristica" maxlength="100"  class="form-control" />
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
                       <div class="newData"></div>
                         

                     </div>
                     <br>
                    <div class="form-actions center">
                        <center>
                            <input type="submit" value="Registrar" id="boton" name="boton" class="btn btn-sm btn-success boton">
                            <a class="btn btn-sm btn-danger" onclick="loadpage('./config/test/index.php')" >Cancelar</a>
                        </center>
                    </div>
                
           
        </form>
    </div>
</div>

<script>
   


 $(document).ready(function() {
        $("#formmodulos").validate({
            rules: {
                description: {required: true, minlength: 3},
                id_area: {required: true},
                cost:{required: true},
                features: {required: true},

            },
            messages: {
                // descripcion: "Debe seleccionar una opcion.'",

            }, submitHandler: function(form) {
                $.ajax({
                    url: "./modules/config/test/" + $("#formmodulos").attr("action"),
                    data: $("#formmodulos").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                    success: function(result) {
                    //  console.log(result);
                      if (result) {
                             toastr.success('Registro Satisfactorio')
                         }else{
                            toastr.error('Error de registro')
                         }
                        loadpage("config/test/index.php");
                    }
                });
            }
        });
    });

$(function () { 
      var i = 1;
      $('.add-btn').click(function (e) {
        e.preventDefault();
          i++;

        $('.newData').append('<div id="newRow'+i+'" class="form-row">'
            +'<div class="col-md-6">'
              +'<label>Caracteristicas</label>'
              +'<input type="text" name="features[]" class="form-control" placeholder="Ingrese nombre de Caracteristica">'
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



