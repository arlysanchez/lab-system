<?php
error_reporting(0);
date_default_timezone_set('America/Lima');

require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
$numero = 1;
$id_lab_order = $_GET['cod'];

 $detail = "select t.description as test, a.description as area FROM tbl_lab_order lb, tbl_detail_order det, tbl_test t, tbl_area a WHERE lb.id_lab_order = det.id_lab_order AND t.id_test = det.id_test AND a.id_area = det.id_area AND lb.id_lab_order=$id_lab_order";
    $querydetail = $idb->prepare($detail);
     $querydetail->execute();
     $resultadodetail = $querydetail->fetchAll();

     ?>
     <style type="text/css">
  	table.separado {border-collapse: separate;}


table.colapsado {border-collapse: collapse;}

  </style>
     <table   border="0" class="separado" width="440px">
                                <thead >
                                <tr align="left">                                
                                    <th>N°</th>
                                    <th>Test</th> 
                                    <th>Area</th>
                                </tr>
                            </thead>
                            <tbody>        
                                <?php
                                foreach ($resultadodetail as $v) {
                                    print "<tr>";
                                    print "<td>" . $numero . "</td>";
                                    print "<td>" . $v["test"] . "</td>";
                                    print "<td>" . $v["area"] . "</td>";
                                    print "</tr>";
                                    $numero++;
                                }
                                ?>    
                            </tbody>


    </table>
  
