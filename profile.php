<?php
include 'db.php';
if (isset($_POST['update_profile']) && isset($_SESSION['user'])) {
    $new_email = $_POST['email'];
    $stmt = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
    $stmt->execute([$new_email, $_SESSION['user']['id']]);
    $_SESSION['user']['email'] = $new_email;
    echo "Profil mis à jour.";
}
?>