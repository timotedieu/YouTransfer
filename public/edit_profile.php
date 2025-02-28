<?php
require('../config/config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (!empty($email) && (!empty($password) || !empty($confirm_password))) {
        if ($password === $confirm_password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            try {
                $stmt = $pdo->prepare("UPDATE users SET email = :email, password = :password WHERE id = :id");
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->bindParam(':id', $user_id);
                $stmt->execute();
                $success = "Profil mis à jour avec succès.";
            } catch (PDOException $e) {
                $error = "Erreur lors de la mise à jour du profil : " . $e->getMessage();
            }
        } else {
            $error = "Les mots de passe ne correspondent pas.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
} else {
    try {
        $stmt = $pdo->prepare("SELECT email FROM users WHERE id = :id");
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch();
        $email = $user['email'];
    } catch (PDOException $e) {
        $error = "Erreur lors de la récupération des informations : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le profil</title>
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
                        <h2 class="card-title text-center mb-4">Modifier le profil</h2>
                        <?php if (isset($error)) echo "<p class='alert alert-danger'>$error</p>"; ?>
                        <?php if (isset($success)) echo "<p class='alert alert-success'>$success</p>"; ?>
                        <form method="post" action="">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email :</label>
                                <input type="email" name="email" class="form-control" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Nouveau mot de passe :</label>
                                <input type="password" name="password" class="form-control" id="password">
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirmer le mot de passe :</label>
                                <input type="password" name="confirm_password" class="form-control" id="confirm_password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Mettre à jour</button>
                        </form>
                        <a href="profile.php" class="btn btn-secondary mt-3">Retour au profil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>