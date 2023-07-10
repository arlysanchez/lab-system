<?php
 require_once 'sesion.php';
 require_once './config/conexion.php';
 $idb = $conn; 
  
  $num_order =0;
  $num_result_register=0;
  $num_patient=0;
  $total=0;
 

if (!empty($_POST)) {
  date_default_timezone_set("America/Lima");
    $fechainicio = $_POST['fechainicio']; 
    $fechafin = $_POST['fechafin'];
    $inicio    = new DateTime($fechainicio);
    $DateNewInicio = $inicio->format('Y-m-d H:i:s');
    $fin    = new DateTime($fechafin);
    $DateNewFin = $fin->format('Y-m-d H:i:s');

    $sql = "call list_report('$DateNewInicio','$DateNewFin')";
    $query = $idb->prepare($sql);
    $query->execute();
    $resultado = $query->fetchAll();
    
    foreach ($resultado as $i) {
      $num_order = $i['cantidad_order'];
      $num_result_register = $i['resultados'];
      $num_patient = $i['pacientes'];
      $total = $i['total'];
      # code...
    }

}

 ?>

<form id="formmodulos" action="dashboard.php" method="POST">
<div class="row">
  <div class="col-lg-5">
    <div class="form-group">
        <label>Fecha Inicio</label>
         <div class="input-group">
           <input type="datetime-local" class="form-control" name="fechainicio" id="fechainicio" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy H:i:s" data-mask="" inputmode="numeric">
         </div>
    </div>
  </div>
  <div class="col-lg-5">
     <div class="form-group">
        <label>Fecha Fin</label>
         <div class="input-group">
           <input type="datetime-local" class="form-control" name="fechafin" id="fechafin" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy H:i:s" data-mask="" inputmode="numeric">
         </div>
    </div>
  </div>
  <div class="col-lg-2">
    <label>&nbsp;</label>
    <input type="submit" value="Buscar"  id="boton"  class="btn btn-block btn-primary" >

  </div>
</div>

</form>

<div class="row">


          <div class="col-lg-6 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
               
                <h3><?php echo $num_order; ?></h3>

                <p>Ordenes de Laboratorio</p>
              </div>
              <div class="icon">
                <i class="fas fa-flask"></i>
              </div>
              <a href="#" class="small-box-footer" onclick="loadpage('admission/order/index.php')">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $num_result_register; ?></h3>

                <p>Resultados</p>
              </div>
              <div class="icon">
                <i class="fas fa-edit"></i>
              </div>
              <a href="#" class="small-box-footer" onclick="loadpage('laboratory/result/index.php')">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6">
            <!-- small card -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $num_patient; ?></h3>

                <p>Pacientes</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-plus"></i>
              </div>
              <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <div class="col-lg-6 col-6">
            <!-- small card -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>S/<?php echo $total; ?>.00</h3>

                <p>Ingresos</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-plus"></i>
              </div>
              <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
      </div>

    <script>

   $(document).ready(function() {
        $("#formmodulos").validate({
            rules: {
                fechainicio: {required: true},
                fechafin: {required: true},
            },
            messages: {
                //                        descripcion: "Debe seleccionar una opcion.'",

            }, submitHandler: function(form) {
                $.ajax({
                    url: $("#formmodulos").attr("action"),
                    data: $("#formmodulos").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                    success: function(result) {
                        loadpage("dashboard.php");
                    }
                });
            }
        });
    });
</script>