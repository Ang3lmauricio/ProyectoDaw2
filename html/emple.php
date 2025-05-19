<?php

$conexion=mysqli_connect("localhost","root","","licoreria");
if(!$conexion){
    echo "Error al conectar a la base de datos";
}

else{
    echo "Conectado a la base de datos";
}


$contraseña=$_POST["password"];
$correo=$_POST["correo"];


$verificar_correo=mysqli_query($conexion,"SELECT * FROM empleados WHERE correo='$correo' and
  contra='$contraseña'");
if (mysqli_num_rows($verificar_correo)>0) {
    header("Location: ../../public/js/index.html");
    exit;
}else{
    echo '<script>
    alert("El usuario no existe, ¡Por favor introduzca los datos correctos!");
    window.location= "empleado.html";
    </script>';
    exit;
}

?>