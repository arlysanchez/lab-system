<?php
$idb = $conn;
?>

<div class="modal fullscreen-modal fade" id="ViewTest<?php echo $v['id_lab_order']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header color ">
                   <center><b>Test a Realizar</b></center> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                <div class="modal-body">
                            <input type="hidden" name="id" value="<?php echo $v['id_lab_order']; ?>">
                        <div class="container"> 
                            <iframe  class="responsive-iframe" id="frame" src="./modules/laboratory/result/view_test_detail.php?cod=<?php echo $v['id_lab_order']; ?>"   frameBorder="0" width = "100%" heigth="300px">

                         </iframe>
                     </div>

                </div>                            
            </div>
        </div>
    </div>