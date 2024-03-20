
<?php session_start();?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <style>
                body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('../asset/img/essaie3.jpg'); 
            background-size: cover;
            background-repeat: no-repeat; 
        }
        .container {
            display: flex;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .left-section {
            flex: 1;
            padding-right: 20px;
        }
        
        .right-section {
            flex: 3;
        }
        
        .image {
            display: block;
            margin: 20px auto;
            max-width: 200px;
            height: auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .haut {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .profil {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px;
        }
        
        .avatar img {
            width: 100%;
            height: auto;
        }
        
        .nom {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }
        
        .menu {
            margin-bottom: 20px;
        }
        
        .sous {
            margin-bottom: 10px; 
        }
        
        .sous a {
            display: block; 
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        
        .sous a:hover {
            background-color: #0056b3;
        }
        
        .sous a.active {
            font-weight: bold;
        }

        .content {
            margin-top: 20px;
        }
        .navigation ul li a {
            display: inline-block;
            padding: 10px 20px;
            margin-bottom: 10px;
            background-color: #007bff; 
            color: #fff; 
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .disconnect{
            display: inline-block;
            padding: 10px 20px;
            margin-bottom: 10px;
            background-color: #007bff; 
            color: #fff; 
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

.navigation ul li a:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="left-section">
            <img class="image" src="../asset/img/logoquizz.jpg" alt="Logo">
            <div class="navigation">
                <ul>
                    <li><a href="#" onclick="loadContent('questionlist.html')">Liste Questions</a></li>
                    <li><a href="#" onclick="loadContent('addadmin.php')">Créer Admin</a></li>
                    <li><a href="#" onclick="loadContent('listeJoueur.php')">Liste Joueurs</a></li>
                    <li><a href="#" onclick="loadContent('addquestion.html')">Créer des Questions</a></li>
                    <li><a href="#" onclick="loadContent('addjoueur.php')">Créer joueur</a></li>
                </ul>
            </div>
        </div>
        <div class="right-section">
            <div class="header">
                <div class="haut">Le plaisir de jouer</div>
            </div>
            <div class="profil">
               
                <div class="avatar"><img src="../asset/img/<?=$_SESSION['user']['image']?>" alt="Avatar"></div>
                <div class="nom"><?= strtoupper($_SESSION['user']['nom']);?></div>
                <a href="logout.php" onclick="return(confirm('Vous vous déconnectez ?'));"><button type="submit" class="disconnect">Déconnexion</button></a>
            </div>
            <div class="content" id="dynamicContent">

            </div>
        </div>
    </div>

    <script>
        function loadContent(page) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("dynamicContent").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", page, true);
            xhttp.send();
        }
    </script>
</body>
</html>
