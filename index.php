<?php
include 'connexion.php';

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="container py-4">
<h1 class="mb-4">Liste des Produits</h1>

    <?php include("navB.php"); ?>

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
                    <a href="ajout_client.php" class="btn btn-success">se connecter</a>

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
                        <p class="card-text">prix : <?= htmlspecialchars($article['prix']) ?></p>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Ajouter un client ou se connecter -->

    <a href="adminform.php" class="btn btn-success">se connecter admin</a>
        
</body>

</html>
