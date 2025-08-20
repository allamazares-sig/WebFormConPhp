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

// Prueba simple de consulta
$tsql = "SELECT TOP 5 * FROM INFORMATION_SCHEMA.TABLES";
$getResults = sqlsrv_query($conn, $tsql);

if ($getResults == FALSE) {
    echo (sqlsrv_errors());
} else {
    echo ("Leyendo tablas de INFORMATION_SCHEMA" . PHP_EOL);
    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
        echo ($row['TABLE_NAME'] . PHP_EOL);
    }
    sqlsrv_free_stmt($getResults);
}

// Cerrar conexión
sqlsrv_close($conn);
?>

