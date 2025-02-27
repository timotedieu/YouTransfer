<?php
include 'db.php';
if (isset($_GET['download'])) {
    $file_id = $_GET['download'];
    $stmt = $pdo->prepare("SELECT * FROM files WHERE id = ?");
    $stmt->execute([$file_id]);
    $file = $stmt->fetch();
    $stmt = $pdo->prepare("UPDATE files SET downloads = downloads + 1 WHERE id = ?");
    $stmt->execute([$file_id]);
    header("Location: uploads/" . $file['file_name']);
}
?>