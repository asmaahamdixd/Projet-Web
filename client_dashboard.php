<?php
include 'connexion.php';

session_start();
if (!isset($_SESSION['NomC'])) {
    header('Location: login.php');
    exit();
}

try {
    $categoriesStmt = $pdo->query("SELECT DISTINCT cat FROM cake");
    $categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);

    $categorieFiltre = isset($_POST['cat']) ? $_POST['cat'] : '';

    $sql = "SELECT * FROM cake";
    if ($categorieFiltre) {
        $sql .= " WHERE cat = :cat";
    }

    $stmt = $pdo->prepare($sql);
    if ($categorieFiltre) {
        $stmt->execute(['cat' => $categorieFiltre]);
    } else {
        $stmt->execute();
    }

    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Erreur : " . htmlspecialchars($e->getMessage());
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background: url('hero-1.jpg') no-repeat center center;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
        }

        .container {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5); /* Pour rendre le texte plus lisible */
            padding: 40px;
            border-radius: 10px;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .promotion {
            font-size: 1.25rem;
            margin-bottom: 30px;
        }

        .btn-custom {
            background-color: #ff6347; /* Couleur d'un bouton personnalisé */
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 1rem;
            border-radius: 5px;
        }

        .btn-custom:hover {
            background-color: #e53e2f;
        }
    </style>
</head>
<body>

<div class="hero">
    <div class="container">
        <h1>Bienvenue, <?= htmlspecialchars($_SESSION['NomC']) ?></h1>
        <p>Email : <?= htmlspecialchars($_SESSION['EmailC']) ?></p>

        <p class="promotion">Cher client, vous avez 30 solde à utiliser !</p>

        <br><br>
        <a href="logout.php" class="btn btn-danger">Déconnexion</a>
    </div>
</div>

<form method="POST" action="index.php" class="mb-4">
    <div class="row align-items-center">
        <div class="col-auto">
            <label for="cat" class="form-label">Filtrer par catégorie :</label>
        </div>
        <div class="col-auto">
            <select name="cat" id="cat" class="form-select">
                <option value="">Toutes les catégories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat['cat']) ?>" <?= $cat['cat'] === $categorieFiltre ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['cat']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filtrer</button>
        </div>
    </div>
</form>

<div class="row">
    <?php foreach ($articles as $article): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="<?= htmlspecialchars($article['img']) ?>" class="card-img-top" alt="<?= htmlspecialchars($article['nom']) ?>" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($article['nom']) ?></h5>
                    <p class="card-text">Catégorie : <?= htmlspecialchars($article['cat']) ?></p>
                    <p class="card-text">Description : <?= htmlspecialchars($article['description']) ?></p>
                    <p class="card-text">Prix : <?= htmlspecialchars($article['prix']) ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
