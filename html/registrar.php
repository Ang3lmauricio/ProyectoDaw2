<?php
$conexion=mysqli_connect("localhost","root","","licoreria");
if(!$conexion){
    echo "Error al conectar a la base de datos";
}

else{
    echo "Conectado a la base de datos";
}

$usuario=$_POST["login"];
$contraseña=$_POST["password"];
$correo=$_POST["correo"];

$validar = mysqli_query($conexion, "SELECT * FROM clientes WHERE usuario='$usuario' and correo='$correo' and contraseña='$contraseña'");

if(mysqli_num_rows($validar)>0){
    header("location: inicio.html");
    exit;
}else{
    echo '<script>
    alert("El usuario no existe, ¡Por favor introduzca los datos correctos!");
    window.location= "login.html";
    </script>';
    exit;
}
?>