<!-- filepath: /C:/xampp/htdocs/licor/ejecutar_vista.php -->
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

// Obtener el nombre de la vista
$vista = $_GET['vista'];

// Construir la consulta para la vista
$sql = "SELECT * FROM $vista";

// Ejecutar la consulta
if ($result = $conn->query($sql)) {
    echo "<div style='margin: 20px;'>";
    if ($result->num_rows > 0) {
        echo "<table border='1' style='width: 100%; border-collapse: collapse;'><tr>";
        // Obtener los nombres de las columnas
        while ($fieldinfo = $result->fetch_field()) {
            echo "<th style='padding: 8px; border: 1px solid #ddd;'>{$fieldinfo->name}</th>";
        }
        echo "</tr>";
        // Obtener los datos de las filas
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td style='padding: 8px; border: 1px solid #ddd;'>{$cell}</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron resultados.";
    }
    echo "</div>";
    $result->free();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

echo "<div style='text-align: center; margin-top: 20px;'>
        <a href='ver_vistas.html' style='padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Regresar a Vistas</a>
      </div>";

$conn->close();
?>