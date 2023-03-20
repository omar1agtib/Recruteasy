<?php
session_start();
$host = 'localhost';
$dbname = 'apprecrutement';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
}


$errors=['titre'=>'','domaine'=>'','nomsociete'=>'','lieu'=>'','contrat'=>'','description'=>''] ;

$titre =  $domaine =$nomsociete = $lieu  = $contrat = $description = $id_recruteur = '' ;

if (isset($_POST['submit'])) {

       $titre = $_POST['titre'];
        $domaine = $_POST['domaine'];
        $nomsociete = $_POST['nomsociete'];
        $lieu = $_POST['lieu'];
        $contrat = $_POST['contrat'];
        $description = $_POST['description'];
        $id_recruteur = $_SESSION['id_recruteur']  ;
  




  // validation de titre
  if (empty($_POST["titre"])) {
    $errors['titre'] = "Veuillez saisir le titre.";
  } 
  /*else {
    $prenom = $_POST["titre"];
    // Vérifier si le prénom ne contient que des lettres et des espaces
    if (!preg_match("/^[a-zA-Z ]*$/",$prenom)) {
      $errors['prenom'] = "Seules les lettres et les espaces sont autorisés.";
    }
  }*/

   // validation de domaine
   /*if (empty($_POST["domaine"])) {
      $errors['domaine'] = "Veuillez saisir votre domaine.";
    } else {
      $nom = $_POST["nom"];
      // Vérifier si le nom ne contient que des lettres et des espaces
      if (!preg_match("/^[a-zA-Z ]*$/",$nom)) {
          $errors['nom'] = "Seules les lettres et les espaces sont autorisés.";
      }
    }*/
  
    // validation de nomsociete
    if (empty($_POST["nomsociete"])) {
      $errors['nomsociete'] = "Veuillez saisir le nom de societe.";
    } 
    /*else {
      $user =$_POST["user"];
      // Vérifier si le nom d'utilisateur ne contient que des lettres, des chiffres et des tirets bas
      if (!preg_match("/^[a-zA-Z0-9_]*$/",$user)) {
          $errors['user'] = "Seules les lettres, les chiffres et les tirets bas sont autorisés.";
      }
    }*/
  
    // validation de lieu
    if (empty($_POST["lieu"])) {
      $errors['lieu'] = "Veuillez saisir le lieu de societe.";
    } 
    /*else {
      $email =$_POST["email"];
      // Vérifier si l'adresse e-mail est valide
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $errors['email'] = "Adresse e-mail invalide.";
      }
    }*/

     // validation de domaine
     if (empty($_POST["domaine"])) {
      $errors['domaine'] = "Veuillez selectionnez le domaine.";
    } 
    /*else {
      $email =$_POST["email"];
      // Vérifier si l'adresse e-mail est valide
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $errors['email'] = "Adresse e-mail invalide.";
      }
    }*/

    
  
    // validation de contrat
    if (empty($_POST["contrat"])) {
      $errors['contrat']= "Veuillez selectionnez le type de contrat.";
    } 
    /*else {
      $phone =$_POST["phone"];
      // Vérifier si le numéro de téléphone est valide
      if (!preg_match("/^[0-9]*$/",$phone)) {
          $errors['phone']="Seuls les chiffres sont autorisés.";
      }
    }*/ 
  
   
   

     if(!array_filter($errors)) {
      $sql = "insert into poste_offre (titre ,
        domaine ,
        nomsociete ,
        lieu ,
        contrat ,
        description ,
        id_recruteur)
                values (:titre ,
                :domaine ,
                :nomsociete ,
                :lieu ,
                :contrat ,
                :description ,
                :id_recruteur)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['titre' => $titre, 'domaine' => $domaine, 'nomsociete' => $nomsociete, 'lieu' => $lieu, 'contrat' => $contrat,
         'description' => $description , 'id_recruteur' => $id_recruteur]) ;
         $idoffre = $pdo->lastInsertId();
         $_SESSION['idoffre'] =  $idoffre ;

      /*header('Location: ConnexionCondidat.php') ;*/
    } 
}



?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Publier une offre d'emploi</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@500;600;700&family=Josefin+Sans:wght@100;200;300;400;500;600;700&family=Oswald:wght@200;400&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Serif:ital,opsz,wght@0,8..144,100;0,8..144,200;0,8..144,300;0,8..144,400;0,8..144,500;0,8..144,600;0,8..144,700;0,8..144,800;0,8..144,900;1,8..144,100;1,8..144,200;1,8..144,300;1,8..144,400;1,8..144,500;1,8..144,600;1,8..144,700;1,8..144,800;1,8..144,900&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500&family=Space+Grotesk:wght@500;700&family=Work+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

