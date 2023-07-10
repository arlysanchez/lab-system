<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
?>

<div class="container-fluid">
<div class="card card-default"> 
<div class="card-header">
            <h3 class="card-title">Registrar Persona</h3>
    </div>
    <form method="post" id="formid" action="save.php ">
                 <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Nombre <i>*</i></label>
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
                            <input type="submit" value="Registrar usuario" id="boton" name="boton" class="btn btn-sm btn-success">                 
                            <a class="btn btn-sm btn-danger" onclick="loadpage('./security/users/new.php')" >Cancelar</a>

                        </center>
                    </div>
                </div>
             </div>
            </div>
        </form>
    </div>

</div>

<!--<script src="jquery-ui.js"></script>-->
<script>
    $(document).ready(function() {
        $("#formid").validate({
            rules: {
                nombre: {required: true, minlength: 3},
                apellido_pat: {required: true, minlength: 3},
                apellido_mat: {required: true, minlength: 3},
                nro_doc: {required: true, minlength: 8, number: true},
                num_celular: {required: true,minlength: 3,number: true},
                genero: {required: true},
                id_tipo_doc: {required: true},
                fecha_nacimiento:{required: true},
               
            },
            messages: {
            }, submitHandler: function(form) {
                $.ajax({
                    url: "./modules/security/users/" + $("#formid").attr("action"),
                    data: $("#formid").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                    success: function(result) {
                        console.log(result);

                         if (result) {
                                toastr.success('Registro Satisfactorio')
                                loadpage("security/users/new.php");
                            } else if (result == "E") {
                                toastr.error('Ya esta registrado esa persona')
                            } else {
                                toastr.error('Error de registro')
                            }
                    }
                });
            }
        });
    });


</script>



