<?php
include 'connexion.php';
session_start();

if (isset($_POST['EmailC'], $_POST['PassC'])) {
    $EmailC = htmlspecialchars($_POST['EmailC']);
    $PassC = htmlspecialchars($_POST['PassC']);

    // Vérification de l'email et du mot de passe
    $stmt = $pdo->prepare("SELECT * FROM client WHERE EmailC = ? AND PassC = ?");
    $stmt->execute([$EmailC, $PassC]);
    $user = $stmt->fetch();

    if ($user) {
        // Connexion réussie
       
        $_SESSION['NomC'] = $user['NomC'];
        $_SESSION['EmailC'] = $user['EmailC'];
        
        header('Location: client_dashboard.php'); // Redirection
        exit();
    } else {
        $error_message = 'Email ou mot de passe incorrect.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h1>Connexion Client</h1>

    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php" class="mb-4">
        <div class="mb-3">
            <label for="EmailC" class="form-label">Email</label>
            <input type="email" id="EmailC" name="EmailC" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="PassC" class="form-label">Mot de passe</label>
            <input type="password" id="PassC" name="PassC" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>

    <a href="ajout_client.php" class="btn btn-secondary">Créer un compte</a>
</body>
</html>
