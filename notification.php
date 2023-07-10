<?php
 require_once 'sesion.php';
 require_once './config/conexion.php';
 $idb = $conn;

 llenar_notification($idb);

 function llenar_notification($idb) {
 	         $sql = "CALL list_notification()";
             $query = $idb->prepare($sql); 
             $query->execute();
             $resultado = $query->fetchAll();

             $num_rows = $query->rowCount();
             echo '<span class="badge badge-danger navbar-badge">'.$num_rows.'</span>';
             echo '<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">';
             foreach ($resultado as $f) {
              $patient = $f['persona'];
              $fecha =   $f['date_register_order'];
              echo '<a href="#" class="dropdown-item">';
              echo '<div class="media-body">';
              echo '<h3 class="dropdown-item-title">'.$patient.'<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span></h3>';
               echo ' <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i><b>'.$fecha.'</b></p>';
              echo '</div>';
            echo '</a>';
            }
            if($_SESSION['tipousuario_slug'] == 'Lab'){
            print'<div class="dropdown-divider"></div>';
            print'<a href="#" class="dropdown-item dropdown-footer" onclick="loadpage(' . "'laboratory/result/index.php'" . ')">Ver examenes pendientes</a>';
            }else{
            print'<div class="dropdown-divider"></div>';
            print'<a href="#" class="dropdown-item dropdown-footer" onclick="loadpage(' . "'admission/order/index.php'" . ')">Ver examenes pendientes</a>';

            }
            

         echo '</div>';
        
          
         }                 
              

 

 ?>