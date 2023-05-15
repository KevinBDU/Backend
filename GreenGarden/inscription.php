<?php include 'header.php'; ?>

<h1>Inscription</h1>
<form method="post" class="inscrip_form">
   
    <div class="form-group">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control" value="">
    </div>
    <div class="form-group">
        <label>Prenom</label>
        <input type="text" name="prenom" class="form-control" value="">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="text" name="email" class="form-control" value="">
    </div>
   
    <div class="form-group">
        <label>Mot de passe</label>
        <input type="password" name="mdp" class="form-control">
    </div>
    <div class="form-group">
        <label>Confirmation du mot de passe</label>
        <input type="password" name="mdp_confirm" class="form-control">
    </div>
    <div class="form-btn-group text-right">
        <button type="submit" class="btn btn-primary">Valider</button>
    </div>
</form>

<?php include 'footer.php'; ?>