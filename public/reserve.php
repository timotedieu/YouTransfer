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
        $stmt = $pdo->prepare("INSERT INTO reservations (user_id, file_id, status) VALUES (:user_id, :file_id, 'pending')");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':file_id', $file_id);
        $stmt->execute();
        $success = "Réservation effectuée avec succès.";
    } catch (PDOException $e) {
        $error = "Erreur lors de la réservation : " . $e->getMessage();
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
    <title>Réserver un fichier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php include('navbar.php'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Réserver un fichier</h2>
                        <?php if (isset($error)) echo "<p class='alert alert-danger'>$error</p>"; ?>
                        <?php if (isset($success)) echo "<p class='alert alert-success'>$success</p>"; ?>
                        <a href="index.php" class="btn btn-secondary mt-3">Retour à la page d'accueil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>