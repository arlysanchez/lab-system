<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
?>

<div class="container-fluid">
    <div class="card card-default"> 
    <div class="card-header">
            <h3 class="card-title">Registrar usuario</h3>
    </div>
        <form method="post" id="formmodulos" action="save.php">
                <div class="card-body">
                <div class="row">
              <div class="col-md-6">
                    <!--<input id="id_usuario" name="id_usuario" type="hidden" value="" placeholder="Ingrese nombre de insumo"  class="form-control1" id="inputSuccess1">-->
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess1">Persona</label>
                        <a href='#'  onclick='loadpage("security/users/new_user.php")'<span class='green'><i class='fa fa-user-plus fa-sm'></i></span></a>&nbsp;&nbsp;&nbsp;&nbsp;

                        <input id="nombre" name="nombre" type="text" placeholder="Buscar  persona por nombre"  class="auto form-control">
                    <input id="id_persona" name="id_persona" type="hidden"  placeholder="Ingrese nombre de la persona"  class="form-control1" id="inputSuccess1">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess1">Usuario</label>
                        <input id="usuario" name="usuario" type="text" placeholder="Usuario" maxlength="100"  class="form-control" />
                        <span class="help-block"></span>
                    </div>
                  </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess1">Password</label>
                        <input id="clave" name="clave" type="text" value="laboratorio"  placeholder="Paswword" maxlength="100"  class="form-control" readonly="readonly"  />
                        <span class="help-block"> **contraseña por defecto** </span>
                    </div>
                    <div class="form-group" >
                        <label class="control-label" for="inputSuccess1">Tipo usuario</label>
                        <select name="id_tipousuario"   class="form-control"  > 
                            <option>Seleccione</option>
                            <?php
                            $query = "select * from tbl_tipousuario where estado=1";
                            $data = $idb->prepare($query);
                            $data->execute();
                            while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                if ($id_tipousuario == $row['id_tipousuario']) {
                                    echo "<option value='" . $row['id_tipousuario'] . "' selected='selected'>" . $row['descripcion'] . "</option>";
                                } else {
                                    echo "<option value='" . $row['id_tipousuario'] . "'>" . $row['descripcion'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess1">Estado</label>
                        <?php
                        echo '<input class="ace id="estado" name="estado" checked="checked"  type="checkbox" value="1" />';
                        ?>  
                    </div>

                    <div class="form-actions center">
                        <center>
                             <input type="submit" value="Registrar" id="boton" name="boton"  class="btn btn-sm btn-success boton">
                            <a class="btn btn-sm btn-danger" onclick="loadpage('./security/users/index.php')" >Cancelar</a>
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
        $('#tablapersona').DataTable();
    });

    
$(document).ready(function() {
        $("#formmodulos").validate({
            rules: {
                nombre: {required: true},
                usuario: {required: true},
                id_tipousuario: {required: true},
                
            },
            messages: {
                // descripcion: "Debe seleccionar una opcion.'",

            }, submitHandler: function(form) {
                $.ajax({
                    url: "./modules/security/users/" + $("#formmodulos").attr("action"),
                    data: $("#formmodulos").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                    success: function(result) {
                        //console.log(result);
                        if (result) {
                             toastr.success('Registro Satisfactorio')
                         }else{
                            toastr.error('Error de registro')
                         }
                        loadpage("security/users/index.php");
                    }
                });
            }
        });
    });
    $(function() {
        //autocomplete
        $(".auto").autocomplete({
            source: "./modules/security/users/search.php",
            minLength: 1,
            select: function(event, ui) {
                var idregistro = ui.item.id;
                $("#id_persona").val(idregistro);
            }
        });

    });

</script>



