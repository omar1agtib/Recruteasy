<?php
$host = 'localhost';
$dbname = 'apprecrutement';
$username = 'root';
$password = '';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);


if (isset($_GET['idoffre'])) {
  $idoffre = $_GET['idoffre'];

} else {
  // gestion de l'erreur ici, comme redirection vers une page d'erreur
}




if (isset($_POST['submit'])) {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];

    $sql = "INSERT INTO candidature (nom, prenom, email,idoffre ) VALUES (:nom, :prenom, :email , :idoffre )";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':idoffre', $idoffre);
    $stmt->execute();


    
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Postuler à l'offre</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    body {
      background-color:rgb(115, 196, 249);
    }
    .card {
      background-color: #fff;
      border: none;
      border-radius: 1rem;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
      margin-top: 4rem;
      padding: 2rem;
    }
    .card-header {
      border-bottom: none;
      font-size: 2rem;
      font-weight: bold;
      text-align: center;
      
    }
    .form-control:focus {
      border-color: #84C7FF;
      box-shadow: none;
    }
    .btn-success {
      margin : auto ;
      border: none;
      border-radius: 1rem;
      font-size: 1.2rem;
      font-weight: bold;
      margin-top: 1rem;
      padding: 0.75rem 2rem;
      transition: all 0.2s ease;
      text-transform: uppercase;
    }
    .btn-success:hover {
      background-color: green;
    }
    .form-control-file {
      font-size: 1rem;
    }
    .fa-upload {
      margin-right: 0.5rem;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card mb-5">
          <div class="card-header">
            Postuler à l'offre
          </div>
          <div class="card-body">
            <form method="POST">
              <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" placeholder="Entrez votre nom" required>
              </div>
              <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Entrez votre prénom" required>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre email" required>
              </div>
              <div class="form-group">
              <button type="submit" name="submit" class="btn btn-success">Postuler</button>
              </div>
              
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
