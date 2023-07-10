
<?php

date_default_timezone_set('America/Lima');
require_once("../../../lib/pdf/dompdf/autoload.inc.php");
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
 if ($dia_diferencia < 0 || $mes_diferencia < 0){
     $all_years = $ano_diferencia. ' años ';
    }
  elseif ($ano_diferencia < 0 || $mes_diferencia > 0 || $dia_diferencia >30 ){
     $all_years = $mes_diferencia. ' meses ';
  }
  elseif ($mes_diferencia < 0 || $ano_diferencia < 0 || $dia_diferencia < 31){
     $all_years = $dia_diferencia. ' dias ';
  }
//$all_years = $ano_diferencia . ' años ' . $mes_diferencia . ' meses '. $dia_diferencia . ' dias ';
$baseurl = "http://localhost/system-lab";



$codigoHTML = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <center>
    <style>
      body, td, th {
                font-family: Arial, Helvetica, sans-serif;
                font-size:15px;

            }
    </style>
        <body id="cuerpoPagina">
            <div class="zona_impresion">          
                <div class="zona_impresion">             
                    <table border="0" align="center" width="650px">
                       <tr>
                        <td colspan="1">
                           <img src="' . $baseurl . '/img/logo.png" width="95px" height="80px"> 
                         </td>
                        <td align="center" colspan="11">
                                <b style="font-size: 16px;">LABORATORIO DE ANÁLISIS CLINICO</b><br>
                                <b>"Alegria"</b> <br>
                                <b style="font-size: 10px; font-style: italic;">Calidad y exactitud en nuestros resultados</b>

                            </td>
                        <td align="right" colspan="5" style="font-size: 20px;" >
                            <b>Resultado</b> 
                        </td>
                       </tr>
                       <tr>
                         <td colspan="17" align="right" style="font-size: 12px;">
                            Jr. Alfonso Uriarte N° 283- Juanjui/ Cel. 949788611 - 916885038 - 929297052 
                         </td>

                       </tr>
                       <tr>
                           <td colspan="17">______________________________________________________________________________</td> 
                       </tr>
                       <tr>
                           <td colspan="17" style="font-size: 13px;"><b>Fecha de Admisión:</b><span> ' . $fecha_admision . '</span> / 
                            <b>Fecha de Resultado:</b>' . $fecha_resultado . '</td> 
                       </tr>';
                       
                        
                        '<tr>';
                         '<td colspan ="17"><br><b>DATOS DEL PACIENTE<b></td>';
                        '</tr>';
                        $codigoHTML.='
                        <tr>
                         <td><b>Paciente</b></td>
                         <td>:</td>
                          <td colspan ="8">' . $nombres . '</td>
                         <td colspan ="5" align="left"><b>N° Orden</b></td>
                         <td>:</td>
                         <td> ' . $num_orden  . '</td>
                         </tr>
                         <tr>
                         <td><b>Sexo</b></td>';
                        if($genero=="M"){
                           $sexo = "Masculino"; 
                        }else{
                           $sexo = "Femenino";
                        }
                        $codigoHTML.='
                          <td>:</td>
                         <td colspan="8">' . $sexo . '</td>
                         <td colspan="5" align="left"><b>Edad</b></td>
                          <td>:</td>
                          <td>' . $all_years . '</td>
                        </tr>
                        <tr>
                         <td><b>Dni</b></td>
                         <td>:</td>
                         <td colspan="8"> ' . $nro_doc . '</td>
                         <td colspan="5" align="left"><b>Prioridad</b></td>
                          <td>:</td>
                          <td>RUTINA</td>
                        </tr>
                    </table>';
                    $codigoHTML.='
                    <table border="0" align="center" width="650px">';
                        foreach ($AreaNames as $k => $AreaName) {
                          $area =  $AreaName;
                          $id_area = $AreaIds[$k];
                         $codigoHTML.='
                          <tr style="background-color: #DBF3FF;">
                             <td  align="center" colspan="22"><b> '. $area .'</b></td> 
                         </tr>';
                         $codigoHTML.='<tr>
                             <td colspan="1" style="font-size: 14px;"><b>DETALLE</b></td>
                             <td  colspan="14" align="center" style="font-size: 14px;"><b> RESULTADO</b></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td align="left" colspan="2" style="font-size: 14px;"><b>VALOR REFERENCIAL</b></td>
                             </tr>';
                            

                        $detail2 = "select b.id_test, b.description as test from tbl_detail_order a, tbl_test b, tbl_features c, tbl_register_result d, tbl_area e, tbl_area_test f where b.id_test = a.id_test and b.id_test = c.id_test and c.id_features = d.id_features and b.id_test = f.id_test and e.id_area = f.id_area and d.id_lab_order = a.id_lab_order and e.id_area = $id_area and d.id_lab_order =$id_lab_order";
                        $detail2 = $idb->prepare($detail2);
                        $detail2->execute();
                        $resultado1 = $detail2->fetchAll(PDO::FETCH_ASSOC);
                        $TestNames = array_unique(array_column($resultado1, 'test'));
                        $TestIds = array_unique(array_column($resultado1, 'id_test'));
                       
                        foreach ($TestNames as $j => $TestName) {
                          $test =  $TestName;
                          $id_test = $TestIds[$j];
                          $codigoHTML.='
                             <tr>
                             <td style="font-style: italic;"><b>Prueba: ' . $test . ' </b></td>
                             </tr>';

                       $detail3 = "select e.description as area, e.id_area, b.id_test, b.description as test, c.id_features, c.description as feature, d.result as results, c.reference_value from tbl_detail_order a, tbl_test b, tbl_features c, tbl_register_result d, tbl_area e, tbl_area_test f where b.id_test = a.id_test and b.id_test = c.id_test and c.id_features = d.id_features and b.id_test = f.id_test and e.id_area = f.id_area and d.id_lab_order = a.id_lab_order and  e.id_area = $id_area and b.id_test = $id_test and d.id_lab_order =$id_lab_order ";
                       $detail3 = $idb->prepare($detail3);
                        $detail3->execute();
                        $resultado2 = $detail3->fetchAll();
                         foreach ($resultado2 as $i) {
                             $codigoHTML.='<tr>
                             <td colspan="1"><b>-</b> ' . $i['feature'] . '</td>
                             <td  colspan="14" align="center"><b>' . $i['results'] . '</b></td>
                              <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td align="left" colspan="2" style"text-aling: left">' . $i['reference_value'] . '</td>
                             </tr>
                             ';
                        }
                        } 
                         

                      }
                        
                      $codigoHTML.=' 
                      <br>
                       <tr>
                      <td  colspan="9" align="center" style="font-size: 10px;"><br><br><br><br><br><br>
                       Procesado por:
                      </td>
                      <td colspan="3">
                      </td>
                      <td  colspan="9" align="center" style="font-size: 10px;"><br><br><br><br><br><br>
                      Regentado por:
                      </td>
                      <td colspan="1">
                      </td>
                      </tr>
                      <tr>
                      <td  colspan="9" align="center">
                      <img src="' . $baseurl . '/img/firma_sello.png" width="200px" height="150px">
                      </td>
                      <td colspan="3">
                      </td>
                      <td  colspan="9" align="center">
                      <img src="' . $baseurl . '/img/firma_ciro.png" width="190px" height="150px">
                      </td>
                      <td colspan="1">
                      </td>
                      </tr>
                    </table>
                </div>
        </body>
    </center>
</html>';

$codigoHTML = utf8_encode($codigoHTML);
// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->load_html(utf8_decode($codigoHTML));

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);
set_time_limit(500);
ini_set("memory_limit", "300M");
$dompdf->render();
$dompdf->stream("resultado_$nombres.pdf", array("Attachment" => false));
?>