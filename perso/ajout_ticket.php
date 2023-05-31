<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
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

//on récup l'id du technicien SAV grâce à l'id user
$stmt = $pdo->prepare("SELECT * FROM t_d_techniciensav WHERE Id_User=:userid");
$stmt->bindValue(':userid', $user_id);
$stmt->execute();
$technicien = $stmt->fetch(PDO::FETCH_ASSOC);


$bons_cde = $pdo->query("SELECT * FROM t_d_commande")->fetchAll();
$tickets_retour = $pdo->query("SELECT * FROM t_d_ticketsav")->fetchAll();
$types_retour = $pdo->query("SELECT * FROM t_d_typeretour")->fetchAll();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // récupérer les informations du formulaire
    $cde_id = $_POST['num_bon_cde'];
    // $ticket_id = $_POST['num_tickets_retour'];
    $statut_ticket_retour = $_POST['statut_ticket'];
    $type_retour_id = $_POST['cause_retour'];
    // $suppr_ticket = $_POST['suppr_ticket_retour'];
    $today = date("Y-m-d H:i:s");


    // insérer le ticket dans la base de données
    $stmt = $pdo->prepare("INSERT INTO t_d_ticketsav (Date_Ticket_SAV, Statut_Ticket_SAV, 
    Id_Technicien_SAV, Id_Commande, Id_Retour) 	
    VALUES (:dateTicket, :statutTicket, :technicien, :cde, :retour)");
    $stmt->bindValue(':dateTicket', $today);
    // $stmt->bindValue(':statutTicket', '$statut_ticket_retour');
    $stmt->bindValue(':statutTicket', 'crée');
    $stmt->bindValue(':technicien', $technicien['Id_Technicien_SAV']);
    $stmt->bindValue(':cde', $cde_id);
    $stmt->bindValue(':retour', $type_retour_id);
    $stmt->execute();

    $order_id = $pdo->lastInsertId();

    // Rediriger vers la page des tickets SAV avec un message de succès
    // header('Location: ticket_retour.php');
    // exit;
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

    <h1 class="styleTitre">Création ticket retour</h1>

    <form class="stylePageAjoutTicket" method="post">

        <div>
            <label class="styleLabelAjoutTicket" for="num_bon_cde">Numéro bon commande :</label>
            <label class="styleLabelAjoutTicket" for="statut_ticket">Statut ticket retour :</label>
            <label class="styleLabelAjoutTicket" for="cause_retour">Cause du retour :</label>
            <!-- <label class="styleLabelAjoutTicket" for="suppr_ticket_retour">Supprimer le ticket retour :</label> -->
        </div>

        <div>
            <select class="styleSelectAjoutTicket" name="num_bon_cde">
                <?php foreach ($bons_cde as $bon_cde) { ?>
                    <option value="<?= $bon_cde['Id_Commande'] ?>"><?= $bon_cde['Num_Commande'] ?></option>
                <?php } ?>
            </select>
            <select class="styleSelectAjoutTicket" name="cause_retour">
                <?php foreach ($types_retour as $type_retour) { ?>
                    <option value="<?= $type_retour['Id_Retour'] ?>"><?= $type_retour['Libelle_Retour'] ?></option>
                <?php } ?><br>
            </select>
            <!-- <input class="styleInputAjoutTicket" type="checkbox" id="suppr_ticket_retour" name="suppr_ticket_retour"> -->
            <div class="styleBtnPageAjoutTicket">
                <input class="styleBtnAjoutTicket" type="submit" value="Créer ticket">
            </div>
        </div>

    </form>

    <h1 class="styleTitre">Liste des tickets retour</h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Afficher un message de succès
        echo "<h2 class='styleTitreSecondaire'>Ticket créé avec succès !</h2>";
    }

    $sql = "select * from t_d_ticketsav";
    $stmt = $conn->query($sql);

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch()) {

            // liste des tickets
            echo "<div class='styleTextTicket'>";
            echo "<div class='card-body'><strong>Numéro du ticket : </strong>" . $row['Num_Ticket_SAV'] . "</div>";
            echo "<div class='card-body'><strong>Date du ticket : </strong>{$row['Date_Ticket_SAV']}</div>";
            echo "<div class='card-body'><strong>Statut du ticket : </strong>" . $row['Statut_Ticket_SAV'] . "</div>";
            echo "</div>";
        }
        $stmt->closeCursor(); //vide mémoire
    }
    ?>

    <!-- Footer -->
    <?php include 'footer.php'; ?>