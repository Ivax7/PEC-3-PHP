<?php
session_start();
require 'config/database.php';

// Fijos
$fixedDiscsStmt = $conn->query("SELECT * FROM vinyl_records WHERE id IN (1, 2)");
$fixedDiscs = $fixedDiscsStmt->fetchAll(PDO::FETCH_ASSOC);

// Aleatorios
$randomDiscsStmt = $conn->query("SELECT * FROM vinyl_records WHERE id NOT IN (1, 2) ORDER BY RAND() LIMIT 3");
$randomDiscs = $randomDiscsStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title>Home</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <h1>Últimos Discos</h1>
    
    <div class="discos-container">
        <!-- Fijos -->
        <?php foreach ($fixedDiscs as $record): ?>
            <div class="disco">
                <img width="200px" src="<?= htmlspecialchars($record['cover_image']) ?>" alt="Portada del disco" class="cover">
                <a href="post.php?id=<?= htmlspecialchars($record['id']) ?>">
                    <p><strong><?= htmlspecialchars($record['title']) ?></strong> - <?= htmlspecialchars($record['artist']) ?></p>
                </a>
                <p><?= htmlspecialchars($record['price']) ?>€</p>
            </div>
        <?php endforeach; ?>

        <!-- Aleatorios -->
        <?php foreach ($randomDiscs as $record): ?>
            <div class="disco">
                <img width="200px" src="<?= htmlspecialchars($record['cover_image']) ?>" alt="Portada del disco" class="cover">
                <a href="post.php?id=<?= htmlspecialchars($record['id']) ?>">
                    <p><strong><?= htmlspecialchars($record['title']) ?></strong> - <?= htmlspecialchars($record['artist']) ?></p>
                </a>
                <p><?= htmlspecialchars($record['price']) ?>€</p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
