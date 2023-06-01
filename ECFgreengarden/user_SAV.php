<?php
include 'header.php';



$users = [
	[
		"user" => "SAV1",
		"password" => "password"
	]
];


// Vérification si l'utilisateur existe déjà dans la base de données
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

foreach ($users as $user) {
	$stmt = $conn->prepare("SELECT * FROM t_d_user WHERE login=:login");
	$stmt->bindValue(':login', $user["user"]);
	$stmt->execute();
	$userExist = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($userExist) {
		// L'utilisateur existe déjà, affichage d'un message d'erreur
		$error_message = "Ce login est déjà utilisé par un autre utilisateur.";
	} else {
		// Insertion de l'utilisateur dans la base de données
		$password_hash = password_hash($user["password"], PASSWORD_DEFAULT); // Hashage du mot de passe
		$stmt = $conn->prepare("INSERT INTO t_d_user (Login, Password,Id_UserType) 
		VALUES (:login, :mot_de_passe,4)"); //on force le type utilisateur à client
		$stmt->bindValue(':login', $user["user"]);
		$stmt->bindValue(':mot_de_passe', $password_hash);
		$stmt->execute();
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Technicien SAV</title>
</head>

<body>

</body>

</html>