<?php
 require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
error_reporting(0);


 date_default_timezone_set("America/Lima");
$date_register_order =date("Y-m-d H:i:s");

$id_user_register = $_SESSION['id_tipousuario'];
$discount = $_POST['discount'];
$total = $_POST['total'];
$sub_total = $_POST['discount']+$_POST['total'];
$id_patient = $_POST['id_patient'];
$id_test = $_POST['test'];
$test_edit = $_POST['test_edit'];
$area = $_POST['area'];
$id_lab_order = $_POST['id_lab_order'];
$boton= $_POST['boton'];
$num_order= $_POST['num_order'];



  switch ($boton) {
    case 'Registrar':
     
    $sql = "INSERT INTO tbl_lab_order (id_patient,sub_total,discount,total,date_register_order,id_user_register, status_order,num_order) values(?, ?, ?, ?, ?, ?, ?, ?)";
      $query = $idb->prepare($sql);
      $query->execute(array($id_patient, $sub_total, $discount, $total, $date_register_order, $id_user_register,"P",$num_order));
     
      $sql2 = "SELECT MAX(id_lab_order)id_order FROM tbl_lab_order";
       $query2 = $idb->prepare($sql2);
       $query2->execute();
       $resultado1 = $query2->fetchAll();
       
        for($j=0; $j < count($id_test); $j++){
            $split = explode("-", $id_test[$j]);
            foreach ($resultado1 as $value) {

             $id_lab_order_recuperado = $value['id_order'];
             
          $sql3 = "INSERT INTO tbl_detail_order (id_lab_order,id_test, id_area) values( ?, ?, ?)";
          $query3 = $idb->prepare($sql3);
          $result = $query3->execute(array($id_lab_order_recuperado, $split[0],$split[1])); 
               
            }
            
          }
          
          if($result){
                  echo "OK";
                }else{
                 echo "error";
          }
     break;

     case 'Agregar':
     $split = explode("-", $test_edit);
     $total_edit=$_POST['total']+$split[1];
     $sub_total_edit = $total_edit+$discount;

         $sqlAdd = "UPDATE tbl_lab_order  set total = ?, discount = ?, sub_total = ?  WHERE id_lab_order = ?";
        $queryAdd = $idb->prepare($sqlAdd);
        $result= $queryAdd->execute(array($total_edit, $discount, $sub_total_edit,$id_lab_order));
        
        $sqlNew = "INSERT INTO tbl_detail_order (id_lab_order,id_test, id_area) values( ?, ?, ?)";
        $queryNew = $idb->prepare($sqlNew);
        $result1 = $queryNew->execute(array($id_lab_order, $split[0],$area));
          
           if($result1){
                $cod=$_POST['id_lab_order'];
                echo $cod;
                }else{
                 echo "error";
          }

       break;

       case 'Eliminar':
         $id_detail_order = $_POST['id_detail_order'];
         $id_lab_order_delete = $_POST['id_lab_order'];
         $total_delete_update = $_POST['total_delete_update'];
         

         $sqldelete = "UPDATE tbl_lab_order  set total = ?, sub_total = ?  WHERE id_lab_order = ?";
         $queryDelete = $idb->prepare($sqldelete);
         $result= $queryDelete->execute(array($total_delete_update, $total_delete_update,$id_lab_order_delete));


         $sqldelete1 = "DELETE FROM tbl_detail_order WHERE id_detail_order=$id_detail_order";
         $queryDelete1 = $idb->prepare($sqldelete1);
         $result2= $queryDelete1->execute();
        
        if($result2){
                echo "OK";;
                }else{
                 echo "error";
          }
         break;
    }

?>
