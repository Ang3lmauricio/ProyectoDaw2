<!-- filepath: /c:/xampp/htdocs/licor/procesar_compra.php -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "licoreria";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$ciudad = $_POST['ciudad'];
$estado = $_POST['estado'];
$codigo_postal = $_POST['codigo_postal'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$productos = $_POST['productos'];
$subtotal = $_POST['subtotal'];
$envio = $_POST['envio'];
$total = $_POST['total'];

// Insertar datos en la base de datos
$sql = "INSERT INTO datosusuariocompra (nombre, direccion, ciudad, estado, codigo_postal, telefono, email, productos, subtotal, envio, total)
VALUES ('$nombre', '$direccion', '$ciudad', '$estado', '$codigo_postal', '$telefono', '$email', '$productos', '$subtotal', '$envio', '$total')";

if ($conn->query($sql) === TRUE) {
    echo "Compra realizada con éxito";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>