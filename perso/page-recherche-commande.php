<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .recherche {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .ligne {
            display: flex;
            justify-content: space-between;
            padding: 10px;
        }
    </style>
</head>

<body>
    <?php
    include 'header.php';
    ?>


    <div class="recherche">
        <h1>Recherche</h1>
        <form method="post">

            <div class="ligne">
                <label for="search_num">Numéro de commande</label>
                <input type="text" id="search_num" name="search_num">
            </div>


            <div class="button">
                <button class="btn" type="submit" name="search">Chercher</button>
                <button class="btn" type="reset">Reset</button>
            </div>
        </form>
    </div>
    <div class="creationDossier"></div>


    <!-- <?php
    $host = "localhost";
    $user = "root";
    $pwd = "";
    $dbname = "greengarden";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
    } catch (PDOException $e) {
        echo "Connection failed " . $e->getMessage();
    }
    ?>

    <?php
    if (isset($_POST['search'])) {
        $search_term = $_POST['search_term'];
        $sql = "select * from t_d_produit WHERE nom_court like :search or nom_Long like :search";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':search', '%' . $search_term . '%');
        $stmt->execute();
    ?>

    <?php
    include 'footer.php';
    ?> -->