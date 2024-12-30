<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php  
    try {
    $pdo = new PDO('mysql:host=localhost;dbname=projetphp','root','');
    }
    catch (PDOException $e) {
        echo "Erreur: ".$e->getMessage()."<br/>" ;
    die() ;
    }
    ?>
</body>
</html>