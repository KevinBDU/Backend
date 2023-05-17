<?php 
require 'functions.php';

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nom_cat']) && isset($_POST['idParent'])){
        $nomCategorie = $_POST['nom_cat'];

        $stmt = $conn->prepare("SELECT COUNT(*) FROM t_d_categorie WHERE Libelle = :nomcat");
        $stmt->bindValue(":nomcat", $nomCategorie);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) { // La valeur existe déjà dans la table
            echo "La valeur existe déjà dans la table";
            exit();
        } else {
            try {
                $stmt = $conn->prepare("INSERT INTO t_d_categorie (Libelle) VALUES (:nomcat)");
                $stmt->bindValue(":nomcat", $nomCategorie);
                $stmt->execute();
                $categorie_id = $conn->lastInsertId();
                echo "Categorie ajouté avec succès";
                exit();
            } catch (PDOException $e) {
                echo "Erreur: " . $e->getMessage();
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    // include 'header.php';
    if (isset($error)) : ?>
        <p style="color: red"><?= $error ?></p>
    <?php endif ?>

    <?php if (isset($success)) : ?>
        <p style="color: green"><?= $success ?></p>
    <?php endif ?>

    <h1>Ajout d'une categorie</h1>

    <form method="post" enctype="multipart/form-data">
        <div>
            <label for="nomcat">Nom catagorie : </label>
            <input type="text" id="nomcat" name="nom_cat" required>
        </div>
        <select name="idParent">
            <?php
            $stmt = $conn->query("SELECT  DISTINCT(Id_Categorie_Parent) from t_d_categorie");

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch()) {
                    echo "<option>" . $row['Id_Categorie_Parent'] . "</option>";
                }
            }
            ?>
            </select>
        <button type="submit">Ajouter</button>
    </form>    

</body>
</html>