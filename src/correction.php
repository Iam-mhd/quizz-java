<?php

// Vérification de la présence du score
if (isset($_GET['score'])) {
  $score = $_GET['score'];
} else {
  // Redirection vers la page de session si le score n'est pas défini
  header('Location: session.php');
  exit;
}

// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=examenjs', 'root', '');

// Préparation de la requête SQL pour récupérer les questions et leurs réponses
$sql = "SELECT * FROM question";
$stmt = $db->prepare($sql);
$stmt->execute();

// Tableau pour stocker les questions et leurs options
$questions = [];

while ($row = $stmt->fetch()) {
  $question = [
    "id_question" => $row['id_question'],
    "question" => $row['question'],
    "option1" => $row['option1'],
    "option2" => $row['option2'],
    "option3" => $row['option3'],
    "reponse_correcte" => $row['reponse_correcte'],
  ];
  array_push($questions, $question);
}

// Tableau pour stocker les réponses de l'utilisateur (initialisé vide)
$reponses_utilisateur = [];

foreach ($_POST as $key => $value) {
  if (is_array($value)) {
    $reponses_utilisateur[$key] = $value[0];
  }
}

// Calcul du nombre de bonnes réponses
$nb_bonnes_reponses = 0;

// On parcourt le tableau $questions pour vérifier si $reponses_correctes a été défini
if (isset($reponses_correctes)) { // Check if $reponses_correctes exists
  foreach ($reponses_correctes as $reponse_correcte) {
    if (isset($reponses_utilisateur[$reponse_correcte['id_question']])) {
      if ($reponses_utilisateur[$reponse_correcte['id_question']] == $reponse_correcte['reponse_correcte']) {
        $nb_bonnes_reponses++;
      }
    }
  }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Correction du test</title>
</head>
<body>

<h1>Correction du test</h1>

<p>Votre score : <?php echo $score; ?></p>
<p>Nombre de bonnes réponses : <?php echo $nb_bonnes_reponses; ?></p>

<h2>Détail des réponses</h2>

<table>
  <tr>
    <th>Question</th>
    <th>Votre réponse</th>
    <th>Réponse correcte</th>
  </tr>
  <?php
  foreach ($questions as $question) {
    $reponse_utilisateur = "";

    if (isset($reponses_utilisateur[$question['id_question']])) {
      $reponse_utilisateur = $reponses_utilisateur[$question['id_question']];
    }

    echo "<tr>";
    echo "<td>".$question['question']."</td>";
    echo "<td>".$reponse_utilisateur."</td>";
    echo "<td>".$question['reponse_correcte']."</td>";
    echo "</tr>";
  }
  ?>
</table>

</body>
</html>
