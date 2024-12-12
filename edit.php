<?php
session_start();
require 'config/database.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_email = $_POST['email'];
    $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("UPDATE users SET email = :email, password = :password WHERE username = :username");
    $stmt->bindParam(':email', $new_email);
    $stmt->bindParam(':password', $new_password);
    $stmt->bindParam(':username', $username);

    try {
        $stmt->execute();
        $success = "Perfil actualizado con éxito.";
    } catch (PDOException $e) {
        $error = "Error al actualizar el perfil: " . $e->getMessage();
    }
}

$stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
$stmt->bindParam(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar perfil</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <h1>Editar perfil</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <form method="POST">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <label for="password">Nueva contraseña:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>
