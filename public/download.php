<?php
require 'config/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['file_id'])) {
    $file_id = $_GET['file_id'];

    try {
        $stmt = $pdo->prepare("SELECT file_name FROM files WHERE id = :id");
        $stmt->bindParam(':id', $file_id);
        $stmt->execute();
        $file = $stmt->fetch();

        if ($file) {
            $file_path = "uploads/" . $file['file_name'];

            if (file_exists($file_path)) {
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
                header('Content-Length: ' . filesize($file_path));
                readfile($file_path);
                exit();
            } else {
                $error = "Fichier introuvable.";
            }
        } else {
            $error = "Fichier non trouvé.";
        }
    } catch (PDOException $e) {
        $error = "Erreur : " . $e->getMessage();
    }
} else {
    $error = "Aucun fichier spécifié.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Télécharger un fichier</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Télécharger un fichier</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</body>
</html>
