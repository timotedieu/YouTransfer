<?php
include 'db.php';
if (isset($_FILES['file'])) {
    $file_name = $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], "uploads/$file_name");
    $stmt = $pdo->prepare("INSERT INTO files (user_id, file_name, downloads) VALUES (?, ?, 0)");
    $stmt->execute([$_SESSION['user']['id'], $file_name]);
    echo "Fichier envoyé.";
}
?>