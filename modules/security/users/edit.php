<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
if (isset($_GET['cod'])) {
    $id_usuario = $_GET['cod'];
    $sql = "SELECT * FROM tbl_usuarios WHERE id_usuario = $id_usuario";
    $query = $idb->prepare($sql);
    $query->execute();
    $resultado = $query->fetchAll();
    foreach ($resultado as $f) {
        $id_persona = $f['id_persona'];
        $usuario = $f['usuario'];
        $clave = $f['clave'];
        $id_tipousuario = $f['id_tipousuario'];
    }
}
$sql1 = " select * from tbl_persona where id_persona=$id_persona";
$query1 = $idb->prepare($sql1);
$query1->execute();
$resultado1 = $query1->fetchAll();
foreach ($resultado1 as $t) {
    $nombres = $t['nombre'] . ' ' . $t['apellido_pat'] . ' ' . $t['apellido_mat'];
}
?>

<div class="container-fluid">
    <div class="card card-default"> 
    <div class="card-header">
            <h3 class="card-title">Actualizar usuario</h3>
    </div>
        <form method="post" id="formmodulos" action="save.php">
        <div class="card-body">
                <div class="row">
              <div class="col-md-6">
                    <input id="id_usuario" name="id_usuario" type="hidden" value="<?php echo $id_usuario ?>"   class="form-control" >
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Persona</label>
                        <input id="nombres" name="nombres" type="text" value="<?php echo $nombres ?>" placeholder="Ingrese nombre"  class="auto form-control" disabled >
                        <input id="id_persona" name="id_persona" type="hidden" value="<?php echo $id_persona ?>" placeholder="actualice al usuario "  class="form-control1" id="inputSuccess1">
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Usuario</label>
                        <input id="usuario" name="usuario" type="text" value="<?php echo $usuario ?>"  placeholder="ingrese un usuario" maxlength="100"   class="form-control"  />
                        <span class="help-block"></span>
                    </div>
                 </div>
                 <div class="col-md-6">
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Tipo usuario</label>
                        <select name="id_tipousuario" value="<?php echo $id_tipousuario ?>"   class="form-control"  > 
                            <option>Seleccione</option>
                            <?php
                            $query = "select * from tbl_tipousuario where id_tipousuario";
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
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Estado</label>
                        <?php
                        echo '<input class="ace id="estado" name="estado" checked="checked"  type="checkbox" value="1" />';
                        ?>  
                    </div>

                    <div class="form-actions center">
                        <center>
                            <input type="submit" value="Actualizar" id="boton" name="boton"  class="btn btn-sm btn-success boton">
                            <a class="btn btn-sm btn-danger" onclick="loadpage('./security/users/index.php')" >Cancelar</a>
                     
                        </center>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#tablapersona').DataTable();
    });

    function seleccionar(id, nombrecompleto) {
        $("#personanombre").val(nombrecompleto);
        $("#id_persona").val(id);
        $("#myModalpersona").modal('hide');
    }


    $(document).ready(function() {
        $("#formmodulos").validate({
            rules: {
                nombre: {required: true}
                
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
                              toastr.info('Registro actualizado')
                         }else{
                            toastr.error('Error de actualizacion')
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



