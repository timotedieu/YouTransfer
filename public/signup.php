<?php
require 'config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (!empty($email) && !empty($password) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            try {
                $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->execute();
                header("Location: login.php");
                exit();
            } catch (PDOException $e) {
                $error = "Erreur lors de l'inscription : " . $e->getMessage();
            }
        } else {
            $error = "Les mots de passe ne correspondent pas.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post" action="">
            <label>Email :</label>
            <input type="email" name="email" required>
            
            <label>Mot de passe :</label>
            <input type="password" name="password" required>
            
            <label>Confirmer le mot de passe :</label>
            <input type="password" name="confirm_password" required>
            
            <button type="submit">S'inscrire</button>
        </form>
        <p>Déjà un compte ? <a href="login.php">Connectez-vous ici</a></p>
    </div>
</body>
</html>
