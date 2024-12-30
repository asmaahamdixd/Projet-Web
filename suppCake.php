<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un produit</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Animation pour les messages */
        .message {
            display: none;
            font-size: 18px;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        .success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        /* Animation */
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        /* Bouton retour centré */
        .btn-back {
            text-decoration: none;
            padding: 10px 20px;
            background-color:rgb(255, 0, 55);
            color: white;
            border-radius: 5px;
            font-size: 16px;
            display: block;
            width: 200px;
            margin: 20px auto;
            text-align: center;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }

        /* Centrer le contenu de la page */
        .center-content {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    
    <?php
    include 'connexion.php';

    if (isset($_GET['np'])) {
        $nom = $_GET['np'];

        // Vérifier si le produit existe
        $checkQuery = "SELECT COUNT(*) FROM `cake` WHERE nom = :nom";
        $stmtCheck = $pdo->prepare($checkQuery);
        $stmtCheck->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmtCheck->execute();

        $count = $stmtCheck->fetchColumn();
        
        if ($count > 0) {
            // Si le produit existe, on le supprime
            $deleteQuery = "DELETE FROM `cake` WHERE nom = :nom";
            $stmtDelete = $pdo->prepare($deleteQuery);
            $stmtDelete->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmtDelete->execute();

            if ($stmtDelete->rowCount() > 0) {
                // Si la suppression réussie
                echo "<div class='message success'>Le produit a été supprimé avec succès.</div>";
                echo "<script>document.querySelector('.message').style.display = 'block';</script>";
            } else {
                // Si aucune ligne n'a été supprimée malgré l'exécution
                echo "<div class='message error'>Erreur : Aucun produit trouvé avec ce nom, ou le produit a déjà été supprimé.</div>";
                echo "<script>document.querySelector('.message').style.display = 'block';</script>";
            }
        } else {
            // Si le produit n'existe pas dans la base de données
            echo "<div class='message error'>Le produit avec le nom '$nom' n'existe pas dans la base de données.</div>";
            echo "<script>document.querySelector('.message').style.display = 'block';</script>";
        }
    } else {
        echo "<div class='message error'>Aucun nom de produit n'a été fourni.</div>";
        echo "<script>document.querySelector('.message').style.display = 'block';</script>";
    }
    ?>

    <!-- Bouton retour centré -->
    <div class="center-content">
        <a href="adminPage.php" class="btn-back">Retour à la liste des produits</a>
    </div>

</body>
</html>
