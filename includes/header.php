<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav>
    <a href="index.php">Home</a>
    <a href="random-post.php">Disco Aleatorio</a>
    <a href="records.php">Discos</a>
    <a href="api/records.php/1" target="_blank">API_discos</a>
    <a href="api/record.php/1" target="_blank">API_disco</a>

    <?php if (!isset($_SESSION['username'])): ?>
        <a href="login.php">Login</a>
        <a href="signup.php">Sign up</a>
    <?php else: ?>
        <span>¡Bienvenido, <?= htmlspecialchars($_SESSION['nombre']) ?>!</span>
        <a href="edit.php">Perfil de usuario</a>
        <a href="logout.php">Logout</a>
    <?php endif; ?>
</nav>
