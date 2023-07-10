
<?php
error_reporting(0);
date_default_timezone_set('America/Lima');

require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;

$id_lab_order = $_GET['cod'];


$pat = " select concat(per.nombre,' ', per.apellido_pat,' ',per.apellido_mat)nombres, per.num_doc, per.genero,per.fecha_nac,lb.num_order, lb.date_register_order
         from tbl_lab_order lb, tbl_patient pat, tbl_persona per
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
}

$detail = "select t.description as test, a.description as area
    FROM tbl_lab_order lb, tbl_detail_order det, tbl_test t, tbl_area a 
    WHERE lb.id_lab_order = det.id_lab_order AND t.id_test = det.id_test AND a.id_area = det.id_area AND lb.id_lab_order=$id_lab_order";
$querydetail = $idb->prepare($detail);
$querydetail->execute();
$resultadodetail = $querydetail->fetchAll();

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

?>

<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
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
                    <table border="0" align="center" width="650px" onclick="window.print()">
                        <tr>
                        <td colspan="1">
                           <img src="../../../img/logo.png" width="95px" height="80px"> 
                         </td>
                        <td align="center" colspan="11">
                                <b style="font-size: 16px;">LABORATORIO DE ANÁLISIS CLINICO</b><br>
                                <b>"Alegria"</b> <br>
                                <b style="font-size: 10px; font-style: italic;">Calidad y exactitud en nuestros resultados</b>

                            </td>
                        <td align="center" colspan="5" style="font-size: 20px;" >
                            <b>Orden de Laboratorio N°<?php echo  $num_orden  ?> </b>
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
                           <td colspan="17" style="font-size: 13px;"><b>Fecha de Admisión:</b><span><?php echo  $fecha_admision  ?></span> 
                           </td> 
                       </tr>
                       
                        <?php
                        print'<tr>';
                        print '<td colspan ="17"><br><b>DATOS DEL PACIENTE<b></td>';
                        print'</tr>';
                        print'<tr>';
                        print '<td><b>Paciente</b></td>';
                        print '<td>:</td>';
                        print '<td colspan ="17">' . $nombres . '</td>';
                        print '</tr>';
                        print '<tr>';
                        print '<td><b>Sexo</b></td>';
                        if($genero=="M"){
                           $sexo = "Masculino"; 
                        }else{
                           $sexo = "Femenino";
                        }
                        print '<td>:</td>';
                        print '<td colspan="4">' . $sexo . '</td>';
                        print '<td  align="left"><b>Edad</b></td>';
                        print '<td>:</td>';
                        print '<td colspan="5">' . $all_years . '</td>';
                        print '<td><b>Dni</b></td>';
                        print '<td>:</td>';
                        print '<td colspan="4"> ' . $nro_doc . '</td>';
                        print '</tr>';
                        ?>
                    </table>
                    <table border="0" align="center" width="650px" onclick="window.print()">
                        <tr>
                            <td>
                                <br><b>PRUEBAS A REALIZAR<b></td>
                                <td align="right"><br><b>AREA<b></td>
                        </tr>
                        <?php
                       
                        foreach ($resultadodetail as $j) {
                            print '<tr>';
                            print '<td>-&nbsp' . $j['test'] . '</td>';
                            print '<td align="right">' . $j['area'] . '</td>';
                            print '</tr>';
                        }
                        ?>
                        
                    </table>
                </div>
        </body>
    </center>
</html>