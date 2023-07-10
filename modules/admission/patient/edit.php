<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
if (isset($_GET['cod'])) {
    $id_patient = $_GET['cod'];
    $sql = "select tper.num_doc, tper.nombre,tper.apellido_pat,tper.apellido_mat,tper.genero, tper.id_tipo_doc,tper.num_doc, tper.fecha_nac, tper.direccion, tper.num_celular, tper.id_persona, tp.id_patient
       FROM tbl_patient tp, tbl_persona tper
       WHERE tper.id_persona = tp.id_person AND tp.id_patient = $id_patient";
    $query = $idb->prepare($sql);
    $query->execute();
    $resultado = $query->fetchAll();
    foreach ($resultado as $f) {
        $id_persona = $f['id_persona'];
        $id_patient = $f['id_patient'];
        $nombre = $f['nombre'];
        $apellido_pat = $f['apellido_pat'];
        $apellido_mat = $f['apellido_mat'];
        $genero = $f['genero'];
        $id_tipo_doc = $f['id_tipo_doc'];
        $num_doc = $f['num_doc'];
        $fecha_nac = $f['fecha_nac'];
        $num_celular = $f['num_celular'];
        $direccion = $f['direccion'];
    }
}

?>
<div class="container-fluid">
<div class="card card-default"> 
 <div class="card-header">
            <div class="row">
   <div class="col-11"><h3 class="card-title d-flex justify-content-center ">Editar Paciente</h3></div>

                 <div class="col-1 d-flex justify-content-center" >
                 <div class='col-sm-12'>
                 <button type="button" class="btn btn-danger float-right" onclick="loadpage('./admission/patient/index.php')" >
                    CANCELAR
                  </button>
                  </div>
    </div>
   </div>
    </div>
       
    <div id="manual">
    <form method="post" id="formid" action="save.php">
                 <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Nombre <i>*</i></label>
                        <input id="id_persona" name="id_persona" type="hidden" value="<?php echo $id_persona ?>" class="form-control" />
                        <input id="nombre" name="nombre" type="text" placeholder="Nombre" maxlength="100" value="<?php echo $nombre ?>" class="form-control" />
                        <span class="help-block"></span>

                        <label class="control-label" for="inputSuccess1">Apellido Paterno <i>*</i></label>
                        <input id="apellido_pat" name="apellido_pat" type="text" placeholder="Apellido Paterno" maxlength="100" value="<?php echo $apellido_pat ?>"  class="form-control"
                               />
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group input-group-sm">

                    </div>
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Apellido Materno <i>*</i></label>
                        <input id="apellido_mat" name="apellido_mat" type="text" placeholder="Apellido Paterno" maxlength="100" value="<?php echo $apellido_mat ?>" class="form-control"/>
                        <span class="help-block"></span>
                    </div>

                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Tipo Doc<i>*</i></label>
                        <select name="id_tipo_doc"   class="form-control" value="<?php echo $id_tipo_doc ?>" > 
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
                        <input id="num_doc" name="num_doc" type="text" placeholder="Numero Documento" maxlength="12" value="<?php echo $num_doc ?>" class="form-control"/>

                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                     <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Fecha Nacimiento <i>*</i></label>
                        <input id="fecha_nac" name="fecha_nac" type="date"   placeholder="dd/mm/yyyy" maxlength="100" value="<?php echo $fecha_nac ?>" class="form-control"  />
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
                        <input id="direccion" name="direccion" type="text"   placeholder="Direccion" maxlength="100" value="<?php echo $direccion ?>" class="form-control"/>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group input-group-sm">
                        <label class="control-label" for="inputSuccess1">Numero Celular<i>*</i></label>
                        <input id="num_celular" name="num_celular" type="text" placeholder="Numero Celular" maxlength="9" value="<?php echo $num_celular ?>"  class="form-control"/>
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
                            <input type="submit" value="Actualizar" id="boton" name="boton" class="btn btn-sm btn-success"> 

                        </center>
                    </div>
                </div>
             </div>
            </div>
        </form>
        </div>
</div>
</div>

<!--<script src="jquery-ui.js"></script>-->
<script>
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
                    success: function(result) {
                        console.log(result);
                        if (result) {
                             toastr.info('Paciente Actualizado')
                         }else{
                            toastr.error('Error de registro')
                         }
                        loadpage("admission/patient/index.php");
                    }
                });
            }
        });
    });

</script>



