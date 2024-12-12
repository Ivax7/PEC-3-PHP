<?php
require 'config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido o no especificado.");
}

$record_id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM vinyl_records WHERE id = :id");
$stmt->bindValue(':id', $record_id, PDO::PARAM_INT);
$stmt->execute();

$record = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title>Discos</title>
</head>
<body>
  <?php include 'includes/header.php'; ?>
    <div class="discos-container">
      <h1><?= htmlspecialchars($record['title']) ?></h1>
      <img src="<?= htmlspecialchars($record['cover_image']) ?>" alt="Portada de <?= htmlspecialchars($record['title']) ?>" width="300px">
      <p><strong>Artista:</strong> <?= htmlspecialchars($record['artist']) ?></p>
      <p><strong>Género:</strong> <?= htmlspecialchars($record['genre']) ?></p>
      <p><strong>Año de lanzamiento:</strong> <?= htmlspecialchars($record['release_year']) ?></p>
      <p><strong>Estado:</strong> <?= htmlspecialchars($record['condition']) ?></p>
      <p><strong>Precio:</strong> <?= htmlspecialchars($record['price']) ?>€</p>
    </div>

    <a href="records.php">Volver a la lista</a>
    
</body>
</html>
