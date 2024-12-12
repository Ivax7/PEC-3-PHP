<nav>
    <a href="index.php">Home</a>
    <a href="random-post.php">Disco</a>
    <a href="records.php">Discos</a>
    <a href="api/records/1" target="_blank">API_discos</a>
    <a href="api/record/1" target="_blank">API_disco</a>

    <?php if (!isset($_SESSION['username'])): ?>
        <!-- Si el usuario no está logueado, mostrar login y signup -->
        <a href="login.php">Login</a>
        <a href="signup.php">Sign up</a>
    <?php else: ?>
        <!-- Si el usuario está logueado, mostrar perfil y logout -->
        <a href="edit.php">Perfil de usuario</a>
        <a href="logout.php">Logout</a>
    <?php endif; ?>
</nav>

