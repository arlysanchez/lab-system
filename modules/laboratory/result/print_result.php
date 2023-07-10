
<?php
error_reporting(0);
date_default_timezone_set('America/Lima');

require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;

$id_lab_order = $_GET['cod'];


$pat = " select concat(per.nombre,' ', per.apellido_pat,' ',per.apellido_mat)nombres, per.num_doc, per.genero,per.fecha_nac,lb.num_order, lb.date_register_order, lb.date_register_result from tbl_lab_order lb, tbl_patient pat, tbl_persona per
        WHERE per.id_persona = pat.id_person AND pat.id_patient = lb.id_patient AND lb.id_lab_order=$id_lab_order ";
$querypat = $idb->prepare($pat);
$querypat->execute();
$resultadopat = $querypat->fetchAll();
foreach ($resultadopat as $value) {
    $nombres = $value['nombres'];
    $nro_doc = $value['num_doc'];
    $genero = $value['genero'];
    $fecha_nac = $value['fecha_nac'];
    $num_orden = $value['num_order'];
    $fecha_admision = $value['date_register_order'];
    $fecha_resultado = $value['date_register_result'];
}

$detail = "select e.description as area, e.id_area, g.description as sample from tbl_detail_order a, tbl_test b, tbl_features c, tbl_register_result d, tbl_area e, tbl_area_test f, tbl_type_sample g WHERE b.id_test = a.id_test and b.id_test = c.id_test and c.id_features = d.id_features and b.id_test = f.id_test and e.id_area = f.id_area and g.id_type_sample = e.id_type_sample and d.id_lab_order = a.id_lab_order and d.id_lab_order = $id_lab_order";

  $querydetail = $idb->prepare($detail);
  $querydetail->execute();
  $resultado = $querydetail->fetchAll(PDO::FETCH_ASSOC);
  $AreaNames = array_unique(array_column($resultado, 'area'));
  $AreaIds = array_unique(array_column($resultado, 'id_area'));
  $Samples = array_unique(array_column($resultado, 'sample'));

  

  list($ano,$mes,$dia) = explode("-",$fecha_nac);
  $ano_diferencia  = date("Y") - $ano;
  $mes_diferencia = date("m") - $mes;
  $dia_diferencia   = date("d") - $dia;
  if ($dia_diferencia < 0 || $mes_diferencia < 0)
   $ano_diferencia;
  

?>

