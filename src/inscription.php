<?php
include("connexion.php");
$error = ["nom" => "", "prenom" => "", "login" => "", 'pwd' => ""];
$nom = isset($_POST['nom']) ? $_POST['nom'] : "";
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : ""; 
$login = isset($_POST['email']) ? $_POST['email'] : ""; 
if (isset($_POST['btn'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['pwd'];
    $mot_de_passe_confirm = $_POST['pwd2'];


    if ($mot_de_passe != $mot_de_passe_confirm) {
        echo "<script>alert('Les mots de passe doivent être identiques !')</script>";
    } else {
        $query_check_email = $connect->prepare("SELECT * FROM joueur WHERE email = :email");
        $query_check_email->execute([':email' => $email]);
        if ($query_check_email->rowCount() > 0) {
            echo "<script>alert('Cet email est déjà utilisé !')</script>";
        } else {
            $query_insert_user = $connect->prepare("INSERT INTO joueur (nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :mot_de_passe)");
            $query_insert_user->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':email' => $email,
                ':mot_de_passe' => $mot_de_passe
            ]);

            echo "<script>alert('Utilisateur créé avec succès !')</script>";
            header("Location: ../index.php");
            exit();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #000000; 
    color: #FFFFFF; 
}

.container {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background-image: url('../asset/img/essaie44.jpg');
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.form-group input {
    width: calc(100% - 12px);
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 16px;
}

.form-group input:focus {
    border-color: #007bff;
}
.inshaut {
    text-align: center;
}

.error-message {
    color: red;
    font-size: 14px;
    margin-top: 5px;
}


.avatar-preview {
    margin-top: 20px;
}

.avatar-preview img {
    max-width: 200px;
    max-height: 200px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.submit-btn {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.submit-btn:hover {
    background-color: #0056b3;
}

.return-link {
    display: block;
    margin-top: 10px;
    font-size: 14px;
    color: #007bff;
    text-decoration: none;
}
</style>
</head>

<body>
    <div class="container">
        <div class="inscrire">
            <div class="inshaut">
                <strong>S'INSCRIRE</strong>
                <p>Pour tester votre niveau de culture générale ! </p>
                <hr class="sepins">
                <form action="" method="post" enctype="multipart/form-data" id="form">
                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom" error="error-1" value="<?= $prenom ?>">
                        <span id="error-1" class="error-message"><?= $error['prenom']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" error="error-2" value="<?= $nom ?>">
                        <span id="error-2" class="error-message"><?= $error['nom']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" error="error-3" value="<?= $email ?>">
                        <span id="error-3" class="error-message"><?= $error['login']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="pwd">Password</label>
                        <input type="password" id="pwd" name="pwd" error="error-4">
                        <span id="error-4" class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="pwd2">Confirmation</label>
                        <input type="password" id="pwd2" name="pwd2" error="error-5">
                        <span id="error-5" class="error-message"><?= $error['pwd']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="my-file">Avatar</label>
                        <input class="input-file" name="my-file" error="error-7" id="my-file" type="file" onchange="document.getElementById('avatar-preview').src = window.URL.createObjectURL(this.files[0])">
                        <span id="error-7" class="error-message"></span>
                    </div>
                    <div class="avatar-preview" id="avatar-preview"></div>

                    <div class="form-group">
                        <button type="submit" name="btn" class="submit-btn">Créer compte</button>
                    </div>

                    <a href="../index.php" class="return-link">RETOUR</a>
                </form>
            </div>

        </div>
    </div>
    <script>
        const inputs = document.getElementsByTagName("input");
        for (input of inputs) {
            input.addEventListener("keyup", function(e) {
                if (e.target.hasAttribute("error")) {
                    var idDivError = e.target.getAttribute("error");
                    document.getElementById(idDivError).innerText = ""
                }
            })
        }

        document.getElementById("form").addEventListener("submit", function(e) {
            const inputs = document.getElementsByTagName("input");
            var error = false;
            for (input of inputs) {
                if (input.hasAttribute("error")) {
                    var idDivError = input.getAttribute("error");
                    if (!input.value) {
                        document.getElementById(idDivError).innerText = "Ce champ est obligatoire !";
                        error = true;
                    }

                }
            }
            if (error) {
                e.preventDefault();
                return false;
            }
        });
    </script>
</body>

</html>
