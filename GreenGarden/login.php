<?php include 'header.php'; ?>

<h1>Connexion</h1>
       
       <form method="post">
        <div class="form-group">
        <label>Email</label>
        <input type="text" name="email" class="form-control" value="">
        </div>
        <div class="form-group">
        <label>Mot de passe</label>
        <input type="password" name="mdp" class="form-control">
        </div>  
        <div class="form-btn-group text-right">
        <button type="submit" class="btn btn-primary">Valider</button>
        </div>   
       </form>

<?php include 'footer.php'; ?>       