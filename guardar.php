<?php
// Parámetros de conexión (ajusta los valores según tu servidor y BD)
$host = "bdteamcoderless.mysql.database.azure.com"; // Azure MySQL
$db   = "testtconceptobd";                          // tu base de datos
$user = "sigesa";                                   // o "sigesa@bdteamcoderless" si el driver lo requiere
$pass = "3m3ev%^hqJ26bq*8dPve";                     // tu contraseña
$port = 3306;                                       // puerto MySQL
$caCertPath = __DIR__ . "/DigiCertGlobalRootCA.crt.pem"; // ruta al CA root

// Opcional: reportar errores como excepciones
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = mysqli_init();

// Configurar TLS/SSL: indicar la CA antes de real_connect
mysqli_ssl_set($conn, NULL, NULL, $caCertPath, NULL, NULL);

// Establecer la conexión usando SSL
if (!mysqli_real_connect($conn, $host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL)) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Charset recomendado
$conn->set_charset("utf8mb4");

// Crear la tabla si no existe (sintaxis MySQL)
$createTableSql = "
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email  VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
$conn->query($createTableSql);

// Procesa el formulario POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"] ?? '');
    $email  = trim($_POST["email"] ?? '');

    if ($nombre !== '' && $email !== '') {
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $nombre, $email);
        $stmt->execute();
        echo "¡Datos guardados en la base de datos!";
        $stmt->close();
    } else {
        echo "Por favor, completa ambos campos.";
    }
}

// Cerrar conexión
$conn->close();
?>

