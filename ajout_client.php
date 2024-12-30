<?php
include 'connexion.php';
session_start();  // Démarrer la session

if (isset($_POST['NomC'], $_POST['EmailC'], $_POST['PassC'])) {
    $NomC = htmlspecialchars($_POST['NomC']);
    $EmailC = htmlspecialchars($_POST['EmailC']);
    $PassC = htmlspecialchars($_POST['PassC']);  // Mot de passe sans hash

    // Vérifier si l'email existe déjà
    $stmt = $pdo->prepare("SELECT * FROM client WHERE EmailC = ?");
    $stmt->execute([$EmailC]);
    
    if ($stmt->rowCount() > 0) {
        echo 'Cet email est déjà utilisé, veuillez en choisir un autre.';
    } else {
        // Ajouter directement sans hachage
        $stmt = $pdo->prepare('INSERT INTO client (NomC, EmailC, PassC) VALUES (?, ?, ?)');
        $res = $stmt->execute([$NomC, $EmailC, $PassC]); 

        if ($res) {
            echo 'Compte créé avec succès!';

            // Récupérer les informations du nouvel utilisateur
            $user = $pdo->prepare("SELECT * FROM client WHERE EmailC = ?");
            $user->execute([$EmailC]);
            $userData = $user->fetch(PDO::FETCH_ASSOC);

            // Stocker les informations dans la session
            $_SESSION['user_name'] = $userData['NomC'];  // Nom de l'utilisateur
            $_SESSION['user_email'] = $userData['EmailC'];  // Email de l'utilisateur

            // Rediriger vers le tableau de bord ou une autre page après la connexion
            header('Location: client_dashboard.php'); // Redirection vers le tableau de bord
            exit();
        } else {
            echo 'Erreur lors de la création du compte.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un Compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h1>Créer un Compte Client</h1>
    <form method="POST" action="" class="mb-4">
        <div class="mb-3">
            <label for="NomC" class="form-label">Nom</label>
            <input type="text" id="NomC" name="NomC" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="EmailC" class="form-label">Email</label>
            <input type="email" id="EmailC" name="EmailC" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="PassC" class="form-label">Mot de passe</label>
            <input type="password" id="PassC" name="PassC" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Créer un compte</button>
    </form>
    <a href="login.php" class="btn btn-secondary">Déjà un compte ? Se connecter</a>
</body>
</html>
