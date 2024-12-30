<?php
include 'connexion.php';

try {
    $articlesStmt = $pdo->query("SELECT * FROM cake");
    $articles = $articlesStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Erreur : " . htmlspecialchars($e->getMessage());
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Gestion des Produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
<?php include("navB.php"); ?>

    <h1 class="mb-4">Admin - Gestion des Produits</h1>
    <a href="ajoutProduits.php" class="btn btn-success mb-4">Ajouter un Produit</a>
    

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>prix</th>
                <th>description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article): ?>
                <tr>
                    <td style="width: 150px;"><img src="<?= htmlspecialchars($article['img']) ?>" alt="<?= htmlspecialchars($article['nom']) ?>" style="width: 100%; height: auto;"></td>
                    <td><?= htmlspecialchars($article['nom']) ?></td>
                    <td><?= htmlspecialchars($article['cat']) ?></td>
                    <td><?= htmlspecialchars($article['prix']) ?></td>
                    <td><?= htmlspecialchars($article['description']) ?></td>
                    <td>
                        <a href="modifCake.php?npm=<?= $article['nom'] ?>" class="btn btn-warning btn-sm">Modifier</a>

                        <a href="suppCake.php?np=<?= urlencode($article['nom']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer <?= htmlspecialchars($article['nom']) ?> ?')">Supprimer</a>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary mt-4">Retour au site</a>
</body>
</html>