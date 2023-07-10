<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
if (isset($_GET['cod'])) {
    $flag = $_GET['cod'];

    }

    $sql = "select id_persona, CONCAT(nombre,' ', apellido_pat,' ', apellido_mat) as persona, num_doc FROM tbl_persona  ";   //prepared statements 
$numero = 1;
$query = $idb->prepare($sql);
$query->execute();
$resultado1 = $query->fetchAll();
?>
<style type="text/css">
    #reniec, #manual, #newpaciente{
      display:none;
    }
   </style>
<div class="container-fluid">
<div class="card card-default"> 
 <div class="card-header">
            <div class="row">
   <div class="col-11"><h3 class="card-title d-flex justify-content-center ">Registar Paciente</h3></div>

                 <div class="col-1 d-flex justify-content-center" >
                 <div class='col-sm-12'>
                    <?php if ($flag =='P') {
                    print "<button type='button' class='btn btn-danger float-right' onclick='loadpage(" . '"./admission/patient/index.php"' . ")' >";    
                    }else{
                    print "<button type='button' class='btn btn-danger float-right' onclick='loadpage(" . '"admission/order/new.php"' . ")' >";
                    } ?>
                    CANCELAR
                  </button>
                  </div>
    </div>
   </div>
    </div>
        <br>
       <center>
        <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">TIPO DE REGISTRO<i></i></label>
                        <div class="checkbox">
                            <!--<label>-->    
                            <input type="radio" name="type_register" 
                            <?php if (isset($type_register) && $type_register == "1") echo "checked"; ?>
                                   value="1" onclick="showReniec()">  CONSULTA RENIEC 
                            <!--</label>-->
                            <!--<label>-->
                            <input type="radio" name="type_register" 
                            <?php if (isset($type_register) && $type_register == "2") echo "checked"; ?>
                                   value="2" onclick="showManual()">  MANUAL

                          <?php  if ($_SESSION['tipousuario_slug'] == 'Adm' || $_SESSION['tipousuario_slug'] == 'S_Admin') { ?>
                             <input type="radio" name="type_register" 
                            <?php if (isset($type_register) && $type_register == "3") echo "checked"; ?>
                                   value="3" onclick="showPaciente()">  ASIGNAR COMO PACIENTE
                               <?php } ?>
                            <!--</label>-->
                        </div>
        </div>
    </center>
    <div id="manual">
    <form method="post" id="formodule" action="save.php">
                 <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Nombre <i>*</i></label>
                         <input id="flag" name="flag" type="hidden" value="<?php echo $flag ?>" class="form-control" />
                        <input id="nombre" name="nombre" type="text" placeholder="Nombre" maxlength="100"  class="form-control" />
                        <span class="help-block"></span>

                        <label class="control-label" for="inputSuccess1">Apellido Paterno <i>*</i></label>
                        <input id="apellido_pat" name="apellido_pat" type="text" placeholder="Apellido Paterno" maxlength="100"  class="form-control"
                               />
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group input-group-sm">

                    </div>
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Apellido Materno <i>*</i></label>
                        <input id="apellido_mat" name="apellido_mat" type="text" placeholder="Apellido Paterno" maxlength="100"  class="form-control"/>
                        <span class="help-block"></span>
                    </div>

                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Tipo Doc<i>*</i></label>
                        <select name="id_tipo_doc"   class="form-control"  > 
                            <option>Seleccione</option>
                            <?php
                            $query = "select * from tbl_tipo_doc";
                            $data = $idb->prepare($query);
                            $data->execute();
                            while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                if ($id_tipo_doc == $row['id_tipo_doc']) {
                                    echo "<option value='" . $row['id_tipo_doc'] . "' selected='selected'>" . $row['descripcion'] . "</option>";
                                } else {
                                    echo "<option value='" . $row['id_tipo_doc'] . "'>" . $row['descripcion'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Numero Doc <i>*</i></label>
                        <input id="num_doc" name="num_doc" type="text" placeholder="Numero Documento" maxlength="12"  class="form-control"/>

                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                     <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Fecha Nacimiento <i>*</i></label>
                        <input id="fecha_nac" name="fecha_nac" type="date"   placeholder="dd/mm/yyyy" maxlength="100"  class="form-control"  />
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Genero <i>*</i></label>
                        <div class="checkbox">
                            <!--<label>-->    
                            <input type="radio" name="genero" 
                            <?php if (isset($genero) && $genero == "F") echo "checked"; ?>
                                   value="F">  Femenino
                            <!--</label>-->
                            <!--<label>-->
                            <input type="radio" name="genero" 
                            <?php if (isset($genero) && $genero == "M") echo "checked"; ?>
                                   value="M">  Masculino
                            <!--</label>-->
                        </div>
                    </div>
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Direccion <i></i></label>
                        <input id="direccion" name="direccion" type="text"   placeholder="Direccion" maxlength="100"  class="form-control"/>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Numero Celular<i>*</i></label>
                        <input id="num_celular" name="num_celular" type="text" placeholder="Numero Celular" maxlength="9"  class="form-control"/>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group has-success">
                        <label class="control-label" for="inputSuccess1">Estado</label>
                        <?php
                        echo '<input class="ace id="estado" name="estado" checked="checked"  type="checkbox" value="1" />';
                        ?>  
                    </div>

                    <div class="form-actions center">
                        <center>
                            <input type="submit" value="Registrar paciente" id="boton" name="boton" class="btn btn-sm btn-success"> 

                        </center>
                    </div>
                </div>
             </div>
            </div>
        </form>
        </div>

    <div id="reniec">
        
       <center>
        <div class="col-md-4">
        <div class="input-group input-group-sm">
          <input class="form-control"  placeholder="Ingrese un numero de DNI" aria-label="Search" id="dni">
          <div class="input-group-append">
            <button class="btn btn-success" id="buscar"><i class="fas fa-search fa-fw"></i></button>
          </div>
        </div>
        </div>
        </center>
        <form method="post" id="formid" action="save.php">
         <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Nombre <i>*</i></label>
                         <input id="flag" name="flag" type="hidden" value="<?php echo $flag ?>" class="form-control" />
                        <input id="nombre_r" name="nombre" type="text" placeholder="Nombre" maxlength="100" readonly="readonly" class="form-control"  />
                        <span class="help-block"></span>

                        <label class="control-label" for="inputSuccess1">Apellido Paterno <i>*</i></label>
                        <input id="apellido_pat_r" name="apellido_pat" type="text" placeholder="Apellido Paterno" readonly="readonly" maxlength="100"  class="form-control" 
                               />
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group input-group-sm">

                    </div>
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Apellido Materno <i>*</i></label>
                        <input id="apellido_mat_r" name="apellido_mat" type="text" placeholder="Apellido Paterno" readonly="readonly" maxlength="100"  class="form-control" />
                        <span class="help-block"></span>
                    </div>

                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Tipo Doc<i>*</i></label>
                        <select name="id_tipo_doc" id="tipo_doc_r"  class="form-control" readonly="readonly" > 
                            <option>Seleccione</option>
                            <?php
                            $query = "select * from tbl_tipo_doc";
                            $data = $idb->prepare($query);
                            $data->execute();
                            while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                if ($id_tipo_doc == $row['id_tipo_doc']) {
                                    echo "<option value='" . $row['id_tipo_doc'] . "' selected='selected'>" . $row['descripcion'] . "</option>";
                                } else {
                                    echo "<option value='" . $row['id_tipo_doc'] . "'>" . $row['descripcion'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Numero Doc <i>*</i></label>
                        <input id="num_doc_r" name="num_doc" type="text" placeholder="Numero Documento" readonly="readonly" maxlength="12"  class="form-control"  />

                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                     <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Fecha Nacimiento <i>*</i></label>
                        <input id="fecha_nac" name="fecha_nac" type="date"   placeholder="dd/mm/yyyy" maxlength="100"  class="form-control"  />
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Genero <i>*</i></label>
                        <div class="checkbox">
                            <!--<label>-->    
                            <input type="radio" name="genero" 
                            <?php if (isset($genero) && $genero == "F") echo "checked"; ?>
                                   value="F">  Femenino
                            <!--</label>-->
                            <!--<label>-->
                            <input type="radio" name="genero" 
                            <?php if (isset($genero) && $genero == "M") echo "checked"; ?>
                                   value="M">  Masculino
                            <!--</label>-->
                        </div>
                    </div>
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Direccion <i></i></label>
                        <input id="direccion" name="direccion" type="text"   placeholder="Direccion" maxlength="100"  class="form-control"/>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Numero Celular<i>*</i></label>
                        <input id="num_celular" name="num_celular" type="text" placeholder="Numero Celular" maxlength="9"  class="form-control"/>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group has-success">
                        <label class="control-label" for="inputSuccess1">Estado</label>
                        <?php
                        echo '<input class="ace id="estado" name="estado" checked="checked"  type="checkbox" value="1" />';
                        ?>  
                    </div>

                    <div class="form-actions center">
                        <center>
                            <input type="submit" value="Registrar paciente" id="boton" name="boton" class="btn btn-sm btn-success boton">

                        </center>
                    </div>
                </div>
             </div>
            </div>
        </form>
    </div>
    <div id="newpaciente">
        <form method="POST" id="newform" action="save.php">
        <center>
         <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
         <div class="input-group input-group-xm">
            <input id="flag" name="flag" type="hidden" value="<?php echo $flag ?>" class="form-control" />
          <input type="text" id="nombre_per" name="nombre_per" class="form-control" placeholder="Buscar persona" readonly="readonly">
          <input type="hidden"  id="id_persona" name="id_persona">
          <span class="input-group-btn">
           <button type="button"  data-toggle="modal" data-target="#myModalperson" class="btn btn-success boton btn-flat"><i class="fa fa-search" aria-hidden="true"></i></button>  </span>&nbsp;
           <input type="submit" value="Registrar" id="boton" name="boton" class="btn btn-sm btn-info boton">
          </div>
        </div>
        <div class="col-lg-4"></div>
        </div>
        </center>
        </form>
         <br>
        <br>
    </div>
</div>
</div>

<!--Modal person-->

<div class="modal fade" id="myModalperson" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header color ">
                   <center>BUSCAR PERSONA</center> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                <div class="modal-body">
                 <table id="example1" class="table table-bordered table-striped">
                <thead >
                                <tr class='tre'>                                
                                    <th>NRO</th>
                                    <th>PERSONA</th> 
                                    <th>DOCUMENTO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>        
                                <?php
                                foreach ($resultado1 as $v) {
                                    print "<tr>";
                                    print "<td>" . $numero . "</td>";
                                    print "<td>" . $v["persona"] . "</td>";
                                    print "<td>" . $v["num_doc"] . "</td>";
                                     print '<td><a data-dismiss="modal" aria-label="Close" href="#"  onclick="seleccionarPersona(' . $v['id_persona'] . ',\'' . str_replace("'", "\'", $v['persona']) . '\')"><span class="glyphicon glyphicon-circle-arrow-up"></span> Elegir</a></td></td>';
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

<!--<script src="jquery-ui.js"></script>-->
<script>
    

function showReniec(){
         document.getElementById('reniec').style.display= 'block';
         document.getElementById('manual').style.display= 'none';
         document.getElementById('newpaciente').style.display= 'none';

     }
    
function showManual(){
         document.getElementById('manual').style.display='block';
         document.getElementById('reniec').style.display='none';
         document.getElementById('newpaciente').style.display= 'none';

     }

function showPaciente(){
         document.getElementById('newpaciente').style.display= 'block';
         document.getElementById('reniec').style.display='none';
         document.getElementById('manual').style.display='none';
     }

     function seleccionarPersona(id, nombrecompleto) {
        $("#nombre_per").val(nombrecompleto);
        $("#id_persona").val(id);
        $("#myModalperson").modal('hide');
    }

     $('#buscar').click(function() {
         //probar datos en consola
         //data=$('#documento').val();
         //console.log(data);
         dni=$('#dni').val();
         $.ajax({
           url:'./modules/admission/order/search_person.php',
           type: 'post',
           data: 'dni='+dni,
           dataType:'json',
           success:function(r){
           if(r.numeroDocumento==dni){
            $('#apellido_pat_r').val(r.apellidoPaterno);
            $('#apellido_mat_r').val(r.apellidoMaterno); 
            $('#nombre_r').val(r.nombres);
            $('#tipo_doc_r').val(r.tipoDocumento);
            $('#num_doc_r').val(r.numeroDocumento);
             
            
           }else{
              alert(r.error);
           }
          // console.log(r);
           }
         });
     });
    $(document).ready(function() {
        $("#formid").validate({
            rules: {
                nombre: {required: true},
                apellido_pat: {required: true},
                apellido_mat: {required: true},
                nro_doc: {required: true, minlength: 8},
                genero: {required: true},
                id_tipo_doc: {required: true},
                fecha_nacimiento:{required: true},
               
            },
            messages: {
            }, submitHandler: function(form) {
                $.ajax({
                    url: "./modules/admission/order/" + $("#formid").attr("action"),
                    data: $("#formid").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                     success: function(data) {
                     var new_var= data.replace(/(\r\n|\n|\r)/gm, "");
                        if (new_var == "P") {
                                toastr.success('Paciente Registrado')
                             loadpage("admission/patient/index.php");
                            } else if (new_var == "A") {
                                toastr.success('Paciente Registrado')
                             loadpage("admission/order/new.php");
                            }else if (new_var == "E") {
                                toastr.error('Ya esta registrado esa persona')
                            } else {
                                toastr.error('Error de registro')
                            }
                    }
                });
            }
        });
    });
$(document).ready(function() {
        $("#formodule").validate({
            rules: {
                nombre: {required: true},
                apellido_pat: {required: true},
                apellido_mat: {required: true},
                nro_doc: {required: true, minlength: 8},
                genero: {required: true},
                id_tipo_doc: {required: true},
                fecha_nacimiento:{required: true},
               
            },
            messages: {
            }, submitHandler: function(form) {
                $.ajax({
                    url: "./modules/admission/order/" + $("#formodule").attr("action"),
                    data: $("#formodule").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                    success: function(data) {
                     var new_var= data.replace(/(\r\n|\n|\r)/gm, "");
                        if (new_var == "P") {
                                toastr.success('Paciente Registrado')
                             loadpage("admission/patient/index.php");
                            } else if (new_var == "A") {
                                toastr.success('Paciente Registrado')
                             loadpage("admission/order/new.php");
                            }else if (new_var == "E") {
                                toastr.error('Ya esta registrado esa persona')
                            } else {
                                toastr.error('Error de registro')
                            }
                    }
                });
            }
        });
    });

$(document).ready(function() {
        $("#newform").validate({
            rules: {
                id_persona: {required: true},
               
            },
            messages: {
            }, submitHandler: function(form) {
                $.ajax({
                    url: "./modules/admission/order/" + $("#newform").attr("action"),
                    data: $("#newform").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                    success: function(result) {
                        console.log(result);
                      if (result) {
                            toastr.success('Paciente Registrado')
                             loadpage("admission/patient/index.php");
                            } else {
                                toastr.error('Error de registro ó ya existe')
                            }

                    }
                });
            }
        });
    });

 $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
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



