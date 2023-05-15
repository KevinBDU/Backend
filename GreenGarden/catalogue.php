<?php include 'header.php';?>

<body>
    <form method="post" action="">
        <label for="search_term">Rechercher un produit:</label>
        <input type="text" name="search_term" id="search_term">
        <input type="submit" name="search" value="Rechercher">
    </form>

    <h1>Catalogue</h1>

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
            {$row['Photo']}    
            {$row['Nom_court']}
            {$row['Prix_Achat']}€
            </li>";
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
            {$row['Nom_court']}</li>";
            }
            echo "</ul>";
        }
    }

    ?>
<?php include 'footer.php'; ?>
</body>
</html>