*{
    font-family: 'Caveat', cursive;
font-family: 'Josefin Sans', sans-serif;
font-family: 'Oswald', sans-serif;
font-family: 'Poppins', sans-serif;
font-family: 'Roboto Serif', serif;
font-family: 'Rubik', sans-serif;
font-family: 'Space Grotesk', sans-serif;
font-family: 'Work Sans', sans-serif;
 }
      body {
        font-family: "Montserrat", sans-serif;
        background-color: #ffffff;
        
      }
      .container {
        margin-top: 50px;
      }
      h1 {
        text-align: center;
        font-size: 3rem;
        color: #6c757d;
    
      }
      h1 span {
        border-bottom: 2px solid rgb(115, 196, 249) ;
      }
      .form-group label {
        font-weight: bold;
        color: #6c757d;
        font-size: 1.2rem;
      }
      .form-control {
        border-radius: 0;
        border: none;
        border-bottom: 2px solid rgb(108, 117, 125);
        box-shadow: 0 0 20px rgb(108, 117, 125,0.2) ;
      }
      .form-control:focus {
        box-shadow: none;
        border-color: rgb(115, 196, 249);
      }
      .btn-primary {
        background-color: rgb(115, 196, 249);
        border: none;
        border-radius: 0.25rem;
        padding: 9px 18px;
        font-weight: bold;
        margin-top: 10px;
        margin-bottom: 20px;
        
    
      }
      .btn-primary:hover {
        background-color: rgb(70, 175, 246);
      }
      img {
        max-width: 100%;
      }
      textarea {
        min-height: 130px;
        max-height: 200px;
      }
      .err {
        height: 5px;
  width: 100%;
  font-size: 13px;
  font-weight: 500;
  color: red;
  padding-bottom: 10px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h1>Publier une <span>offre d'emploi</span> </h1>
      <div class="row">
        <div class="col-md-6 mt-5">
          <img
             src="images/RH.jpg"
            alt="Image"
          />
        </div>
        <div class="col-md-6 mt-5">
          <form method="POST" action="" class="f">
            <div class="form-group">
              <label for="titre">Titre de l'offre * :</label>
              <input
                type="text"
                class="form-control"
                id="titre"
                placeholder="Saisir le titre de l'offre"
                name="titre"
                 value="<?php echo htmlspecialchars($titre);?>"
              />
              <div class="err">
                        <?php echo $errors['titre'] ; ?>
                    </div>
            </div>
            <div class="form-group">
              <label for="domaine">Domaine * :</label>
  <select id="domaine" name="domaine" class="form-control" value="<?php echo htmlspecialchars($domaine);?>" >
  
  <option value="" class="errr" selected>Veuillez sélectionner le domaine</option>
  <option value="informatique">Informatique</option>
  <option value="finance">Finance</option>
  <option value="marketing">Marketing</option>
  <option value="ventes">Ventes</option>
  <option value="gestion">Gestion</option>
  <option value="ressources-humaines">Ressources humaines</option>
  <option value="communication">Communication</option>
  <option value="juridique">Juridique</option>
  <option value="médical">Médical</option>
  <option value="construction">Construction</option>
  <option value="architecture">Architecture</option>
  <option value="art">Art</option>
  <option value="enseignement">Enseignement</option>
  <option value="transport">Transport</option>
  <option value="hotellerie-restauration">Hôtellerie-Restauration</option>
</select>
<div class="err">
                        <?php echo $errors['domaine'] ; ?>
              </div>
                  

            </div>
            <div class="form-group">
              <label for="nomsociete">Nom de la société * :</label>
              <input
                type="text"
                class="form-control"
                id="nomsociete"
                placeholder="Saisir le nom de la société"
                name="nomsociete" value="<?php echo htmlspecialchars($nomsociete); ?>"
              />
              <div class="err">
                        <?php echo $errors['nomsociete'] ; ?>
              </div>
            </div>

            <div class="form-group">
              <label for="lieu">Lieu * :</label>
              <input
                type="text"
                class="form-control"
                id="lieu"
                placeholder="Saisir le lieu"
                name="lieu" value="<?php echo htmlspecialchars($lieu); ?>"
              />
              <div class="err">
                        <?php echo $errors['lieu'] ; ?>
              </div>
            </div>

            <div class="form-group">
              <label for="typeContrat">Type de contrat * :</label>
              <select class="form-control" id="typeContrat" name="contrat" value="<?php echo htmlspecialchars($contrat); ?>">
                <option value="">Veuillez sélectionner le type de contrat</option>
                <option value="CDI">CDI</option>
                <option value="CDD">CDD</option>
                <option value="Stage">Stage</option>
              </select>
              <div class="err">
                        <?php echo $errors['contrat'] ; ?>
              </div>
            </div>

            <div class="form-group">
              <label for="description">Description de l'offre :</label>
              <textarea 
                class="form-control textarea"
                id="description"
                rows="5"
                placeholder="Saisir la description de l'offre"
                name="description" value="<?php echo htmlspecialchars($description); ?>"
              ></textarea>
            </div>
              
              <button type="submit" class="btn btn-primary" name="submit">Publier</button>
            </form>
          </div>
        </div>
      </div>
      
    <script src="js/popper.min.js"></script>
    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/bootstrap.js"></script>
   

    </body>
  </html>
