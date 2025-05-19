<!-- filepath: /C:/xampp/htdocs/licor/ejecutar_trigger.php -->
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

// Mostrar los datos antes de la operación
echo "<h2>Datos Antes de la Operación</h2>";
$sql = "SELECT * FROM productos";
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

// Obtener los datos del formulario
$trigger = $_POST['trigger'];
$nombre = $_POST['nombre'] ?? null;
$descripcion = $_POST['descripcion'] ?? null;
$precio = $_POST['precio'] ?? null;
$id = $_POST['id'] ?? null;

// Ejecutar el trigger
if ($trigger == 'trigger_insert') {
    $sql = "INSERT INTO productos (nombre, descripcion, precio) VALUES ('$nombre', '$descripcion', $precio)";
} elseif ($trigger == 'trigger_update') {
    $sql = "UPDATE productos SET precio = $precio WHERE id = $id";
} elseif ($trigger == 'trigger_delete') {
    $sql = "DELETE FROM productos WHERE id = $id";
}

if ($conn->query($sql) === TRUE) {
    echo "Operación ejecutada correctamente.";
} else {
    echo "Error al ejecutar la operación: " . $conn->error;
}

// Mostrar los datos después de la operación
echo "<h2>Datos Después de la Operación</h2>";
$sql = "SELECT * FROM productos";
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
        <a href='ver_triggers.html' style='padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Regresar a Triggers</a>
      </div>";

$conn->close();
?>