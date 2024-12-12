<?php

if (isset($_SESSION['username'])) {
    header('Location: index.php'); // Si el usuario ya está logueado, redirigirlo a la página de inicio
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'config/database.php'; // Asegúrate de tener la conexión a la base de datos

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Evitar SQL injection con consultas preparadas
    $stmt = $conn->prepare('SELECT * FROM users_pec3 WHERE username = :username LIMIT 1');
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // El password es válido, iniciar sesión
        $_SESSION['username'] = $user['username'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['apellidos'] = $user['apellidos'];
        header('Location: index.php'); // Redirigir a la página de inicio
        exit();
    } else {
        $error = 'Credenciales inválidas';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    
    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
