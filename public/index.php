<?php
require('../config/config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT id, file_name, downloads FROM files WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $files = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Erreur lors de la récupération des fichiers : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js" defer></script>
</head>
<body>
    <?php include('navbar.php'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Bienvenue sur YouTransfer</h2>
                        <p class="text-center">YouTransfer est une plateforme qui vous permet de gérer vos fichiers en ligne. Vous pouvez envoyer, télécharger, réserver et supprimer des fichiers facilement.</p>
                        <p class="text-center">Pour commencer, utilisez les liens ci-dessous :</p>
                        <ul class="list-group mb-4">
                            <li class="list-group-item">
                                <a href="upload.php" class="btn btn-primary btn-block">Envoyer un fichier</a>
                                <p class="mt-2">Cliquez ici pour envoyer un nouveau fichier sur la plateforme.</p>
                            </li>
                            <li class="list-group-item">
                                <a href="profile.php" class="btn btn-secondary btn-block">Voir votre profil</a>
                                <p class="mt-2">Accédez à votre profil pour voir vos informations personnelles.</p>
                            </li>
                            <li class="list-group-item">
                                <a href="edit_profile.php" class="btn btn-secondary btn-block">Modifier votre profil</a>
                                <p class="mt-2">Mettez à jour vos informations personnelles.</p>
                            </li>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <li class="list-group-item">
                                    <a href="approve_reservations.php" class="btn btn-warning btn-block">Approuver les réservations</a>
                                    <p class="mt-2">Les administrateurs peuvent approuver les réservations de fichiers.</p>
                                </li>
                            <?php endif; ?>
                        </ul>
                        
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger">
                                <?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>
                        
                        <h3>Vos fichiers :</h3>
                        <p>Voici la liste des fichiers que vous avez téléchargés. Vous pouvez les télécharger, les supprimer ou les réserver pour un téléchargement ultérieur.</p>
                        <ul class="list-group">
                            <?php foreach ($files as $file): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?php echo htmlspecialchars($file['file_name']); ?></strong>
                                        <br>
                                        <small><?php echo $file['downloads']; ?> Téléchargements</small>
                                    </div>
                                    <div>
                                        <a href="download.php?file_id=<?php echo $file['id']; ?>" class="btn btn-sm btn-success">Télécharger</a>
                                        <a href="delete.php?file_id=<?php echo $file['id']; ?>" class="btn btn-sm btn-danger">Supprimer</a>
                                        <a href="reserve.php?file_id=<?php echo $file['id']; ?>" class="btn btn-sm btn-warning">Réserver</a>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
