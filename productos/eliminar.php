<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "licoreria";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Validar que se haya enviado el ID del producto
if (isset($_POST['product_id']) && is_numeric($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Verificar si el producto existe
    $checkSql = "SELECT id FROM productos WHERE id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $product_id);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // Si existe, proceder a eliminar
        $deleteSql = "DELETE FROM productos WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $product_id);

        if ($deleteStmt->execute()) {
            echo "
            <script>
                alert('Producto eliminado exitosamente.');
                window.location.href = '../public/js/index.html';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Error al eliminar el producto: " . $conn->error . "');
                window.location.href = '../public/js/index.html';
            </script>
            ";
        }
        $deleteStmt->close();
    } else {
        // Producto no encontrado
        echo "
        <script>
            alert('Producto no encontrado.');
            window.location.href = '../public/js/index.html';
        </script>
        ";
    }

    $checkStmt->close();
} else {
    echo "
    <script>
        alert('ID de producto no válido.');
        window.location.href = '../public/js/index.html';
    </script>
    ";
}

// Cerrar conexión
$conn->close();
?>
