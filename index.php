<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>
<body>
    <h1>Bienvenue</h1>
    <a href="register.php">S'inscrire</a> | <a href="login.php">Se connecter</a> | <a href="upload.php">Envoyer un fichier</a>
    <?php if (isset($_SESSION['user'])): ?>
        <p>Connecté en tant que <?php echo $_SESSION['user']['email']; ?></p>
        <a href="profile.php">Modifier mon profil</a> | <a href="logout.php">Déconnexion</a>
    <?php endif; ?>
</body>
</html>