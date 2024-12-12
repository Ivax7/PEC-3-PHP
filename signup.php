<?php
require 'config/database.php'; // Asegúrate de tener la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $password = $_POST['password']; // La contraseña que el usuario ingresa

    // Cifrado de la contraseña usando password_hash
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Inserta el nuevo usuario en la base de datos
    $stmt = $conn->prepare('INSERT INTO users_pec3 (username, nombre, apellidos, password) VALUES (:username, :nombre, :apellidos, :password)');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellidos', $apellidos);
    $stmt->bindParam(':password', $hashed_password);

    if ($stmt->execute()) {
        header('Location: index.php'); // Página de inicio al regitrarte
    } else {
        echo "Error al registrar usuario.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Document</title>
</head>
<body>
    </html>
    <?php include 'includes/header.php'; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellidos" placeholder="Apellidos" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Registrar</button>
    </form>
</body>
