<?php
require_once 'sesion.php';
require_once 'config/conexion.php';
$idb = $conn;
error_reporting(0);
$id_user = $_SESSION['id_usuario']; 
$error = "";

if (!empty($_POST)) {
    $id_user = $_POST['id_user']; 
    $password = $_POST['password'];
    $password_new = $_POST['password_new'];
    $password_new1 = $_POST['password_new1'];

    if ($password_new !==$password_new1) {
       $error = "<div class='alert alert-danger alert-dismissible'>
                            <h4><i class='ace-icon fa fa-exclamation-triangle bigger-120'></i> Alert!</h4>
                            No coinciden las contraseñas
                             </div>";
    }else{

     $sql = "select id_usuario, clave, usuario from tbl_usuarios where id_usuario = '$id_user'";
    $r = $idb->prepare($sql);
    $r->execute();
    $rowcount = $r->rowCount();
    if ($rowcount >= 1) {
    $resul =$r->fetch(PDO::FETCH_ASSOC);
      if(isset($resul['clave'])){
     if(password_verify($password, $resul['clave'])){
      $password_hash_new = password_hash($password_new, PASSWORD_DEFAULT);
        $sql = "UPDATE tbl_usuarios SET clave='$password_hash_new' where id_usuario = '$id_user'";
                        $query = $idb->prepare($sql);
                        $query->execute();
                        header("Location: index2.php");
    
    }else{
     $error = "<div class='alert alert-danger alert-dismissible'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            <h4><i class='icon fa fa-warning'></i> Alert!</h4>
                            Contraseña Actual incorrecta!!!
                             </div>";
   }
 }
  }
}
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LAB-ALEGRIA</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
    <a class="h1"><b>LAB-</b>ALEGRÍA</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">cambia tu contraseña por seguridad.</p>
      <form id="formmodulos" action="change_password.php" method="POST">
        <input type="hidden" name="id_user" id="id_user" value="<?php echo $id_user?>">
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Contraseña actual">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password_new" class="form-control" placeholder="Contraseña nueva" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password_new1" class="form-control" placeholder="Confirma contraseña nueva" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" onclick="validar()">Cambiar Clave</button>
          </div>
          <!-- /.col -->
        </div>
        <br>
         <div id="error" title="error">
                                <?php echo $error; ?> 
          </div>
      </form>
      <center>
      <p class="mt-3 mb-1">
        <a href="index2.php">Iniciar sesión</a>
      </p>
</center>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>

<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/toastr/toastr.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
<script>
  function validar(){
    $(document).ready(function() {
        $("#formmodulos").validate({
            rules: {
                password: {required: true},
                password2: {required: true, minlength: 6},
                password3: {required: true, minlength: 6},
            },
            messages: {
                                   

            }, submitHandler: function(form) {
                $.ajax({
                    url: $("#formmodulos").attr("action"),
                    data: $("#formmodulos").serialize(), //cuando vas a editar
                    type: "POST", //cuando vas a editar
                    success: function(result) {
                        loadpage("index2.php");
                    }
                });
            }
        });
    });
  }

   
</script>