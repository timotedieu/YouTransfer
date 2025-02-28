<?php
require('../config/config.php');
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center">Supprimer un fichier</h2>
                        <?php if (isset($error)) echo "<p class='alert alert-danger'>$error</p>"; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
