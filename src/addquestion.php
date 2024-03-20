<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'connexion.php';
    include 'addquestion.html';
    $question = $_POST['question'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $reponse_correcte = $_POST['reponse_correcte'];
    $stmt = $connect->prepare("INSERT INTO question (question, option1, option2, option3, reponse_correcte) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$question, $option1, $option2, $option3, $reponse_correcte])) {
        echo "La question a été ajoutée avec succès !";
        header("Location:admin.php");
    } else {
        echo "Erreur lors de l'ajout de la question.";
    }
    exit; 
}
?>
