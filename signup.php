<?php
session_start();
require 'config/database.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($password !== $password2) {
        $error = "Las contraseñas no coinciden.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        try {
            $stmt = $conn->prepare("INSERT INTO users_pec3 (username, nombre, apellidos, password) VALUES (:username, :nombre, :apellidos, :password)");
            $stmt->execute([
                ':username' => $username,
                ':nombre' => $nombre,
                ':apellidos' => $apellidos,
                ':password' => $hashed_password
            ]);

            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            $error = "El nombre de usuario ya existe.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title>Sign up</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <h1>Registro de Usuario</h1>
    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST">
        <label>Username: <input type="text" name="username" required></label><br>
        <label>Nombre: <input type="text" name="nombre" required></label><br>
        <label>Apellidos: <input type="text" name="apellidos" required></label><br>
        <label>Contraseña: <input type="password" name="password" required></label><br>
        <label>Repetir Contraseña: <input type="password" name="password2" required></label><br>
        <button type="submit">Registrar</button>
    </form>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
