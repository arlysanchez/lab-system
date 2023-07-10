<?php
 require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
error_reporting(0);
//echo '<pre>';
//print_r($_POST);
   
   date_default_timezone_set("America/Lima");

   $date_register_result =date("Y-m-d H:i:s");
   $id_user_register = $_SESSION['id_tipousuario'];
   $id_lab_order = $_POST['id_lab_order'];
   $id_features = $_POST['id_features'];
   $results = $_POST['results'];
   $boton = $_POST['boton'];
   /*imprimir*/
   $boton =  $_REQUEST['boton'];
   $id_lab_order1 = $_REQUEST['id_lab_order'];

   switch ($boton) {
   	case 'REGISTRAR':
   		
       for ($j=0; $j < count($id_features); $j++) { 
        $sql1 = "INSERT INTO tbl_register_result (id_lab_order,id_features,result,id_user_register) values( ?, ?, ?, ?)";
          $query1 = $idb->prepare($sql1);
          $result = $query1->execute(array($id_lab_order, $id_features[$j],$results[$j],$id_user_register));
       }

         $sql2 = "UPDATE tbl_lab_order  set date_register_result = ?, status_order = ? WHERE id_lab_order = ?";
        $query2 = $idb->prepare($sql2);
        $result= $query2->execute(array($date_register_result,"R", $id_lab_order));
 
         if($result){
                echo "OK";
                }else{
                 echo "error";
          }


   		break;

      case 'ACTUALIZAR':
      
       for ($i=0; $i < count($results); $i++) { 
          $sql3 = "UPDATE tbl_register_result  set  result = ?, id_user_register = ? WHERE id_lab_order = ? and id_features = ?";
          $query3 = $idb->prepare($sql3);
          $result= $query3->execute(array($results[$i], $id_user_register, $id_lab_order,$id_features[$i] ));
         }
         if($result){
                echo "OK";
                }else{
                 echo "error";
          }
      break;

      case 'PrintResult':
        if (isset($_REQUEST['id_lab_order'])) {
          $sql2 = "UPDATE tbl_lab_order  set status_order = ? WHERE id_lab_order = ?";
          $query2 = $idb->prepare($sql2);
          $result= $query2->execute(array("T", $id_lab_order1));
            
        }
        break;
   	
   }
?>