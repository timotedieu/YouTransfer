<?php
require 'config/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['file_id'])) {
    $file_id = $_GET['file_id'];

    try {
        $stmt = $pdo->prepare("SELECT file_name FROM files WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':id', $file_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $file = $stmt->fetch();

        if ($file) {
            $file_path = "uploads/" . $file['file_name'];

            if (unlink($file_path)) {
                $delete_stmt = $pdo->prepare("DELETE FROM files WHERE id = :id");
                $delete_stmt->bindParam(':id', $file_id);
                $delete_stmt->execute();
                header("Location: profile.php");
                exit();
            } else {
                $error = "Erreur lors de la suppression du fichier.";
            }
        } else {
            $error = "Fichier non trouvé ou vous n'avez pas l'autorisation de le supprimer.";
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
    <title>Supprimer un fichier</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Supprimer un fichier</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</body>
</html>
