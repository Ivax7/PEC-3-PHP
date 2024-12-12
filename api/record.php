<?php
require '../config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

$stmt = $conn->prepare("SELECT * FROM vinyl_records WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$record = $stmt->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($record);
?>
