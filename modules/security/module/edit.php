<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
//require_once '../../../cabecera.php';
$idb = $conn;
if (isset($_GET['cod'])) {
    $codmodulo = $_GET['cod'];
    $sql = "SELECT * FROM tbl_modulos WHERE codmodulo = $codmodulo";
    $query = $idb->prepare($sql);
    $query->execute();
    $resultado = $query->fetchAll();
    foreach ($resultado as $f) {
        $descripcion = $f['descripcion'];
        $url = $f['url'];
        $idpadre = $f['idpadre'];
        $icono = $f['icono'];
        $order_list = $f['order_list'];
        $estado = $f['estado'];
    }
}
?>

<div class="container-fluid">
    <div class="card card-default"> 
    <div class="card-header">
            <h3 class="card-title">Actualizar modulos</h3>
    </div>
        <form method="post" id="formmodulos"  action="save.php">
        <div class="card-body">
            <div class='row'>
            <div class="col-sm-6">
                    <input type="hidden" id="codmodulo" name="codmodulo"  value="<?php echo $codmodulo ?>" >
                    <div class="form-group">
                        <label>Modulo: </label><br>
                        <input type="text" name="descripcion" class="form-control" placeholder="ingrese el nombre del modulo" value="<?php echo $descripcion ?>" />
                    </div>
                    <div class="form-group input-group-sm">
                        <label>Url: </label><br>
                        <input type="text" name="url" class="form-control" placeholder="ingrese la url del modulo" value="<?php echo $url ?>"/>
                    </div>
                    <div class="form-group input-group-sm">
                        <label>Modulo general: </label><br>
                        <select name="idpadre" id = "idpadre" class="form-control"> 
                            <option value="0">MODULO PADRE </option>
                            <?php
                            $query = "select * from tbl_modulos where idpadre=0";
                            $data = $idb->prepare($query);
                            $data->execute();
                            while ($row = $data->fetch(PDO::FETCH_ASSOC)) {

                                if ($idpadre == $row['codmodulo']) {
                                    echo "<option value='" . $row['codmodulo'] . "' selected='selected'>" . $row['descripcion'] . "</option>";
                                } else {
                                    echo "<option value='" . $row['codmodulo'] . "'>" . $row['descripcion'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    </div>
                    <div class="col-sm-6">
                    <div class="form-group input-group-sm" >
                        <label>icono: </label><br>
                        <input type="text" name="icono" class="form-control"placeholder="Nombre de icono" value="<?php echo $icono ?>" />
                    </div>
                    <div class="form-group input-group-sm" >
                        <label>Orden: </label><br>
                        <input type="text" name="order_list" class="form-control"placeholder="Nombre de icono" value="<?php echo $order_list ?>" />
                    </div>
                    <div class="form-group input-group-sm">
                        <label >
                            <?php
                            if ($estado == "1") {
                                echo '<input class="ace" id="estado" name="estado" checked="checked"  type="checkbox" value="1" />';
                            } else {
                                echo'<input class="ace" id="estado" name="estado"   type="checkbox" value="1" />';
                            }
                            ?>                                      
                            <span class="lbl"> Estado</span>
                        </label>
                    </div>
                    <div class="form-actions center">
                        <center>
                              <input type="submit" value="Actualizar" id="boton" name="boton" class="btn btn-sm btn-success boton">
                            <a class="btn btn-sm btn-danger" onclick="loadpage('./security/module/index.php')" >Cancelar</a>  
                            
                        </center>
                    </div>
                 </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#formmodulos").validate({
            rules: {
            },
            messages: {
                // descripcion: "Debe seleccionar una opcion.'",

            }, submitHandler: function(form) {
                $.ajax({
                    url: "./modules/security/module/" + $("#formmodulos").attr("action"),
                    data: $("#formmodulos").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                    success: function(result) {
                        if (result) {
                              toastr.info('Registro actualizado')
                         }else{
                            toastr.error('Error de actualizacion')
                         }
                        loadpage("security/module/index.php");
                    }
                });
            }
        });
    });
</script>
