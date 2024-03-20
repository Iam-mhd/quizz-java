<?php
session_start();
require_once('src/connexion.php');
$error = "";
$pseudo = "";
$message = "Login Form";

function connexion($email, $password, $connect) {
    $query_joueur = $connect->prepare("SELECT * FROM joueur WHERE email = :email AND mot_de_passe = :mot_de_passe");
    $query_joueur->execute([':email' => $email, ':mot_de_passe' => $password]);
    $user_joueur = $query_joueur->fetch(PDO::FETCH_ASSOC);
    if (!$user_joueur) {
        $query_admin = $connect->prepare("SELECT * FROM administrateur WHERE email = :email AND mot_de_passe = :mot_de_passe");
        $query_admin->execute([':email' => $email, ':mot_de_passe' => $password]);
        $user_admin = $query_admin->fetch(PDO::FETCH_ASSOC);

        if ($user_admin) {
            $_SESSION['user'] = $user_admin;
            $_SESSION['statut'] = 'login';
            return "administrateur";
        }
    } else {
        $_SESSION['user'] = $user_joueur;
        $_SESSION['statut'] = 'login';
        if ($user_joueur['profil'] === "administrateur") {
            return "administrateur";
        } else {
            return "jeux";
        }
    }

    return "error";
}

if (isset($_POST['btn'])) {
    $pseudo = $_POST['login'];
    $password = $_POST['mdp'];
    $result = connexion($pseudo, $password, $connect);  
    if ($result === "administrateur") { 
        header("Location: ./src/admin.php");
        exit(); 
    } elseif ($result === "jeux") {
        header("Location: ./src/player.php");
        exit(); 
    } else {
        $error = "Cet utilisateur n'existe pas";
    }
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('./asset/img/essaie5.jpg');
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        .input-container {
            margin-bottom: 15px;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        .inscription a {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
    
        <h2>Bienvenue dans votre Quiz</h2>
        <?php if(!empty($message)) echo "<div>$message</div>"; ?>
        <form action="" method="post">
            <div class="input-container">
                <input type="text" name="login" placeholder="Email ou Téléphone" value="<?= $pseudo?>" required>    
            </div>
            <div class="input-container">
                <input type="password" name="mdp" placeholder="Mot de passe" required>               
            </div>
            <div>
                <button type="submit" name="btn">Connexion</button>
                <div class="inscription"><a href="./src/inscription.php">S'inscrire pour jouer?</a></div>
            </div>
        </form>
        <?php if(!empty($error)) echo "<div style='color:red;'>$error</div>"; ?>
    </div>
</body>
</html>
