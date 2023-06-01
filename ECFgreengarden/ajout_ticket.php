<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['user_type'] !== 'SAV' && $_SESSION['user_type'] !== 'Commercial') {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Récupération des informations de l'utilisateur connecté
$host = "localhost"; // Nom d'hôte de la base de données
$user = "root"; // Nom d'utilisateur de la base de données
$password_db = ""; // Mot de passe de la base de données
$dbname = "greengarden"; // Nom de la base de données

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password_db);
    // configuration pour afficher les erreurs pdo
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$bons_cde = $pdo->query("SELECT * FROM t_d_commande")->fetchAll();
$tickets_retour = $pdo->query("SELECT * FROM t_d_ticket")->fetchAll();
$types_retour = $pdo->query("SELECT * FROM t_d_type_ticket")->fetchAll();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    // récupérer les informations du formulaire
    $cde_id = $_POST['num_bon_cde'];
    // $ticket_id = $_POST['num_tickets_retour'];
    $type_retour_id = $_POST['cause_retour'];
    // $suppr_ticket = $_POST['suppr_ticket_retour'];
    $today = date("Y-m-d H:i:s");


    // insérer le ticket dans la base de données
    $stmt = $pdo->prepare("INSERT INTO t_d_ticket (Date_Ticket, Id_Statut, 
    Id_User, Id_Commande, Id_Type) 	
    VALUES (:dateTicket, :statutTicket, :technicien, :cde, :retour)");
    $stmt->bindValue(':dateTicket', $today);
    // $stmt->bindValue(':statutTicket', '$statut_ticket_retour');
    $stmt->bindValue(':statutTicket', 1);
    $stmt->bindValue(':technicien', $user_id);
    $stmt->bindValue(':cde', $cde_id);
    $stmt->bindValue(':retour', $type_retour_id);
    $stmt->execute();

    $order_id = $pdo->lastInsertId();
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout Ticket</title>

    <!-- Header -->
    <?php include 'header.php'; ?>

    <?php if ($_SESSION['user_type'] === 'SAV') : ?>
        <div id="ticketCreation">
            <h1 class="styleTitre">Création ticket </h1>

            <form class="stylePageAjoutTicket" method="post">

                <div>
                    <label class="styleLabelAjoutTicket" for="num_bon_cde">Numéro commande :</label>
                    <label class="styleLabelAjoutTicket" for="cause_retour">Motif :</label>
                </div>

                <div>
                    <select class="styleSelectAjoutTicket" name="num_bon_cde">
                        <?php foreach ($bons_cde as $bon_cde) { ?>
                            <option value="<?= $bon_cde['Id_Commande'] ?>"><?= $bon_cde['Num_Commande'] ?></option>
                        <?php } ?>
                    </select>
                    <select class="styleSelectAjoutTicket" name="cause_retour">
                        <?php foreach ($types_retour as $type_retour) { ?>
                            <option value="<?= $type_retour['Id_Type'] ?>"><?= $type_retour['Libelle_Type'] ?></option>
                        <?php } ?><br>
                    </select>
                    <div class="styleBtnPageAjoutTicket">
                        <input class="styleBtnAjoutTicket" name="create" type="submit" value="Créer ticket">
                    </div>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <h1 class="styleTitre">Liste des tickets retour</h1>

    <div class="recherche">
        <h3 class="text-center">Recherche :</h3>
        <form method="post">

            <div class="ligne">
                <label for="search_num">Numéro de commande</label>
                <input type="text" id="search_num" name="search_num">
            </div>


            <div class="button">
                <button class="btn btn-default" type="submit" name="search">Chercher</button>
                <button class="btn btn-default" type="reset">Reset</button>
            </div>
        </form>
    </div>

    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
        // Afficher un message de succès
        echo "<h2 class='styleTitreSecondaire'>Ticket créé avec succès !</h2>";
    }
    if (isset($_POST['search'])) {
        $search_num = $_POST['search_num'];
        $sql = "select T.*, C.Num_Commande, Ty.Libelle_Type from t_d_ticket T inner  join t_d_commande C on T.Id_Commande = C.Id_Commande inner join t_d_type_ticket Ty on Ty.Id_Type=T.Id_Type WHERE C.Num_Commande like :search";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':search', '%' . $search_num . '%');
        $stmt->execute();
    } else {
        $sql = "select T.*, C.Num_Commande, Ty.Libelle_Type FROM t_d_ticket T inner join t_d_commande C on C.Id_Commande=T.Id_Commande inner join t_d_type_ticket Ty on Ty.Id_Type=T.Id_Type";
        $stmt = $conn->query($sql);
    }


    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch()) {
            $id = $row['Id_Statut'];
            $stm = $pdo->prepare("SELECT Libelle_Statut FROM t_d_statut_ticket WHERE Id_Statut=? LIMIT 1");
            $stm->execute([$id]);
            $statut = $stm->fetch();

            // liste des tickets
            echo "<div class='text-center'><hr>";
            echo "<div class='card-body'><strong>Numéro du ticket : </strong>" . $row['Num_Ticket'] . "</div>";
            echo "<div class='card-body'><strong>Numéro de commande : </strong>" . $row['Num_Commande'] . "</div>";
            echo "<div class='card-body'><strong>Date du ticket : </strong>{$row['Date_Ticket']}</div>";
            echo "<div class='card-body'><strong>Statut du ticket : </strong>" . $statut['Libelle_Statut'] . "</div>";
            echo "<div class='card-body'><strong>Motif : </strong>" . $row['Libelle_Type'] . "</div>";
            echo '<form method="post" class="update-form">';
            echo '<input type="hidden" name="ticket_id" value="' . $row['Id_Ticket'] . '">';
            echo '<select name="statut" class="styleSelectStatut">';
            echo '<option value="1">créés</option>';
            echo '<option value="2">suivis</option>';
            echo '<option value="3">résolus</option>';
            echo '</select>';
            echo '<button type="submit" name="update" class="btn btn-primary">Mettre à jour</button>';
            echo '</form>';


            echo "</div>";
        }
        $stmt->closeCursor(); //vide mémoire
    }
    ?>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['user_type'] === 'SAV' && isset($_POST['ticket_id'])) {
        $ticket_id = $_POST['ticket_id'];
        $statut = $_POST['statut'];

        // Mettre à jour le statut du ticket dans la base de données
        $stmt = $pdo->prepare("UPDATE t_d_ticket SET Id_Statut = :statut WHERE Id_Ticket = :ticket_id");
        $stmt->bindValue(':statut', $statut);
        $stmt->bindValue(':ticket_id', $ticket_id);
        $stmt->execute();

        // Redirection vers la page actuelle pour actualiser la liste des tickets
        header("Location: ajout_ticket.php");
        exit;
    }
    ?>


    <!-- Footer -->
    <?php include 'footer.php'; ?>