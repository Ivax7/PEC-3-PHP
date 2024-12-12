<?php
require 'config/database.php';
$stmt = $conn->query("SELECT * FROM vinyl_records ORDER BY RAND() LIMIT 1");
$record = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Disco Aleatorio</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <h1>Disco Aleatorio</h1>

    <img width="200px" src="<?= htmlspecialchars($record['cover_image']) ?>" alt="Portada del disco" class="cover">
    <p>Titulo: <?=htmlspecialchars($record['title']) ?></p>
    <p>Artista: <?=htmlspecialchars($record['artist']) ?></p>
    <p>Género: <?=htmlspecialchars($record['genre']) ?></p>
    <p>Año de lanzamiento: <?=htmlspecialchars($record['release_year']) ?></p>
    <p>Estado: <?=htmlspecialchars($record['condition']) ?></p>
    <p>Precio: <?=htmlspecialchars($record['price']) ?> €</p>
</body>
</html>
