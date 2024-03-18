<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gsb_frais";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Définition du login et du mot de passe à vérifier
$login = "Zakariae";
$mdp = "ca3983640f22d6a38a0708731ac697146026828b88594f9522ae5517960bd56d"; // Mot de passe hashé

// Requête SQL pour récupérer les informations de l'utilisateur
$sql = "SELECT * FROM utilisateur WHERE login='$login' AND mdp='$mdp'";
$result = $conn->query($sql);

$response = array();

if ($result->num_rows > 0) {
    // L'utilisateur est authentifié
    $user = $result->fetch_assoc();
    $response['success'] = true;
    $response['message'] = "Utilisateur authentifié avec succès.";
    $response['user'] = array(
        'id' => $user['id'],
        'nom' => $user['nom'],
        'prenom' => $user['prenom'],
        'login' => $user['login'],
        'adresse' => $user['adresse'],
        'cp' => $user['cp'],
        'ville' => $user['ville'],
        'dateEmbauche' => $user['dateEmbauche']
    );
} else {
    // L'utilisateur n'est pas authentifié
    $response['success'] = false;
    $response['message'] = "Échec de l'authentification. Veuillez vérifier vos identifiants.";
}

// Fermeture de la connexion à la base de données
$conn->close();

// Conversion du tableau en format JSON et envoi de la réponse
header('Content-Type: application/json');
echo json_encode($response);
?>