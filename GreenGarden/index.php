<?php include 'header.php';
require 'functions.php';

?>

<?php
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    echo "Connecté.";
} else {
    echo "Non connecté.";
}


?>
<?php include 'footer.php'; ?>