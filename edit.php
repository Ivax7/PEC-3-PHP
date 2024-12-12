<?php
require 'config/database.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $stmt = $conn->prepare("UPDATE users_pec3 SET nombre = :nombre, apellidos = :apellidos, password = :password WHERE username = :username");
        $stmt->execute([
            ':nombre' => $nombre,
            ':apellidos' => $apellidos,
            ':password' => $hashed_password,
            ':username' => $username
        ]);

        $success = "Perfil actualizado con éxito.";
    } catch (PDOException $e) {
        $error = "Error al actualizar el perfil.";
    }
}

$stmt = $conn->prepare("SELECT nombre, apellidos FROM users_pec3 WHERE username = :username");
$stmt->execute([':username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Perfil</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <h1>Editar Perfil</h1>
    <?php if ($error): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color:green;"><?= $success ?></p>
    <?php endif; ?>
    <form method="POST">
        <label>Nombre: <input type="text" name="nombre" value="<?= htmlspecialchars($user['nombre']) ?>" required></label><br>
        <label>Apellidos: <input type="text" name="apellidos" value="<?= htmlspecialchars($user['apellidos']) ?>" required></label><br>
        <label>Nueva Contraseña: <input type="password" name="password" required></label><br>
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>
