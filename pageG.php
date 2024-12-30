<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Garde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

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

        .hero h1 {
            font-size: 4rem;
            font-weight: bold;
        }

        .hero p {
            font-size: 1.5rem;
            margin-top: 10px;
        }

        .btn-custom {
            background-color: orange;
            border: none;
            padding: 15px 30px;
            font-size: 1.2rem;
            color: white;
            border-radius: 5px;
            margin-top: 20px;
        }

        .btn-custom:hover {
            background-color: darkorange;
        }
    </style>
</head>

<body>
<?php include("navB.php"); ?>

    <div class="hero">
        <div>
            <h1>Bienvenue sur notre site</h1>
            <p>Découvrez nos produits et services exceptionnels.</p>
            <a href="index.php" class="btn btn-custom">Explorer</a>
        </div>
    </div>
</body>

</html>
