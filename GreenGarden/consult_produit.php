<?php include 'header.php';
$host = "localhost";
$user = "root";
$pwd = "";
$dbname = "greengarden";
$sql = "select * from t_d_produit";
$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
$stmt = $conn->query($sql);
?>

<div class="row">
    <div class="col-md-4 text-center">
        <img width="200px" src="<?= $src; ?>">
        <p></p>
        <form method="post" class="form-inline">
            <label>Qté</label>
            <select name="quantite" class="form-control">
                <?php
                for ($i = 1; $i <= 10; $i++) :
                ?>
                <option value="<?= $i; ?>"><?= $i; ?></option>
                <?php
                endfor;
                ?>
            </select>
            <button type="submit" class="btn btn-primary">
                Ajouter au panier
            </button>
        </form>
    </div>
    <div class="col-md-8">
   <?php while ($row = $stmt->fetch()) {
         echo "{$row['Nom_Long']}"; }?>
    </div>
</div>

<?php include 'footer.php'; ?>