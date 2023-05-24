<!DOCTYPE html>
<html>

<head>
	<title>Mon panier</title>
</head>

<body>

	<h1>Mon panier</h1>

	<?php
	session_start();
	// Récupération des informations de l'utilisateur connecté
	$host = "localhost"; // Nom d'hôte de la base de données
	$user = "root"; // Nom d'utilisateur de la base de données
	$password_db = ""; // Mot de passe de la base de données
	$dbname = "greengarden"; // Nom de la base de données

	try {
		$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password_db);
		// configuration pour afficher les erreurs pdo
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$totalHT = 0;
		$totalTTC = 0;

		if (isset($_SESSION['panier'])) {
			echo "<table>";
			echo "<tr><th>Produit</th><th>Prix unitaire</th><th>Quantité</th><th>Prix total</th></tr>";
			foreach ($_SESSION['panier'] as $productid => $quantity) {
				$id = $productid;

				$stmt = $conn->prepare("SELECT * FROM t_d_produit WHERE id_produit=:id");
				$stmt->bindValue(':id', $id);
				$stmt->execute();
				$produit = $stmt->fetch(PDO::FETCH_ASSOC);

				$name = $produit['Nom_court'];
				$priceht = $produit['Prix_Achat'];
				$pricettc = $priceht  * (1 + $produit['Taux_TVA'] / 100);

				$total_productht = $priceht * $quantity;
				$total_productttc = $pricettc * $quantity;
				$totalHT += $total_productht;
				$totalTTC += $total_productttc;
				echo "<tr><td>{$name}</td><td>{$priceht} € HT</td><td>{$pricettc} € TTC</td>
				<td>{$quantity}</td><td>{$total_productht} € HT</td><td>{$total_productttc} € TTC</td></tr>";
			}
			echo "</table>";
			echo "<p>Total HT : {$totalHT} €</p>";
			echo "<p>Total TTC : {$totalTTC} €</p>";
		} else {
			echo "<p>Votre panier est vide.</p>";
		}
	} catch (PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}
	?>

	<p><a href="catalogue.php">Continuer mes achats</a></p>
	<a href="validation_panier.php">Passer commande</a>

</body>

</html>