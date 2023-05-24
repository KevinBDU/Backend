<?php
require 'produit.php';
require 'categorie_produit.php';
// Démarrage de la session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérification si le produit est spécifié dans l'URL
if (isset($_GET['id'])) {
    $id_produit = $_GET['id'];

    // Récupération des informations du produit
    try {

        $p = new Produit();
        $produit = $p->getProduitById($id_produit)[0];

        $c = new CategorieProduit();
        $categorie = $c->getCategorieById($produit['Id_Categorie'])[0];
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
        exit();
    }
} else {
    echo "Produit non spécifié";
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo "Green Garden: présentation du produit " . $produit['Nom_court']; ?></title>
</head>

<body>
    <h1><?php echo $produit['Ref_fournisseur'] . " - " . $produit['Nom_court']; ?></h1>
    <img src="img/<?= $produit['Photo'] ?>" width="200px">
    <p>Catégorie: <?php echo $categorie['Libelle']; ?> </p>
    <p>Description: <?php echo $produit['Nom_Long']; ?></p>
    <p>Prix HT: <?php echo $produit['Prix_Achat']; ?> €</p>
    <p>Prix TTC: <?php echo $produit['Prix_Achat'] * (1 + $produit['Taux_TVA'] / 100); ?> €</p>



    <form method="POST" action="ajout_panier.php">
        <input type="hidden" name="id" value="<?php echo $id_produit; ?>">
        <input type="submit" value="Ajouter au panier">
    </form>
</body>

</html>