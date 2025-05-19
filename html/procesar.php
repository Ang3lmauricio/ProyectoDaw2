<?php
// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia según tu configuración
$password = ""; // Cambia según tu configuración
$dbname = "licoreria";

try {
    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        throw new Exception("Error al conectar con la base de datos: " . $conn->connect_error);
    }

    // Verificar si se envió el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Capturar y sanitizar los datos del formulario
        $nombre = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $mensaje = $conn->real_escape_string($_POST['message']);

        // Validar campos vacíos
        if (empty($nombre) || empty($email) || empty($mensaje)) {
            echo "Por favor, completa todos los campos.";
            exit;
        }

        // Insertar datos en la tabla
        $sql = "INSERT INTO mensajes_contacto (nombre, email, mensaje) VALUES ('$nombre', '$email', '$mensaje')";
        if ($conn->query($sql) === TRUE) {
            echo "success"; // Respuesta de éxito para el cliente
        } else {
            throw new Exception("Error al guardar los datos: " . $conn->error);
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
} finally {
    // Cerrar conexión
    if (isset($conn)) {
        $conn->close();
    }
}
?>
