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

    <div class="random-disco-container">
        <img src="<?= htmlspecialchars($record['cover_image']) ?>" alt="Portada del disco" class="cover">
        <p><strong>Título:</strong> <?= htmlspecialchars($record['title']) ?></p>
        <p><strong>Artista:</strong> <?= htmlspecialchars($record['artist']) ?></p>
        <p><strong>Género:</strong> <?= htmlspecialchars($record['genre']) ?></p>
        <p><strong>Año de lanzamiento:</strong> <?= htmlspecialchars($record['release_year']) ?></p>
        <p><strong>Estado:</strong> <?= htmlspecialchars($record['condition']) ?></p>
        <p><strong>Precio:</strong> <?= htmlspecialchars($record['price']) ?> €</p>
    </div>
    
    <?php include 'includes/footer.php'; ?>

</body>
</html>
