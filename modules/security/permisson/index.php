<?php
require_once '../../../sesion.php';
require '../../../config/conexion.php';
$idb = $conn;
?>  

<div class="row">
        <div class="col-sm-3">
            <!-- Widget: user widget style 2 -->
            <div class="card card-widget widget-user-2">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="user-header bg-primary">
                <h4  align="center">PERFILES</h4>
              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column">
                <?php
                    $sql = "SELECT id_tipousuario,descripcion FROM tbl_tipousuario WHERE estado='1' ORDER BY descripcion";
                    $query = $idb->prepare($sql);
                    $query->execute();
                    $resultado = $query->fetchAll();
                    foreach ($resultado as $v) {
                        $id_tipousuario = $v['id_tipousuario'];
                        $descripcion = $v['descripcion'];
                   echo  '<li class="nav-item"><a href="#" class="nav-link" onclick="mostrar(' . $v['id_tipousuario'] . ')"><i class="fa fa-user"></i>&nbsp&nbsp' . $descripcion . ' </a> </li>';
                    }
                    ?>
                </ul>
              </div>
          </div> 
        </div>
    <div class="col-sm-9">
        <div id="dibujamenu">


        </div>
    </div>
</div>




<script>
    $(document).ready(function() {

    });

    function mostrar(idperfil) {
        $('#dibujamenu').html('<center><div><img width="50px" height="50px" src="img/loading1.gif"/></div></center>');

        var page = $(this).attr('dibujamenu');
        var dataString = 'page=' + page;
        $.ajax({
            url: "modules/security/permisson/permisson.php?cod=" + idperfil,
            success: function(result) {
                $("#dibujamenu").fadeIn(1000).html(result);
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


    function graba_permiso(ctu, cm, obj) {
        var idperfil = $("#id").val();
//        alert(idperfil);
//        exit();
        //alert(ctu+"-"+cm);
        if ($("#" + obj.id).is(":checked")) {
            $('#dibujamenu').html('<center><div><img width="50px" height="50px" src="img/loading1.gif"/></div></center>');
            var page = $(this).attr('dibujamenu');
            var dataString = 'page=' + page;
            cargardatos("modules/security/permisson/savepermisson.php", "dibujamenu", "ctu=" + ctu + "&cm=" + cm + "&e=1");
            $.ajax({
                url: "modules/security/permisson/permisson.php?cod=" + idperfil,
                success: function(result) {
                    $("#dibujamenu").fadeIn(1000).html(result);
                }
            });
        } else {
            $('#dibujamenu').html('<center><div><img width="50px" height="50px" src="img/loading1.gif"/></div></center>');

            var page = $(this).attr('dibujamenu');
            var dataString = 'page=' + page;
            cargardatos("modules/security/permisson/savepermisson.php", "dibujamenu", "ctu=" + ctu + "&cm=" + cm + "&e=0");
            $.ajax({
                url: "modules/security/permisson/permisson.php?cod=" + idperfil,
                success: function(result) {
                    $("#dibujamenu").fadeIn(1000).html(result);
                }
            });
        }
    }



</script>    

