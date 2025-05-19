<!-- filepath: /C:/xampp/htdocs/licor/ejecutar_transaccion.php -->
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

$transaccion = isset($_POST['transaccion']) ? $_POST['transaccion'] : (isset($_GET['transaccion']) ? $_GET['transaccion'] : null);

if ($transaccion == 'transaccion1') {
    $sql = "
    START TRANSACTION;

    -- Actualizar el precio de todos los productos en un 10%
    UPDATE productos SET precio = precio * 1.10;

    -- Registrar el cambio en una tabla de auditoría
    INSERT INTO auditoria (accion, descripcion, fecha) VALUES ('UPDATE', 'Aumento de precio en un 10%', NOW());

    COMMIT;
    ";
    $result_sql = "SELECT * FROM productos ORDER BY id ASC";
} elseif ($transaccion == 'transaccion2') {
    $sql = "
    START TRANSACTION;

    -- Transferir las últimas compras a una tabla de historial de ventas
    INSERT INTO historial_ventas (nombre, direccion, ciudad, estado, codigo_postal, telefono, email, productos, subtotal, envio, total, fecha_compra)
    SELECT nombre, direccion, ciudad, estado, codigo_postal, telefono, email, productos, subtotal, envio, total, fecha_compra 
    FROM datosusuariocompra 
    WHERE fecha_compra >= DATE_SUB(NOW(), INTERVAL 1 MONTH);

    COMMIT;
    ";
    $result_sql = "SELECT * FROM historial_ventas ORDER BY fecha_compra DESC LIMIT 10";
} elseif ($transaccion == 'transaccion3') {
    $sql = "
    START TRANSACTION;

    -- Seleccionar los últimos productos vendidos y a qué usuario se vendieron
    SELECT nombre, email, productos, fecha_compra 
    FROM datosusuariocompra 
    ORDER BY fecha_compra DESC 
    LIMIT 10;

    COMMIT;
    ";
    $result_sql = "SELECT nombre, email, productos, fecha_compra FROM datosusuariocompra ORDER BY fecha_compra DESC LIMIT 10";
} else {
    die("Transacción no válida.");
}

if ($conn->multi_query($sql)) {
    do {
        // Store first result set
        if ($result = $conn->store_result()) {
            $result->free();
        }
        // If there are more result-sets, the print a divider
        if ($conn->more_results()) {
            printf("-----------------\n");
        }
    } while ($conn->next_result());
    echo "Transacción ejecutada correctamente.<br>";
} else {
    echo "Error al ejecutar la transacción: " . $conn->error . "<br>";
}

if ($result = $conn->query($result_sql)) {
    echo "<h2>Resultados de la Transacción</h2>";
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
    $result->free();
} else {
    echo "Error al obtener los resultados: " . $conn->error;
}

$conn->close();
?>