<?php
// Connexion à la base de données
include 'connexion.php';

// Nombre de questions à sélectionner par session
$questionsPerSession = 20;

// Générer une requête SQL pour sélectionner aléatoirement 20 questions
$sql = "SELECT * FROM question ORDER BY RAND() LIMIT $questionsPerSession";
$result = $connect->query($sql);

// Vérifier si des questions ont été sélectionnées avec succès
if ($result) {
    // Afficher les questions sélectionnées
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="question">';
        echo '<p>' . $row['question'] . '</p>';
        echo '<p>' . $row['option1'] . '</p>';
        echo '<p>' . $row['option2'] . '</p>';
        echo '<p>' . $row['option3'] . '</p>';
        echo '</div>';
    }
} else {
    // Afficher un message d'erreur si aucune question n'a été sélectionnée
    echo "Erreur lors de la récupération des questions.";
}

// Fermer la connexion à la base de données
$connect = null;





function is_connect() {
    if (!isset($_SESSION['user'])) {
        header("Location: index.php");
        exit; // Arrêter l'exécution du script après la redirection
    }
}








// Inclure le fichier de connexion à la base de données
include 'connexion.php';

// Définir le nombre de questions à ajouter à chaque niveau
$nombreQuestionsParNiveau = 15;

// Boucle à travers chaque niveau pour ajouter les questions
for ($niveau = 1; $niveau <= 15; $niveau++) {
    // Vérifier si le niveau existe déjà dans la base de données
    $sql = "SELECT COUNT(*) AS count FROM niveau WHERE numero = :numero";
    $stmt = $connect->prepare($sql);
    $stmt->bindValue(':numero', $niveau, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] == 0) {
        // Le niveau n'existe pas, ajoutez-le
        $sql = "INSERT INTO niveau (numero, theme) VALUES (:numero, :theme)";
        $stmt = $connect->prepare($sql);
        $stmt->bindValue(':numero', $niveau, PDO::PARAM_INT);
        $stmt->bindValue(':theme', "Theme du niveau $niveau", PDO::PARAM_STR);
        $stmt->execute();
    }

    // Sélectionnez aléatoirement 15 questions de la base de données
    $sql = "SELECT * FROM question ORDER BY RAND() LIMIT $nombreQuestionsParNiveau";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Associez chaque question au niveau
    foreach ($questions as $question) {
        $questionId = $question['id_question'];
        $sql = "INSERT INTO association (id_question, numero_niveau) VALUES (:id_question, :numero_niveau)";
        $stmt = $connect->prepare($sql);
        $stmt->bindValue(':id_question', $questionId, PDO::PARAM_INT);
        $stmt->bindValue(':numero_niveau', $niveau, PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>


<?php
// Fonction pour récupérer les questions par niveau
function getQuestionsByLevel($level) {
    // Inclure le fichier de connexion à la base de données
    include 'connexion.php';

    // Préparer la requête SQL pour récupérer les questions par niveau
    $query = "SELECT * FROM question WHERE niveau = :level ORDER BY RAND() LIMIT 15"; // Supposons que 'niveau' est le nom de la colonne qui indique le niveau de la question

    // Préparer et exécuter la requête
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':level', $level, PDO::PARAM_INT);
    $stmt->execute();

    // Récupérer les résultats
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retourner les questions
    return $questions;
}
?>
