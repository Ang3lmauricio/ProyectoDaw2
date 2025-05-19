<!-- filepath: /c:/xampp/htdocs/licor/procesar_contacto.php -->
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
$email = $_POST['email'];
$asunto = $_POST['asunto'];
$mensaje = $_POST['mensaje'];

// Insertar datos en la base de datos
$sql = "INSERT INTO mensajes_contacto (nombre, email, asunto, mensaje)
VALUES ('$nombre', '$email', '$asunto', '$mensaje')";

if ($conn->query($sql) === TRUE) {
    echo "Mensaje enviado con éxito";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>