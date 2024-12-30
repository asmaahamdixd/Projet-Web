<?php
include("connexion.php");

if (isset($_GET['npm'])) {
    $nomC = $_GET['npm'];

    // Récupération des données du produit
    $req = $pdo->prepare("SELECT * FROM `cake` WHERE nom=?");
    $req->execute([$nomC]);
    $row = $req->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $prixC = $row['prix'];
        $desC = $row['description'];
        $catC = $row['cat'];
        $imgC = $row['img']; // L'ancienne image
    } else {
        echo "Le produit n'existe pas.";
        exit;
    }
} else {
    echo "Le nom du produit n'est pas spécifié.";
    exit;
}

if (isset($_POST["modifier"])) {
    $nomC = $_POST['nom'];
    $prixC = $_POST['prix'];
    $desC = $_POST['Description'];
    $catC = $_POST['categorie'];

    // Vérifier si une nouvelle image est téléchargée
    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        // Chemin de destination pour l'image téléchargée (dans le répertoire actuel)
        $cheminImage = $_FILES['img']['name'];

        // Vérification de l'extension de l'image
        $extension = pathinfo($cheminImage, PATHINFO_EXTENSION);
        $extensionsValides = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array(strtolower($extension), $extensionsValides)) {
            echo "Seules les images JPG, JPEG, PNG et GIF sont autorisées.";
            exit;
        }

        // Générer un nom unique pour l'image afin d'éviter les conflits de nom
        $nomImage = uniqid() . '.' . $extension;

        // Déplacer le fichier téléchargé dans le répertoire actuel
        if (move_uploaded_file($_FILES['img']['tmp_name'], $nomImage)) {
            // Mettre à jour le chemin de l'image dans la base de données
            $imgC = $nomImage;
        } else {
            echo "Erreur lors du téléchargement de l'image.";
            exit;
        }
    }

    // Mise à jour du produit dans la base de données
    $req = $pdo->prepare("UPDATE `cake` SET `nom`=?, `prix`=?, `description`=?, `cat`=?, `img`=? WHERE nom=?");
    $res = $req->execute([$nomC, $prixC, $desC, $catC, $imgC, $_GET['npm']]);

    if ($res) {
        header('location:adminPage.php'); // Redirige vers la page admin
        exit();
    } else {
        echo "Erreur lors de la modification du produit : " . implode(" ", $req->errorInfo());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier un Produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container py-4">
    <h1 class="mb-4">Modifier un Produit</h1>

    <!-- Formulaire de modification -->
    <form method="post" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" name="nom" id="nom" value="<?= htmlspecialchars($nomC) ?>" required>
        </div>
        <div class="mb-3">
            <label for="prix" class="form-label">Prix</label>
            <input type="number" class="form-control" name="prix" id="prix" value="<?= htmlspecialchars($prixC) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="Description" id="description" required><?= htmlspecialchars($desC) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="categorie" class="form-label">Catégorie</label>
            <select class="form-select" name="categorie" id="categorie">
                <option value="gâteau" <?= $catC == 'gâteau' ? 'selected' : '' ?>>Gâteau</option>
                <option value="biscuit" <?= $catC == 'biscuit' ? 'selected' : '' ?>>Biscuit</option>
                <option value="viennoiserie" <?= $catC == 'viennoiserie' ? 'selected' : '' ?>>Viennoiserie</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="img" class="form-label">Image actuelle</label>
            <img src="<?= htmlspecialchars($imgC) ?>" alt="Image du produit" class="img-fluid" style="max-width: 150px;">
        </div>
        <div class="mb-3">
            <label for="img" class="form-label">Changer l'Image (facultatif)</label>
            <input type="file" class="form-control" name="img" id="img">
        </div>
        <button type="submit" class="btn btn-primary" name="modifier">Modifier</button>
    </form>

    <!-- Bouton de retour -->
    <a href="adminPage.php" class="btn btn-secondary mt-4">Retour à la liste des produits</a>
</body>

</html>
