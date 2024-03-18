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

// Requête SQL pour récupérer l'ID de Louis Villechalane
$sqlUserId = "SELECT id FROM utilisateur WHERE login='Zakariae'";
$resultUserId = $conn->query($sqlUserId);

$response = array();

if ($resultUserId->num_rows > 0) {
    // Récupération de l'ID de Louis Villechalane
    $rowUserId = $resultUserId->fetch_assoc();
    $idUtilisateur = $rowUserId['id'];

    // Requête SQL pour récupérer les fiches de frais de Louis Villechalane
    $sqlFiches = "SELECT * FROM fichefrais WHERE idVisiteur='$idUtilisateur'";
    $resultFiches = $conn->query($sqlFiches);

    if ($resultFiches->num_rows > 0) {
        // Récupération des fiches de frais
        $fiches = array();
        while ($rowFiche = $resultFiches->fetch_assoc()) {
            $fiches[] = $rowFiche;
        }
        $response['fiches'] = $fiches;
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['message'] = "Aucune fiche de frais trouvée pour Louis Villechalane.";
    }
} else {
    $response['success'] = false;
    $response['message'] = "Utilisateur Louis Villechalane non trouvé.";
}

// Fermeture de la connexion à la base de données
$conn->close();

// Conversion du tableau en format JSON et envoi de la réponse
header('Content-Type: application/json');
echo json_encode($response);
?>
