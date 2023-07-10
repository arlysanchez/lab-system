<?php
@session_start();
if (!isset($_SESSION["usuario"])){
//    die(header("Location:/e-comanda/index.php"));
    die("<script> alert('porfavor inice secion');
        window.location='/system-lab/index2.php';</script>");
}
?>