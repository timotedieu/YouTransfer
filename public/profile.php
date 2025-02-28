<?php
require 'config/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['file'])) {
    $file_name = basename($_FILES['file']['name']);
    $target_dir = "uploads/";
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO files (user_id, file_name) VALUES (:user_id, :file_name)");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':file_name', $file_name);
            $stmt->execute();
            $success = "Fichier envoyé avec succès.";
        } catch (PDOException $e) {
            $error = "Erreur lors de l'upload : " . $e->getMessage();
        }
    } else {
        $error = "Erreur lors du téléchargement du fichier.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de fichier</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Upload de fichier</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <form method="post" action="" enctype="multipart/form-data">
            <input type="file" name="file" required>
            <button type="submit">Envoyer</button>
        </form>
        <a href="profile.php">Retour au profil</a>
    </div>
</body>
</html>
