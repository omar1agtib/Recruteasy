<?php


$host = 'localhost';
$dbname = 'apprecrutement';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Si la connexion à la base de données est réussie, vous pouvez maintenant insérer les données dans la table "candidats"
}
catch (PDOException $e) {
  echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

$errors=['prenom'=>'','nom'=>'','user'=>'','email'=>'','phone'=>'','password'=>'' , 'confirm_password'=> '' ] ;

$prenom =  $nom = $user = $email  = $phone = $password =  $confirm_password =   '' ;

    if(isset($_POST['submit'])) { 
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $user = $_POST['user'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if (empty($_POST["prenom"])) {
          $errors['prenom'] = "Veuillez saisir votre prénom.";
        } else {
          $prenom = $_POST["prenom"];
          // Vérifier si le prénom ne contient que des lettres et des espaces
          if (!preg_match("/^[a-zA-Z ]*$/",$prenom)) {
            $errors['prenom'] = "Seules les lettres et les espaces sont autorisés.";
          }
        }
    
         // validation de nom
         if (empty($_POST["nom"])) {
            $errors['nom'] = "Veuillez saisir votre nom.";
          } else {
            $nom = $_POST["nom"];
            // Vérifier si le nom ne contient que des lettres et des espaces
            if (!preg_match("/^[a-zA-Z ]*$/",$nom)) {
                $errors['nom'] = "Seules les lettres et les espaces sont autorisés.";
            }
          }
        
          // validation de user
          if (empty($_POST["user"])) {
            $errors['user'] = "Veuillez saisir votre nom d'utilisateur.";
          } else {
            $user =$_POST["user"];
            // Vérifier si le nom d'utilisateur ne contient que des lettres, des chiffres et des tirets bas
            if (!preg_match("/^[a-zA-Z0-9_]*$/",$user)) {
                $errors['user'] = "Seules les lettres, les chiffres et les tirets bas sont autorisés.";
            }
          }
        
        
            // validation de email
            if (empty($_POST["email"])) {
                $errors['email'] = "Veuillez saisir votre adresse e-mail.";
            } else {
                $email =$_POST["email"];
                // Vérifier si l'adresse e-mail est valide
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors['email'] = "Adresse e-mail invalide.";
                } else {
                    // Vérifier si l'adresse e-mail est déjà utilisée
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM inscrire_candidat WHERE email = ?");
                    $stmt->execute([$email]);
                    $count = $stmt->fetchColumn();
                    if ($count > 0) {
                        $errors['email'] = "Cette adresse e-mail est déjà utilisée.";
                    }
                } }
        
          // validation de phone
          if (empty($_POST["phone"])) {
            $errors['phone']= "Veuillez saisir votre numéro de téléphone.";
          } else {
            $phone =$_POST["phone"];
            // Vérifier si le numéro de téléphone est valide
            if (!preg_match("/^[0-9]*$/",$phone)) {
                $errors['phone']="Seuls les chiffres sont autorisés.";
            }
          }
        
          // validation de password
          if (empty($_POST["password"])) {
            $errors['password']= "Veuillez saisir votre mot de passe.";
          } else {
            $password = $_POST["password"];
            // Vérifier si le mot de passe est assez long et contient des caractères spéciaux
            if (strlen($password) < 8) {
                $errors['password']= "Le mot de passe doit comporter au moins 8 caractères.";
            } elseif (!preg_match("/[!@#$%^&*()\-_=+{};:,<.>]/", $password)) {
                $errors['password']= "Le mot de passe doit contenir au moins un caractère spécial.";
            }
          }

          //confirmation de password 
          if($password != $confirm_password) {
            $errors['confirm_password'] = "La confirmation du mot de passe ne correspond pas au mot de passe";
          }

 

          if(!array_filter($errors)) {
            $sql = "insert into inscrire_candidat (prenom, nom, user, email, phone, passwordd)
            values (:prenom, :nom, :user, :email, :phone, :password)";
         $stmt = $pdo->prepare($sql);
         $stmt->execute(['prenom' => $prenom, 'nom' => $nom, 'user' => $user, 'email' => $email, 'phone' => $phone, 'password' => $password]) ;
    
            header('Location: ConnexionCondidat.php') ;
          }
    

        
     }



//$sql = "delete from inscrire_candidat where id = 1 ";
//$pdo->query($sql);


?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Untitled</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/stylelogin222.css">
    <style>
    header {
  background-color: rgb(49, 48, 52);
  display: flex;
  justify-content: flex-start;
  align-items: center;
  height: 50px;
}
header a {
 color : white ;
 font-size: 3em ;
 font-weight : 700 ;
 text-decoration: none;
 margin-left : 50px ;
}
header a span {
  color :  rgb(115, 196, 249) ;
}

footer {
    margin-top : 0 ;
    background-color: rgb(49, 48, 52);
    display: flex;
    justify-content: space-around;
    align-items: center;
    height: 50px;
}
footer h1 {
    font-size: 30px;
    color : white ;
}
footer i {
    font-size: 23px;
    margin-left: 10px;
    cursor: pointer;
    color : white ;
}
@media all and (max-width : 800px ) {
    footer h1 {
    font-size:17px;
   
}
footer i {
    font-size: 10px;
}
}


    </style>
</head>
<body>
   <header>
    <a href="firstpage.html" class="navbar-brand">Recrut<span class="eazy">Easy</span></a>
   </header>
    <div class="register-photo">
        <div class="form-container">
            <div class="image-holder" style="background-image: url('images/carton1.jpg');"></div>
            <form  method="post">
                <h2 class="text-center"><strong>Créer </strong>votre compte .</h2>
                <div class="form-group">
                    <input class="form-control" type="text" name="prenom" placeholder="Prenom" value="<?php echo htmlspecialchars($prenom); ?>">
                    <div class="err">
                        <?php echo $errors['prenom'] ; ?>
                    </div>
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="nom" placeholder="Nom" value="<?php echo htmlspecialchars($nom); ?>">
                    <div class="err">
                       <?php echo $errors['nom'] ; ?>
                    </div>
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="user" placeholder="nom d'utilisateur"  value="<?php echo htmlspecialchars($user); ?>" autocomplete="off">
                    <div class="err">
                        <?php echo $errors['user'] ; ?>
                    </div>
                </div>
                <div class="form-group">
                    <input class="form-control" type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">
                    <div class="err">
                        <?php echo $errors['email'] ; ?>
                    </div>
                </div>
                <div class="form-group">
                    <input class="form-control" type="phone" name="phone" placeholder="Phone" value="<?php echo htmlspecialchars($phone); ?>">
                    <div class="err">
                        <?php echo $errors['phone'] ; ?>
                    </div>
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="password" placeholder="mot de passe" autocomplete="off" value="<?php echo htmlspecialchars($password); ?>">
                    <div class="err">
                    <?php echo $errors['password'] ; ?>  
                    </div>
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="confirm_password" placeholder="confirmer le mot de passe" autocomplete="off" value="<?php echo htmlspecialchars($confirm_password); ?>">
                    <div class="err">
                    <?php  echo $errors['confirm_password'] ; ?>  
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block" name="submit" type="submit">s'inscrire</button>
                </div>
                <a href="ConnexionCondidat.php" class="already">Vous êtes déjà inscrit ? Connectez-vous ici !</a>
            </form>
        </div>
    </div>
    <footer>
    <h1>RecrutEasy@gmail.com</h1>
        <div class="logofooter">
            <i class="fa-brands fa-instagram"></i>
            <i class="fa-brands fa-facebook"></i>
            <i class="fa-brands fa-twitter"></i>
            <i class="fa-brands fa-linkedin"></i>
          </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>

