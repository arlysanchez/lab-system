<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
?>  

</style>
<div class="row">
        <div class="col-sm-3">
            <!-- Widget: user widget style 2 -->
            <div class="card card-widget widget-user-2">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="user-header bg-success">
                <h4 align="center">AREAS</h4>
              </div>
              <div class="card-footer ">
                <ul class="nav flex-column">
                <?php
                    $sql = "SELECT id_area,description FROM tbl_area where status = 1 ORDER BY description ";
                    $query = $idb->prepare($sql);
                    $query->execute();
                    $resultado = $query->fetchAll();
                    foreach ($resultado as $v) {
                        $id_area = $v['id_area'];
                        $description = $v['description'];
                   echo  '<li class="nav-item success"><a href="#" class="nav-link" onclick="mostrar(' . $v['id_area'] . ')"><i class="fa fa-user"></i>&nbsp&nbsp' . $description . ' </a> </li>';
                    }
                    ?>
                </ul>
              </div>
          </div> 
        </div>
    <div class="col-sm-9">
        <div id="dibuja_areas_test">


        </div>
    </div>
</div>




<script>
    $(document).ready(function() {

    });

    function mostrar(idarea) {
        $('#dibuja_areas_test').html('<center><div><img width="50px" height="50px" src="img/loading1.gif"/></div></center>');

        var page = $(this).attr('dibuja_areas_test');
        var dataString = 'page=' + page;
        $.ajax({
            url: "modules/config/config_all/area_test.php?cod=" + idarea,
            success: function(result) {
//                $("#dibujamenu").empty();
//                $("#dibujamenu").html(result);
                $("#dibuja_areas_test").fadeIn(1000).html(result);
            }
        });
    }


    function cargardatos(pagina, capa, parametros) {
        $.ajax({
            type: "post",
            url: pagina,
            data: parametros,
            success: function(respuesta) {
//                $("#"+capa).html(respuesta);
            }
        });
    }


    function graba_area_test(ct, ca, obj) {
        var idarea = $("#id").val();
//        alert(idperfil);
//        exit();
        //alert(ctu+"-"+cm);
        if ($("#" + obj.id).is(":checked")) {
            $('#dibuja_areas_test').html('<center><div><img width="50px" height="50px" src="img/loading1.gif"/></div></center>');
            var page = $(this).attr('dibuja_areas_test');
            var dataString = 'page=' + page;
            cargardatos("modules/config/config_all/save_area_test.php", "dibuja_areas_test", "ct=" + ct + "&ca=" + ca + "&e=1");
            $.ajax({
                url: "modules/config/config_all/area_test.php?cod=" + idarea,
                success: function(result) {
                    $("#dibuja_areas_test").fadeIn(1000).html(result);
                }
            });
        } else {
            $('#dibuja_areas_test').html('<center><div><img width="50px" height="50px" src="img/loading1.gif"/></div></center>');

            var page = $(this).attr('dibuja_areas_test');
            var dataString = 'page=' + page;
            cargardatos("modules/config/config_all/save_area_test.php", "dibuja_areas_test", "ct=" + ct + "&ca=" + ca + "&e=0");
            $.ajax({
                url: "modules/config/config_all/area_test.php?cod=" + idarea,
                success: function(result) {
                    $("#dibuja_areas_test").fadeIn(1000).html(result);
                }
            });
        }
    }



</script>    

