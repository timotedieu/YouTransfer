<?php
include 'db.php';
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user'] = $user;
        echo "Connexion réussie.";
    } else {
        echo "Identifiants incorrects.";
    }
}
?>