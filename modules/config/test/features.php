           
<?php
    require_once '../../../sesion.php';
    require '../../../config/conexion.php';
    $idb = $conn;
    if (!empty($_GET['cod'])) {
    $id = $_REQUEST['cod'];
    }
   $sql = "SELECT tf.id_features, tf.description, tf.reference_value, tt.id_test FROM tbl_test tt, tbl_features tf WHERE tt.id_test = tf.id_test AND tf.status = 1 AND tt.id_test = $id";
     $numero = 1;
    $query = $idb->prepare($sql);
    $query->execute();
    $resultado = $query->fetchAll();
    ?>
<div class="card">
<div class="row">
   <div class="col-11"><div class="card-header"><h3 class="card-title d-flex justify-content-center ">Caracteristicas</h3></div></div>

                 <div class="col-1 d-flex justify-content-center" >
                 <div class='col-sm-12'>
                 <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;"onclick='loadpage("config/test/index.php")' >
                  Cancelar
                  </button>
                  </div>
               </div>
   </div>
 <div class="card-body">
        <div class='col-sm-12'>
            <table class="table table-bordered table-striped">
          <thead>
                                <tr class='tre'>                                
                                    <th>NRO</th> 
                                    <th>CARACTERISTICA</th>
                                    <th>VALOR REFERENTE</th>
                                </tr>
                            </thead>
                            <tbody>   
                                <?php
                                foreach ($resultado as $v) {
                                    print "<tr>";
                                    print "<td>" . $numero . "</td>";
                                    print "<td>" . $v["description"] . "</td>";
                                    $no_reference_value = '<span class="right badge badge-info"><i class="ace-icon fa fa-exclamation-triangle bigger-120"></i>no tiene valor de referencia</span>';
                                    if ($v['reference_value'] == "") {
                                     $reference_value = $no_reference_value;
                                     print "<td>" . $reference_value . "</td>";
                                   }else{
                                    print "<td>" . $v["reference_value"] . "</td>";

                                   }
                                    print "</tr>";
                                    $numero++;
                                } 
                                ?> 
                                <!--Ventana Modal para Actualizar--->
                             
                            </tbody>
            </table>
        </div>
    </div>
</div>

