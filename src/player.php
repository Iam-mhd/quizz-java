




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page des Joueurs</title>
    


<style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../asset/img/logoquizz.jpg');
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-image: url('../asset/img/essai1.jpg');
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile {
            margin-top: 20px;
        }

        .profile p {
            margin: 0;
            font-size: 18px;
        }

        .profile button {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
        }

        .profile button:hover {
            background-color: #c82333;
        }

        .top-players {
            margin-bottom: 20px;
        }

        .top-players h2 {
            text-align: center;
        }

        .top-players table {
            width: 100%;
            border-collapse: collapse;
            color : #0000ff;
            font-weight: bold;

        }

        .top-players th,
        .top-players td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .top-players th {
            background-color: #f2f2f2;
        }

        .sessions {
            margin-bottom: 20px;
        }

        .sessions h2 {
            text-align: center;
        }

        .sessions ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            text-align: center;
        }

        .sessions li {
            margin-bottom: 10px;
        }

        .sessions a {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .sessions a:hover {
            background-color: #0056b3;
        }
        .session-button {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        text-decoration: none;
        border: 2px solid #333;
        border-radius: 5px;
        color: #333;
        background-color: #fff;
        cursor: pointer;
        }
        .session-button:hover {
        background-color: #333;
        color: #fff;
        }

    </style>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.session-button').click(function() {
                var session = $(this).data('session');
                window.location.href = 'section.php?session=' + session;
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bienvenue sur la Page des Joueurs</h1>
            <div class="profile">
                <?php
                session_start();
                if (!isset($_SESSION['user'])) {
                    header("Location: login.php");
                    exit; 
                }
                ?>

                <p>Bonjour, <?php echo $_SESSION['user']['prenom']; ?></p>
                <a href="logout.php"><button>Déconnexion</button></a>
            </div>
        </div>
        
        <div class="top-players">
            <h2>Top 10 des Meilleurs Joueurs</h2>
            <table>
                <tr>
                    <th>Classement</th>
                    <th>Nom</th>
                    <th>Score</th>
                </tr>
                <?php
                include 'connexion.php';
                $query = "SELECT nom, score FROM joueur ORDER BY score DESC LIMIT 10";
                $result = $connect->query($query);

                $rank = 1;
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>{$rank}</td>";
                    echo "<td>{$row['nom']}</td>";
                    echo "<td>{$row['score']}</td>";
                    echo "</tr>";
                    $rank++;
                }
                ?>
            </table>
        </div>

        <div class="sessions">
            <h2>Choisissez une Session</h2>
            <?php for ($i = 1; $i <= 5; $i++) { ?>
                <a href="session.php"><button class="session-button" >Session <?php echo $i; ?></button></a>
            <?php } ?>
        </div>
    </div>
</body>
</html>
