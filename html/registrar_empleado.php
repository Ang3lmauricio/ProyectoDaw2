<!-- filepath: /C:/xampp/htdocs/licor/registrar_empleado.php -->
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

$usuario = $_POST['usuario'];
$correo = $_POST['correo'];
$id = $_POST['id'];
$contra = $_POST['contra'];
$idempleados = $_POST['idempleados'];

// Insertar el nuevo empleado en la tabla empleados
$sql = "INSERT INTO empleados (Usuario, correo, id, contra, idempleados) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssisi", $usuario, $correo, $id, $contra, $idempleados);

if ($stmt->execute()) {
    echo "Empleado registrado correctamente.<br>";
} else {
    echo "Error al registrar el empleado: " . $conn->error . "<br>";
}

$stmt->close();
$conn->close();
?>

<br>
<a href="procedimientos.html"><button>Regresar a Procedimientos</button></a>