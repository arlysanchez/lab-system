<!DOCTYPE html>
<html lang="es">

 <head>
   <meta charset="UTF-8">
   <title>RENIEC</title>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 <style type="text/css">
    #reniec, #manual{
      display:none;
    }
   </style>
  </head>

 <body>
 <center>
 <input type="radio" name="consulta" value = "1" onclick="showReniec()"> CONSULTA RENIEC
 <input type="radio" name="consulta" value = "2" onclick="showManual()"> MANUAL
 <div id="reniec">
         <h3>CONSULTA RENIEC</h3>
    <input type="text" id="documento">
    <button id="buscar">BUSCAR</button><br>
    <label>NOMBRES:</label>
        <input type="text" id="nombres" disabled><br>
        <label>APELLIDO PATERNO:</label>
        <input type="text" id="apellidoPaterno" disabled><br>
        <label>APELLIDO MATERNO:</label>
        <input type="text" id="apellidoMaterno" disabled><br>
        <label>EDAD:</label>
        <input type="text" id="edad" placeholder='edad'><br>
        <label>SEXO:</label>
        <input type="radio" name="sexo" value = "M"> MASCULINO
        <input type="radio" name="sexo" value = "F"> FEMENINO
</div>

 <div id="manual">
        <h3>MANUAL</h3>
        <label>NOMBRES:</label>
        <input type="text" id="nombres" placeholder='nombres'><br>
        <label>APELLIDO PATERNO:</label>
        <input type="text" id="apellidoPaterno" placeholder='apellido Paterno'><br>
        <label>APELLIDO MATERNO:</label>
        <input type="text" id="apellidoMaterno" placeholder='apellido Materno'><br>
        <label>DNI:</label>
        <input type="text" id="documento" placeholder='DNI'><br>
        <label>EDAD:</label>
        <input type="text" id="edad" placeholder='edad'><br>
        <label>SEXO:</label>
        <input type="radio" name="sexo" value = "M"> MASCULINO
        <input type="radio" name="sexo" value = "F"> FEMENINO  
</div>
   </center>
 </body>
 <script type="text/javascript">

function showReniec(){
         document.getElementById('reniec').style.display= 'block';
         document.getElementById('manual').style.display= 'none';

     }
    
function showManual(){
         document.getElementById('reniec').style.display='none';
         document.getElementById('manual').style.display='block';

     }
     $('#buscar').click(function() {
         //probar datos en consola
         //data=$('#documento').val();
         //console.log(data);
         dni=$('#documento').val();
         $.ajax({
           url:'controller/consultaDNI.php',
           type: 'post',
           data: 'dni='+dni,
           dataType:'json',
           success:function(r){
           if(r.numeroDocumento==dni){
            $('#apellidoPaterno').val(r.apellidoPaterno);
            $('#apellidoMaterno').val(r.apellidoMaterno); 
            $('#nombres').val(r.nombres);
           }else{
              alert(r.error);
           }
           console.log(r);
           }
         });
     });
     </script>
</html>