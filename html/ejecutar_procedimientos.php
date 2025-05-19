<!-- filepath: /c:/xampp/htdocs/licor/ejecutar_procedimiento.php -->
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

// Obtener el nombre del procedimiento y los parámetros
$proc = $_GET['proc'];
$params = $_GET;

// Eliminar el primer elemento del array (el nombre del procedimiento)
array_shift($params);

// Construir la llamada al procedimiento
$sql = "CALL $proc(";
foreach ($params as $key => $value) {
    $sql .= "'$value', ";
}
$sql = rtrim($sql, ', ') . ")";

// Ejecutar el procedimiento
if ($conn->query($sql) === TRUE) {
    echo "Procedimiento ejecutado con éxito";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>