<?php
include 'db.php';
if (isset($_GET['delete'])) {
    $file_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM files WHERE id = ?");
    $stmt->execute([$file_id]);
    echo "Fichier supprimé.";
}
?>
