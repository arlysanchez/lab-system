<?php require './headerboard.php';
$tipousuario = $_SESSION['tipousuario'];
$tipousuario_slug = $_SESSION['tipousuario_slug'];
?>

<!-- div donde se muetras las paginas -->

<div  id="loadpage">

<?php
if (($_SESSION['tipousuario_slug'] =="S_Admin") OR $_SESSION['tipousuario_slug'] == 'Adm') {
  require 'reports.php';
}else{
 ?> 


<center><h4><b>BIENVENIDO AL SISTEMA DE LABORATORIO<b></h4>	</center>

<div class="slider">
      <ul>
          <li>
           <img src="public/img/1.jpg" alt="">
          </li>
         <li>
          <img src="public/img/2.jpg" alt="">
         </li>
         <li>
          <img src="public/img/3.jpg" alt="">
         </li>
      </ul>
    </div>
  

<?php } ?>
  
</div>
<!-- jQuery -->


<?php require './footer.php';?>

<style type="text/css">
      
    .slider {
  width: 60%;
  margin: auto;
  overflow: hidden;
}

.slider ul {
  display: flex;
  padding: 0;
  width: 300%;

  
  animation: cambio 10s infinite alternate linear;
}

.slider li {
  width: 100%;
  list-style: none;
}

.slider img {
  width: 100%;
}

@keyframes cambio {
  0% {margin-left: 0;}
  20% {margin-left: 0;}
  
  25% {margin-left: -100%;}
  45% {margin-left: -100%;}
  
  50% {margin-left: -200%;}
  70% {margin-left: -200%;}
  
  75% {margin-left: -300%;}
  100% {margin-left: -300%;}
}


    </style>
