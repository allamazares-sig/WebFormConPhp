<?php
// Parámetros de conexión (ajusta los valores según tu servidor y BD)
$serverName = "phpdbconcepto.database.windows.net"; // tu servidor en Azure
$connectionOptions = array(
    "Database" => "testtconceptobd", // tu base de datos
    "Uid" => "admintest",            // tu usuario
    "PWD" => "Teamcoder!"            // tu contraseña
);

// Establece la conexión
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    // Mostrar errores en caso de fallo
    die(print_r(sqlsrv_errors(), true));
}

// Crea la tabla si no existe
$createTableSql = "
IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='usuarios' AND xtype='U')
CREATE TABLE usuarios (
    id INT IDENTITY(1,1) PRIMARY KEY,
    nombre NVARCHAR(100),
    email NVARCHAR(100)
);
";
$stmt = sqlsrv_query($conn, $createTableSql);
if ($stmt === false) {
    die("Error al crear la tabla: " . print_r(sqlsrv_errors(), true));
}

// Procesa el formulario POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"] ?? '';
    $email = $_POST["email"] ?? '';

    // Valida que los campos no estén vacíos
    if ($nombre && $email) {
        $insertSql = "INSERT INTO usuarios (nombre, email) VALUES (?, ?)";
        $params = array($nombre, $email);
        $stmt = sqlsrv_query($conn, $insertSql, $params);
        if ($stmt) {
            echo "¡Datos guardados en la base de datos!";
        } else {
            echo "Error al guardar los datos: " . print_r(sqlsrv_errors(), true);
        }
    } else {
        echo "Por favor, completa ambos campos.";
    }
}

// Cerrar conexión
sqlsrv_close($conn);
?>

