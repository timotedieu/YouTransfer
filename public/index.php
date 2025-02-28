<?php
require 'config/config.php';
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
    <div class="container">
        <h2 class="mb-4">Bienvenue sur votre page d'accueil</h2>
        <a href="upload.php" class="btn btn-primary mb-3">Envoyer un fichier</a>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <h3>Vos fichiers :</h3>
        <ul class="list-group">
            <?php foreach ($files as $file): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo htmlspecialchars($file['file_name']); ?>
                    <div>
                        <a href="download.php?file_id=<?php echo $file['id']; ?>" class="btn btn-sm btn-success">Télécharger</a>
                        <a href="delete.php?file_id=<?php echo $file['id']; ?>" class="btn btn-sm btn-danger">Supprimer</a>
                    </div>
                    <span class="badge bg-info"><?php echo $file['downloads']; ?> Téléchargements</span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
