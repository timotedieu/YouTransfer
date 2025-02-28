<?php
require('../config/config.php');
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['reservation_id'])) {
    $reservation_id = $_GET['reservation_id'];

    try {
        $stmt = $pdo->prepare("UPDATE reservations SET status = 'approved' WHERE id = :id");
        $stmt->bindParam(':id', $reservation_id);
        $stmt->execute();
        $success = "Réservation approuvée avec succès.";
    } catch (PDOException $e) {
        $error = "Erreur lors de l'approbation de la réservation : " . $e->getMessage();
    }
}

try {
    $stmt = $pdo->prepare("SELECT r.id, u.email, f.file_name, r.status FROM reservations r JOIN users u ON r.user_id = u.id JOIN files f ON r.file_id = f.id WHERE r.status = 'pending'");
    $stmt->execute();
    $reservations = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Erreur lors de la récupération des réservations : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approuver les réservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php include('navbar.php'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Approuver les réservations</h2>
                        <?php if (isset($error)) echo "<p class='alert alert-danger'>$error</p>"; ?>
                        <?php if (isset($success)) echo "<p class='alert alert-success'>$success</p>"; ?>
                        <ul class="list-group">
                            <?php foreach ($reservations as $reservation): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo htmlspecialchars($reservation['email']) . " a réservé " . htmlspecialchars($reservation['file_name']); ?>
                                    <a href="approve_reservations.php?reservation_id=<?php echo $reservation['id']; ?>" class="btn btn-sm btn-success">Approuver</a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <a href="index.php" class="btn btn-secondary mt-3">Retour à la page d'accueil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>