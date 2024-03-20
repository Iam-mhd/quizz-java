<?php
include 'connexion.php'; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Joueurs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        
        .liste-form {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        
        .liste-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .liste-table caption {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .liste-table th,
        .liste-table td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        
        .liste-table th {
            background-color: #007bff; 
            color: #fff; 
        }
        
        .liste-table td {
            text-align: center;
        }
        
        .liste-table button {
            padding: 5px 10px;
            border: none;
            background-color: #dc3545;
            color: #fff; 
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .liste-table button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<?php
$sql = "SELECT nom, prenom FROM joueur";
$result = $connect->query($sql);
if ($result->rowCount() > 0) {
    echo '<div class="liste-form">
            <table class="liste-table">
                <caption> LISTE DES JOUEURS </caption>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $row['nom'] . '</td>';
        echo '<td>' . $row['prenom'] . '</td>';
        echo '<td>
                <form action="supprimer_joueur.php" method="post">
                    <input type="hidden" name="nom_joueur" value="' . $row['nom'] . '">
                    <input type="hidden" name="prenom_joueur" value="' . $row['prenom'] . '">
                    <button type="submit" name="supprimer">Supprimer</button>
                </form>
                <form action="bloquer_joueur.php" method="post">
                    <input type="hidden" name="nom_joueur" value="' . $row['nom'] . '">
                    <input type="hidden" name="prenom_joueur" value="' . $row['prenom'] . '">
                    <button type="submit" name="bloquer">Bloquer</button>
                </form>
              </td>';
        echo '</tr>';
    }

    echo '</tbody></table></div>';
} else {
    echo "Aucun joueur trouvé.";
}
$connect = null;
?>

</body>
</html>
