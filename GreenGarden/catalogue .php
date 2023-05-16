<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post" action="">
        <label for="search_term">Rechercher un produit:</label>
        <input type="text" name="search_term" id="search_term">
        <input type="submit" name="search" value="Rechercher">
    </form>

    <h1>Catalogue
    </h1>

    <?php
    $host = "localhost";
    $user = "root";
    $pwd = "";
    $dbname = "greengarden";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
    } catch (PDOException $e) {
        echo "Connection failed " . $e->getMessage();
    }
    if (isset($_POST['search'])) {
        $search_term = $_POST['search_term'];
        $sql = "select * from t_d_produit WHERE nom_court like :search 
    or nom_Long like :search";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':search', '%' . $search_term . '%');
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "<p>Résultats de recherche pour : " . $search_term . "</p>";
            echo "<ul>";
            while ($row = $stmt->fetch()) {
                echo "<li>
                <a href='consult_produit.php?id={$row['Id_Produit']}'>
            {$row['Nom_court']}</a></li>";
            }
            echo "</ul>";
        }
    } else {
        $sql = "select * from t_d_produit";
        $stmt = $conn->query($sql);

        if ($stmt->rowCount() > 0) {
            echo "<ul>";
            while ($row = $stmt->fetch()) {
                echo "<li>
              <a href='consult_produit.php?id={$row['Id_Produit']}'>
            {$row['Nom_court']}</a></li>";
            }
            echo "</ul>";
        }
    }

    ?>

</body>

</html>