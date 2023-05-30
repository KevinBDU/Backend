<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Commandes</title>

    <?php include 'header.php'; ?>
    <?php include 'functions.php'; ?>

    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        header('location: login.php');
        exit();
    }
    // Récupération des informations de l'utilisateur connecté
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

    $query = 'SELECT Co.*, Nom_Client as user_lname, Prenom_Client as user_fname
                  FROM t_d_commande Co
                  INNER JOIN t_d_statut_commande S ON S.Id_Statut = Co.Id_Statut
                  INNER JOIN t_d_client C ON C.Id_Client = Co.Id_Client
                  INNER JOIN t_d_user U ON U.Id_User = C.Id_User WHERE U.Id_User = ' . $_SESSION['user_id'];
    $stmt = $conn->query($query);
    $commandes = $stmt->fetchAll();
    ?>

    <h1 class="styleTitre">Mes Commandes</h1>

    <table class="table_cat th_produits table table-striped">
        <tr>
            <th>Numéro de commande</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Date de commande</th>
            <th>Statut</th>
            <th></th>


        </tr>
        <?php


        foreach ($commandes as $commande) :

        ?>
            <tr>
                <td><?= $commande['Num_Commande']; ?></td>
                <td><?= $commande['user_lname']; ?></td>
                <td><?= $commande['user_fname']; ?></td>
                <td><?= afficher_date_fr($commande['Date_Commande']); ?></td>

                <td>
                    <?php
                    //faire une verif en BDD pour voir si l'id enregistré dans la commande correspond au libellé de la table statuts via son id
                    $stm = $conn->query('select Id_Statut, Libelle_Statut from t_d_statut_commande  where Id_Statut= ' . $commande['Id_Statut'] . ' ');
                    $commande_statut = $stm->fetchAll();

                    echo $commande_statut[0]['Libelle_Statut'];
                    ?>

                </td>


            </tr>

        <?php
        endforeach;
        ?>
    </table>

    <?php include 'footer.php'; ?>