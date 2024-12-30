<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php
    session_start();
    include("connexion.php");

    if (isset($_POST['login'])) {
        $nomA = $_POST['NomA'];
        $passA = $_POST['PassA'];

        // Vérification dans la base de données
        $req = $pdo->prepare("SELECT * FROM admin WHERE NomA = ? AND PassA = ?");
        $req->execute([$nomA, $passA]);
        $admin = $req->fetch();

        if ($admin) {
            $_SESSION['admin'] = $admin['NomA'];
            header('Location: AdminPage.php');
            exit();
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post" action="" class="border p-4 rounded bg-light">
                    <h2 class="mb-4 text-center">Connexion Admin</h2>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Nom d'utilisateur :</label>
                        <input type="text" name="NomA" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mot de passe :</label>
                        <input type="password" name="PassA" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" name="login">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
