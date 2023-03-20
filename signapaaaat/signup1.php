<?php

//connexion bdd :

//$pdo = new PDO("mysql:host=$host;dbname=$dbname",$username,$password) ;



if(isset($_POST['submit'])) {

    $prénom = $_POST['prénom'];
    $nom = $_POST['nom'];
    $user = $_POST['user'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Vérification des champs
    $errors = ['prénom'=> '' , 'nom'=> '' , 'user'=> '' , 'email'=> '' , 'phone'=> '' , 'password'=> '' ];

    if(empty($prénom)) {
        $errors['prénom'] = "Le champ prénom est obligatoire.";
    }

    if(empty($nom)) {
        $errors['nom'] = "Le champ nom est obligatoire.";
    }

    if(empty($user)) {
        $errors['user'] = "Le champ nom d'utilisateur est obligatoire.";
    }

    if(empty($email)) {
        $errors['email'] = "Le champ email est obligatoire.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'adresse email est invalide.";
    }

    if(empty($phone)) {
        $errors['phone'] = "Le champ numéro de téléphone est obligatoire.";
    } elseif(!preg_match('/^[0-9]{10}$/', $phone)) {
        $errors['phone'] = "Le numéro de téléphone est invalide.";
    }

    if(empty($password)) {
        $errors['password'] = "Le champ mot de passe est obligatoire.";
    }

    // Affichage des erreurs
    //if(count($errors) > 0) {
     //   echo "<ul>";
      //7  foreach($errors as $error) {
        //   echo "<li>" . $error . "</li>";
       // }
        //echo "</ul>";
    //}

    // Si il n'y a pas d'erreur, enregistrer les données dans la base de données

}

?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login2</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/stylelogin1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>

<body>
<div class="wrapper main22">
    <div class="container main ">
        <div class="row row22">
              <div class="col-md-6 side-image" style=" background-image: url('images/jbl4.jpg');">
                <div class="text">
                    <h1 class="text-center">Bienvenue !</h1>
                    <p class="text-center">Remplissez le formulaire ci-dessous pour créer votre <br>
                         compte et postuler à nos offres d'emploi.</p>
                </div>
              </div>
              <div class="col-md-6 right">
                <div class="input-box">
                    <header class="header22">s'inscrire</header>

                   <form action="" method="POST">
                    <div class="input-field nomprenom">
                        <input type="text" class="input input22" id="prénom" name="prénom">
                        <label for="prénom">prénom</label>
                    </div>
                    

                    <div class="input-field">
                        <input type="text" class="input input22" id="nom" name="nom">
                        <label for="nom">nom</label>
                    </div>
                    
                    <div class="input-field">
                        <input type="text" class="input input22" id="user" name="user">
                        <label for="user">nom d'utilisateur</label>
                    </div>

                    <div class="input-field">
                        <input type="email" class="input input22" id="email" name="email">
                        <label for="email">email</label>
                    </div>

                    <div class="input-field">
                        <input type="tel" class="input input22" id="phone" name="phone">
                        <label for="phone">numéro de téléphone</label>
                    </div>

                    <div class="input-field">
                        <input type="password" class="input input22" id="password" name="password">
                        <label for="password">mot de passe</label>
                    </div>

                    <div class="input-field">
                        <input type="submit" class="submit" value="s'inscrire" name="submit">
                    </div>

                    </form>

                    <div class="Inscription">
                        <span>Vous êtes déjà inscrit ? <a href="login1.html">Connectez-vous ici !</a></span>
                    </div>

                </div>
              </div>
        </div>
    </div>
</div>
     
    
    
     
    <script src="js/popper.min.js"></script>
    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/bootstrap.js"></script>

</body>

</html>