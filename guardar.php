<?php
// Parámetros de conexión (ajusta los valores)
$server = "tcp:phpdbconcepto.database.windows.net,1433";
$database = "testtconceptobd";
$username = "admintest@phpdbconcepto";
$password = "Teamcoder!";

try {
    // Conexión PDO
    $conn = new PDO("sqlsrv:server=$server;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Crear la tabla si no existe
    $createTableSql = "IF NOT EXISTS (SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'usuarios')
        CREATE TABLE usuarios (
            id INT IDENTITY(1,1) PRIMARY KEY,
            nombre NVARCHAR(100),
            email NVARCHAR(100)
        );";
    $conn->exec($createTableSql);

    // Procesar formulario POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST["nombre"] ?? '';
        $email = $_POST["email"] ?? '';

        // Insertar registro
        $insertSql = "INSERT INTO usuarios (nombre, email) VALUES (?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->execute([$nombre, $email]);
        echo "¡Datos guardados en la base de datos!";
    }
} catch (PDOException $e) {
    echo "Error de conexión o consulta: " . $e->getMessage();
}
?>
