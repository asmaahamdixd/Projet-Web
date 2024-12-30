<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <?php
    include("connexion.php");

    if (isset($_POST["ajouter"]) && isset($_FILES['my_image'])) {
        $nomC = $_POST['nom'];
        $prixC = $_POST['prix'];
        $desC = $_POST['Description'];
        $imageC = $_FILES['my_image'];
        $cat = $_POST['categorie'];

        $nomImg = $imageC["name"];
        $bin = $imageC["tmp_name"];

        $image_separer = explode('.', $nomImg);
        $image_ext = strtolower(end($image_separer));

        $extension = array('jpg', 'jpeg', 'png');
        if (in_array($image_ext, $extension)) {
            $upload_Img = './images/' . $nomImg;
            move_uploaded_file($bin, $upload_Img);
        }

        $req = $pdo->prepare("INSERT INTO cake (nom, prix, description, cat, img) VALUES (?, ?, ?, ?, ?)");
        $res = $req->execute([$nomC, $prixC, $desC, $cat, $upload_Img]);

        if ($res) {
            header('location:adminPage.php');
        } else {
            echo "Erreur lors de l'ajout du cake : " . implode(" ", $req->errorInfo());
        }
    }
    ?>

<form method="post" action="" enctype="multipart/form-data" class="container">
        <fieldset>
            <legend>Ajouter une cake </legend>
            <label class="form-label">Nom :</label>
            <input type="text" class="form-control" name="nom">
            <label class="form-label">Prix :</label>
            <input type="number" class="form-control" name="prix">
            <label class="form-label">Description :</label>
            <input type="text" class="form-control" name="Description">
            <label class="form-label">Image : </label>
            <input type="file" class="form-control" name="my_image">
            <label class="form-label">Catégorie</label>
            <select class="form-select" name="categorie">
                <option value="Red Velvet">Red Velvet</option>
                <option value="Cup Cake">Cup Cake</option>
                <option value="Biscuit">Biscuit</option>
            </select>

            <button type="submit" class="btn btn-primary" name="ajouter">Ajouter</button>
        </fieldset>
    </form>
</body>
</html>
