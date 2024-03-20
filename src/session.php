<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Session de test</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f0f0f0;
    }
    .container {
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
      text-align: center;
      color: #333;
    }
    form {
      margin-top: 20px;
    }
    p {
      color: #555;
    }
    label {
      display: block;
      margin-bottom: 10px;
    }
    input[type='checkbox'] {
      margin-right: 5px;
    }
    input[type='submit'] {
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    input[type='submit']:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<div class="container">

<form action="correction.php" method="post">

<?php

// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=examenjs', 'root', '');

// Préparation de la requête SQL pour sélectionner 10 questions aléatoires
$sql = "SELECT * FROM question ORDER BY RAND() LIMIT 10";
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
    ];
    array_push($questions, $question);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session de test</title>
</head>
<body>

<h1>Session de test</h1>

<form action="correction.php" method="post">

<?php
// Affichage des questions et options
foreach ($questions as $question) {
    echo "<p>".$question['question']."</p>";
    echo "<label for='".$question['id_question']."_1'><input type='checkbox' name='".$question['id_question']."[]' value='".$question['option1']."' id='".$question['id_question']."_1'> ".$question['option1']."</label><br>";
    echo "<label for='".$question['id_question']."_2'><input type='checkbox' name='".$question['id_question']."[]' value='".$question['option2']."' id='".$question['id_question']."_2'> ".$question['option2']."</label><br>";
    echo "<label for='".$question['id_question']."_3'><input type='checkbox' name='".$question['id_question']."[]' value='".$question['option3']."' id='".$question['id_question']."_3'> ".$question['option3']."</label><br><br>";
}
?>

<input type="submit" value="Valider">

</form>

</body>
</html>
