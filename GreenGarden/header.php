<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>
<?php if (isset($_SESSION['user_id'])) :
    // Vérification si l'utilisateur existe déjà dans la base de données
    $host = "localhost"; // Nom d'hôte de la base de données
    $user = "root"; // Nom d'utilisateur de la base de données
    $password_db = ""; // Mot de passe de la base de données
    $dbname = "greengarden"; // Nom de la base de données

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password_db);
        // configuration pour afficher les erreurs pdo
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $stmt = $conn->prepare("SELECT * FROM t_d_user WHERE Id_User=:id");
    $stmt->bindValue(':id', $_SESSION['user_id']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    </head>

    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <ul class="navbar-nav mr-auto">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="catalogue.php">Catalogue</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profil.php">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="consultPanier.php">Panier</a>
                        </li>
                        <input type="button" value="Login" class="btn btn-primary">
                        <input type="button" value="Inscription" class="btn btn-primary">
                    </div>
                </ul>
            </nav>
        </header>

        <p>Bonjour <?php echo $user['Login']; ?> !</p>

        <form method="POST">
            <input type="hidden" name="logout" value="true">
            <input type="submit" value="Se déconnecter">
        </form>
    <?php else : ?>
        <p><a href="login.php">Se connecter</a> ou <a href="inscription.php">s'inscrire</a></p>
    <?php endif; ?>