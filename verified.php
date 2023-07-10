<?php
@session_start();
require_once 'config/conexion.php';
$idb = $conn;
$error = "";
if (isset($_POST['usuario'])) {
    $u = $_POST["usuario"];
    $c = $_POST["clave"];
    $error = "";
    $sql = "select veces from tbl_usuarios WHERE usuario='$u'";
    $r = $idb->prepare($sql);
    $r->execute();
    $resultado = $r->fetchAll();
    if (!empty($resultado)) {
        foreach ($resultado as $f) {
            if ($f["veces"] > 4) {
                ?>
                <center><span class='label-danger'><i class='ace-icon fa fa-exclamation-triangle bigger-120'></i>Ha superado el numero de intentos</span></center>
                <?php
            }
     $sql = "select u.id_usuario, u.usuario, u.clave, p.nombre, p.apellido_pat, p.apellido_mat, p.num_doc,p.id_persona, p.fecha_nac, p.num_celular, tu.id_tipousuario, tu.descripcion, tu.slug, u.email, u.ocupacion
                        from tbl_usuarios u, tbl_tipousuario tu, tbl_persona p 
                        WHERE u.id_tipousuario= tu.id_tipousuario  and u.id_persona=p.id_persona 
                        and u.usuario = '$u' and u.estado='1'";
    $r = $idb->prepare($sql);
    $r->execute();
    $rowcount = $r->rowCount();
     if ($rowcount >= 1) {
    $resul =$r->fetch(PDO::FETCH_ASSOC);
    if(isset($resul['clave'])){
     if(password_verify($c, $resul['clave'])){
        $_SESSION['id_persona'] = $resul["id_persona"];
        $_SESSION['usuario'] = $resul["usuario"];
        $_SESSION['nombre'] = $resul["nombre"];
        $_SESSION['apellido_pat'] = $resul["apellido_pat"];
        $_SESSION['apellido_mat'] = $resul["apellido_mat"];
        $_SESSION['num_doc'] = $resul["num_doc"];
        $_SESSION['email'] = $resul["email"];
        $_SESSION['fecha_nac'] = $resul["fecha_nac"];
        $_SESSION['num_celular'] = $resul["num_celular"];
        $_SESSION['tipousuario_slug'] = $resul["slug"];
        $_SESSION['id_usuario'] = $resul["id_usuario"];
        $_SESSION['id_tipousuario'] = $resul["id_tipousuario"];
         $_SESSION['tipousuario'] = $resul["descripcion"];
        $_SESSION['ocupacion'] = $resul["ocupacion"];

        $sql = "UPDATE tbl_usuarios SET veces=0, ip_acceso='" . $_SERVER['REMOTE_ADDR'] . "' where usuario='$u'";
                        $query = $idb->prepare($sql);
                        $query->execute();
                        header("Location: dashboard.php");
    
    }else{

     ?>
    <?php include("index.php");?>
    <br>
  <div class='alert alert-danger alert-dismissible'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            <h4><i class='icon fa fa-warning'></i> Alert!</h4>
                            Usuario o Clave incorrectos!!</div>
  <?php
       $sql = "UPDATE tbl_usuarios SET veces=veces+1 where usuario='$u'";
       $query = $idb->prepare($sql);
        $query->execute();
       
   }
 }
}else{
}

 }   
 } 
}
?>
