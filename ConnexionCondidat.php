<?php
// Connexion à la base de données

session_start() ;
$host = 'localhost';
$dbname = 'apprecrutement';
$username = 'root';
$password = '';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$err_omar = '' ;
// Vérification de la soumission du formulaire
if (isset($_POST['submit'])) {
    // Récupération des informations d'identification de l'utilisateur
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Requête SQL pour récupérer l'utilisateur correspondant aux informations d'identification
    $query = "SELECT * FROM inscrire_candidat where email = ? and passwordd = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email, $password]);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['id_candidat'] = $user_data['id_candidat'] ;

    // Vérification de la présence de l'utilisateur dans la base de données
    if ($user_data) {
        // Redirection vers la page "ffff.php"
        header("Location: choixcondidat.html");
        exit();
    } else {
        // Affichage d'un message d'erreur si les informations d'identification sont incorrectes
        $err_omar = "L'email ou mot de passe incorrect.";
    }
}
?>





<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Untitled</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
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
 </style>
</head>
<body>
    <header>
    <a href="firstpage.html" class="navbar-brand">Recrut<span class="eazy">Easy</span></a>
   </header>

    <div class="register-photo" style="height: 100vh;">
        <div class="form-container">
            <div class="image-holder"  style="background-image: url('images/recrutementimg.jpg');"></div>
            <form method="post">
                <h2 class="text-center"><strong>Connecter </strong>à votre compte .</h2>
               
                <div class="form-group">
                    <input class="form-control" type="email" name="email" placeholder="Email">
                </div>

                <div class="form-group">
                    <input class="form-control" type="password" name="password" placeholder="mot de passe">
                </div>
                <div style="width:100% ; height : 6px  ; font-size : 12px ; color : red ; font-weight : 500 ;"> <?php echo $err_omar ; ?> </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block" type="submit" name="submit">s'inscrire</button>
                </div>
                <a href="InscriptionCondiat.php" class="already">Vous n'avez pas de compte ? Inscrivez-vous</a>
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
