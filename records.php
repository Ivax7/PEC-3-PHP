<?php
require 'config/database.php';

// Configuración de paginación
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit; // Punto de partida para la paginación


// Variables de ordenación
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'title';
$order_dir = isset($_GET['order_dir']) && $_GET['order_dir'] === 'desc' ? 'DESC' : 'ASC';

// Variables de filtrado
$filter_artist = isset($_GET['artist']) ? $_GET['artist'] : '';
$filter_genre = isset($_GET['genre']) ? $_GET['genre'] : '';
$filter_condition = isset($_GET['condition']) ? $_GET['condition'] : '';

// Construir la consulta SQL dinámica
$sql = "SELECT * FROM vinyl_records WHERE 1=1";

// Aplicar filtros si están definidos
if (!empty($filter_artist)) {
    $sql .= " AND artist LIKE :artist";
}
if (!empty($filter_genre)) {
    $sql .= " AND genre LIKE :genre";
}
if (!empty($filter_condition)) {
    $sql .= " AND `condition` = :condition";
}

// Aplicar ordenación
$sql .= " ORDER BY $order_by $order_dir LIMIT :limit OFFSET :offset";

// Preparar la consulta
$stmt = $conn->prepare($sql);

// Enlace de valores para los filtros
if (!empty($filter_artist)) {
    $stmt->bindValue(':artist', '%' . $filter_artist . '%', PDO::PARAM_STR);
}
if (!empty($filter_genre)) {
    $stmt->bindValue(':genre', '%' . $filter_genre . '%', PDO::PARAM_STR);
}
if (!empty($filter_condition)) {
    $stmt->bindValue(':condition', $filter_condition, PDO::PARAM_STR);
}

// Valores para la paginación
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

// Obtener resultados
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener el total de discos
$totalStmt = $conn->query("SELECT COUNT(*) AS total FROM vinyl_records");
$totalRecords = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalRecords / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title>Discos</title>
</head>
<body>
<?php include 'includes/header.php'; ?>

    <h1>Lista de Discos</h1>
    
    <!-- Opciones de ordenación -->
    <form method="get">
        <label for="order_by">Ordenar por:</label>
        <select name="order_by" id="order_by">
            <option value="price" <?= $order_by === 'price' ? 'selected' : '' ?>>Precio</option>
            <option value="release_year" <?= $order_by === 'release_year' ? 'selected' : '' ?>>Año de lanzamiento</option>
        </select>
        <select name="order_dir" id="order_dir">
            <option value="asc" <?= $order_dir === 'ASC' ? 'selected' : '' ?>>Ascendente</option>
            <option value="desc" <?= $order_dir === 'DESC' ? 'selected' : '' ?>>Descendente</option>
        </select>

        <!-- Opciones de filtrado -->
        <label for="artist">Artista:</label>
        <input type="text" name="artist" id="artist" value="<?= htmlspecialchars($filter_artist) ?>">
        
        <label for="genre">Género:</label>
        <input type="text" name="genre" id="genre" value="<?= htmlspecialchars($filter_genre) ?>">

        <label for="condition">Estado:</label>
        <select name="condition" id="condition">
            <option value="" <?= $filter_condition === '' ? 'selected' : '' ?>>Todos</option>
            <option value="new" <?= $filter_condition === 'new' ? 'selected' : '' ?>>Nuevo</option>
            <option value="used" <?= $filter_condition === 'used' ? 'selected' : '' ?>>Usado</option>
            <option value="collection" <?= $filter_condition === 'collection' ? 'selected' : '' ?>>Colección</option>
        </select>

        <button type="submit">Aplicar</button>
    </form>
    
    <!-- Listado de discos -->
    <div class="discos-container">
        <?php foreach ($records as $record): ?>
            <div class="disco">
                <img width="200px" src="<?= htmlspecialchars($record['cover_image']) ?>" alt="Portada del disco" class="cover">
                <a href="post.php?id=<?= htmlspecialchars($record['id']) ?>">
                <p><strong><?= htmlspecialchars($record['title']) ?></strong> - <?= htmlspecialchars($record['artist']) ?>
                </a> 
                </p>
                <p><?= htmlspecialchars($record['price']) ?>€</p>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Paginación -->
    <div class="paginacion">
        <?php if ($page > 1): ?>
            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">Anterior</a>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" <?= $i === $page ? 'class="active"' : '' ?>><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">Siguiente</a>
        <?php endif; ?>
    </div>
</body>
</html>