<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link href="../../../css/ticket.css" rel="stylesheet" type="text/css"/>
    </head>
    <center>
        <body id="cuerpoPagina">
            <div class="zona_impresion">          
                <div class="zona_impresion">             
                    <table border="0" align="center" width="650px" onclick="window.print()">
                       <tr>
                        <td>
                           <img src="../../../img/icon.png" width="70px" height="70px"> 
                         </td>
                        <td align="center" colspan="12">
                                <b>LABORATORIO DE ANÁLISIS CLINICO</b><br>
                                <b>"Alegria"</b> <br>
                                <b style="font-size: 10px; font-style: italic;">Calidad y exactitud en nuestros resultados</b>

                            </td>
                        <td align="center" colspan="4" style="font-size: 20px;" >
                            <b>Resultado de Laboratorio</b> 
                        </td>
                       </tr>
                       <tr>
                         <td colspan="17" align="right" style="font-size: 12px;">
                            Jr. Alfonso Uriarte N° 283- Juanjui-Telf. 042-594445 / Cel. 949788611 - 95551279 - 92927052 
                         </td>

                       </tr>
                       <tr>
                           <td colspan="17">______________________________________________________________________________</td> 
                       </tr>
                       <tr>
                           <td colspan="17"><b>Fecha de Admisión:</b><?php echo  $fecha_admision  ?> / 
                            <b>Fecha de Resultado:</b><?php echo  $fecha_resultado  ?><br> <b>N° Orden:</b><?php echo  $num_orden  ?> </td> 
                       </tr>
                       
                        <?php
                        print'<tr>';
                        print '<td colspan ="17"><br><b>DATOS DEL PACIENTE<b></td>';
                        print'</tr>';
                        print'<tr>';
                        print '<td><b>Paciente:</b></td>';
                        print '<td colspan ="8">' . $nombres . '</td>';
                        print '<td><b>Sexo:</b></td>';
                        if($genero=="M"){
                           $sexo = "Masculino"; 
                        }else{
                           $sexo = "Femenino";
                        }
                        print '<td>' . $sexo . '</td>';
                        print '<td></td>';
                        print '<td><b>Dni:</b></td>';
                        print '<td>' . $nro_doc . '</td>';
                        print '<td></td>';
                        print '<td align="right"><b>Edad:</b></td>';
                        print '<td align="right">' . $ano_diferencia . '</td>';
                        print'</tr>';
                        ?>
                    </table>
                    <table border="0" align="center" width="650px" onclick="window.print()">
                      
                      <?php  
                        foreach ($AreaNames as $k => $AreaName) {
                          $area =  $AreaName;
                          $id_area = $AreaIds[$k];
                          $sample = $Samples[$k];
                       
                         print '<tr>';
                         print '<td align="right" colspan="2">';
                         print '  </td>';
                         print ' <td align="center" colspan="13">';
                         print '  <br><b style ="font-size: 16px;"> '. $area .'<b></td>';
                         print '<td align="right" colspan="2">';
                         print '  <br>MUESTRA: <b style ="font-size: 16px;"> '. $sample .'<b></td>';
                        print '</tr>';
                            

                        $detail2 = "select b.id_test, b.description as test from tbl_detail_order a, tbl_test b, tbl_features c, tbl_register_result d, tbl_area e, tbl_area_test f where b.id_test = a.id_test and b.id_test = c.id_test and c.id_features = d.id_features and b.id_test = f.id_test and e.id_area = f.id_area and d.id_lab_order = a.id_lab_order and e.id_area = $id_area and d.id_lab_order =$id_lab_order";
                        $detail2 = $idb->prepare($detail2);
                        $detail2->execute();
                        $resultado1 = $detail2->fetchAll(PDO::FETCH_ASSOC);
                        $TestNames = array_unique(array_column($resultado1, 'test'));
                        $TestIds = array_unique(array_column($resultado1, 'id_test'));
                       
                        foreach ($TestNames as $j => $TestName) {
                          $test =  $TestName;
                          $id_test = $TestIds[$j];
                            print '<tr>';
                            print '<td>*<b>Prueba:</b>' . $test . '</td>';
                            print '</tr>';

                       $detail3 = "select e.description as area, e.id_area, b.id_test, b.description as test, c.id_features, c.description as feature, d.result as results, c.reference_value from tbl_detail_order a, tbl_test b, tbl_features c, tbl_register_result d, tbl_area e, tbl_area_test f where b.id_test = a.id_test and b.id_test = c.id_test and c.id_features = d.id_features and b.id_test = f.id_test and e.id_area = f.id_area and d.id_lab_order = a.id_lab_order and  e.id_area = $id_area and b.id_test = $id_test and d.id_lab_order =$id_lab_order ";
                       $detail3 = $idb->prepare($detail3);
                        $detail3->execute();
                        $resultado2 = $detail3->fetchAll();
                          print '<tr>';
                            print '<td colspan="2"><b>DETALLE</b></td>';
                            print '<td  colspan="13" align="center"><b> RESULTADO</b></td>';
                            print '<td align="right" colspan="2"><b>VALOR REFERENCIAL</b></td>';
                            print '</tr>';
                         foreach ($resultado2 as $i) {
                            print '<tr>';
                            print '<td colspan="2">' . $i['feature'] . '</td>';
                            print '<td  colspan="13" align="center"><b>' . $i['results'] . '</b></td>';
                            print '<td align="right" colspan="2" style"text-aling: left">' . $i['reference_value'] . '</td>';
                            print '</tr>';
                        }
                        } 
                         

                      }
                        ?>
                        
                    </table>
                </div>
        </body>
    </center>
</html>