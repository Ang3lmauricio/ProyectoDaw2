<?php
include 'conectar.php';
//Declaracion de variables y almacenamiento de los datos
$nombre=$_POST["nombre"];
$apellidos=$_POST["apellidos"];
$correo=$_POST["correo"];
$ide=$_POST["ide"];
$movi=$_POST["telefono"];
$per=$_POST["usuario"];
$contra=$_POST["clave"];
//Insertar los datos
$insertar="INSERT INTO clientes (nombre,apellidos,correo,Telefono,contraseña,usuario,id) VALUES ('$nombre','$apellidos','$correo','$movi','$contra','$per','$ide')";
//BUSCAR COINCIDENCIAS



$verificar_correo=mysqli_query($conexion,"SELECT * FROM clientes WHERE correo='$correo'");
if (mysqli_num_rows($verificar_correo)>0) {
    echo' <script>
    alert("EL CORREO YA ESTA REGISTRADO");
    window.history.go(-1);
    </script>';
    exit;
}

$verificar_ide=mysqli_query($conexion,"SELECT * FROM clientes WHERE id='$ide'");
if (mysqli_num_rows($verificar_ide)>0) {
    echo' <script>
    alert("EL IDE YA ESTA REGISTRADO");
    window.history.go(-1);
    </script>';
    exit;
}


$verificar_telefono=mysqli_query($conexion,"SELECT * FROM clientes WHERE telefono='$movi'");
if (mysqli_num_rows($verificar_telefono)>0) {
    echo' <script>
    alert("EL TELEFONO YA ESTA REGISTRADO");
    window.history.go(-1);
    </script>';
    exit;
}



$verificar_usuario=mysqli_query($conexion,"SELECT * FROM clientes WHERE usuario='$per'");
if (mysqli_num_rows($verificar_usuario)>0) {
    echo' <script>
    alert("EL USUARIO YA ESTA REGISTRADO");
    window.history.go(-1);
    </script>';
    exit;
}



//Ejecutar consulta de insertar
$resultado=mysqli_query($conexion,$insertar);
if (!$resultado) {
    echo "ERROR AL REGISTRARSE";
}
else {
    echo' <script>
    alert("SU CUENTA SE REGISTRO EXITOSAMENTE");
    window.location="formulario.html";
        </script>';
}
conexionmysqli_close($conexion);
?>