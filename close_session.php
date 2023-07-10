<?php
session_start();
unset($_SESSION['usuario']);
unset($_SESSION['nombres']);
unset($_SESSION['id_usuario']);
unset($_SESSION['id_tipousuario']);
unset($_SESSION['tipousuario']);

session_destroy();
die("
<script>
window.location='index2.php'
    

</script>
");
require_once '../index2.php';