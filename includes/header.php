<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="random-post.php">Disco Aleatorio</a></li>
        <li><a href="records.php">Discos</a></li>
        <li><a href="api/records.php/1" target="_blank">API_discos</a></li>
        <li><a href="api/record.php/1" target="_blank">API_disco</a></li>
        
        <?php if (!isset($_SESSION['username'])): ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="signup.php">Sign up</a></li>
        <?php else: ?>
        <li><a href="edit.php">Perfil de usuario</a></li>
        <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
    </ul>    
</nav>
    