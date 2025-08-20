<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulario Alta Usuario</title>
</head>
<body>
    <form method="post" action="guardar.php">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <input type="submit" value="Guardar">
    </form>
</body>
</html>
