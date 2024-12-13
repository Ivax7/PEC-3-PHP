<?php
session_start();
require 'config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare('SELECT * FROM users_pec3 WHERE username = :username LIMIT 1');
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['apellidos'] = $user['apellidos'];

        header("Location: index.php");
        exit();
    } else {
        $error = "Credenciales inválidas.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title>Login</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main>
        <h1>Login</h1>
        <?php if ($error): ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br><br>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br><br>

            <button type="submit">Login</button>
        </form>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>

