<?php
include 'connexion.php';
$questionsPerPage = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $questionsPerPage;
$sql = "SELECT question FROM question LIMIT $questionsPerPage OFFSET $offset";

$result = $connect->query($sql);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo '<div class="question">';
    echo '<p>' . $row['question'] . '</p>';
    echo '<form>';
    echo '<button type="button" class="deleteButton">Supprimer</button>'; 
    echo '<button type="button" class="hideButton">Masquer</button>';
    echo '<button type="button" class="editButton">Modifier</button>'; 
    echo '</form>';
    echo '</div>';
}

$connect = null;
?>
