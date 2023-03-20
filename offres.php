<?php

$host = 'localhost';
$dbname = 'apprecrutement';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

// Récupération des domaines disponibles
$sql_domaines = "SELECT DISTINCT domaine FROM poste_offre";
$resultat_domaines = $pdo->query($sql_domaines);
$domaines = $resultat_domaines->fetchAll(PDO::FETCH_COLUMN);

// Vérification si un domaine a été sélectionné par le candidat
if (isset($_POST['submit']) && in_array($_POST['domaine'], $domaines)) {
    $domaine = $_POST['domaine'];
    $sql = "SELECT po.idoffre , po.titre, po.domaine, po.nomsociete, po.lieu, po.contrat, po.description, po.id_recruteur, ic.prenom, ic.nom
        FROM poste_offre po
        INNER JOIN inscrire_recruteur ic ON po.id_recruteur = ic.id_recruteur
        WHERE po.domaine = ?";

    $resultat = $pdo->prepare($sql);
    $resultat->execute([$domaine]);
    
    
} else {
    $sql = "SELECT po.idoffre , po.titre, po.domaine, po.nomsociete, po.lieu, po.contrat, po.description, po.id_recruteur, ic.prenom, ic.nom
    FROM poste_offre po
    INNER JOIN inscrire_recruteur ic ON po.id_recruteur = ic.id_recruteur";

    $resultat = $pdo->query($sql);
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>welcome</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0 auto;
            width: 100%;
        
        }
        h1 {
  font-size: 3rem;
  text-align: center;
  margin-top: 30px;
  color:  rgb(115, 196, 249) ;
  font-weight : 600 ;
  text-shadow: 0px 0px 1px black;
  text-transform : uppercase ;
}
        .card {
            margin-bottom: 20px;
            border-radius: 1px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease-in-out;
           
        }
        .card:hover {
            transform: translateY(-5px);
            background-color :  #22267b;
        }
        .card-header {
            border-radius: 1px 1px 0 0;
    
            height: 50px;

            color: rgb(115, 196, 249);
            font-size : 18px ;
            display: flex;
            justify-content: center;
            align-items: center;
            transition:  0.3s ease-in-out;
            
            
        }
         h2 {
            font-weight : 700 ;
            letter-spacing : 1.3px ;
            text-align : center ;
            color : rgb(115, 196, 249) ;
        }
        .card:hover h2 {
           color : white ;
        }
        .card-body p {
            margin-bottom: 5px;
            padding : 0 1px ;
           
        }
        .card:hover .card-body p {
            color :  #ffebb7 ;
        }
        .card:hover .card-body p span {
            color :  #ffebb7 ;
        }
        
        .card-body {
            padding : 5px 17px ;
            text-align : center ;
            font-size : 14px ;
        }
        .card-body span {
            margin-left : 10px ;
        }

        .card-body p span {
            color: black;
            font-weight: bold;
        }
        
        .cccc {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .col-lg-6 {
            flex-basis: calc(50% - 10px);
            margin-bottom: 20px;
        }
        footer {
            height: 60px; 
            width : 100%
        }
       


        .search-form {
    max-width: 500px;
    margin: 0 auto;
    margin-bottom : 30px ;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    background-color: #f2f2f2;
    border-radius: 10px;
  }
  
  .form-group {
    margin-bottom: 20px;
    width: 100%;
  }
  
  label {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
    display: block;
    text-align: center;
  }
  
  .form-control {
    height: 50px;
    font-size: 16px;
    border-radius: 5px;
    
  }
  
  .search-button {
    width: 100%;
    max-width: 200px;
    font-size: 18px;
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 5px;
  }
  
  .search-button:hover {
    background-color: #007bff;
  }
        
    </style>
</head>
<body>



<div class="container">
    <h1 class="text-center mb-5">Offres d'emploi</h1>
    <form method="post" class="search-form">
  <div class="form-group">
    <label for="domaine">Sélectionnez votre domaine :</label>
    <select class="form-control" id="domaine" name="domaine">
    <option value="">Sélectionnez</option>
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
  </div>
  <button type="submit" class="btn btn-primary search-button" name="submit">Rechercher</button>
</form>


<div class="cccc">
    <?php
    // Affichage des informations des offres
    while ($offre = $resultat->fetch(PDO::FETCH_ASSOC)) {
    
        echo '
        <div class="card col-lg-6 col">
            
                <h2>'.$offre['titre'].'</h2>
            
            <div class="card-body">
                <p><i class="fas fa-briefcase"></i> <span>'.$offre['domaine'].'</span></p>
                <p><i class="fas fa-building"></i> <span>'.$offre['nomsociete'].'</span></p>
                <p><i class="fas fa-map-marker-alt"></i> <span>'.$offre['lieu'].'</span></p>
                <p><i class="fas fa-file-contract"></i><span> '.$offre['contrat'].'</span></p>
                <p><i class="fas fa-lightbulb"></i> <span>'. $offre['description'].'</span></p>
                <p><i class="fa-solid fa-user-tie"></i> <span>'.$offre['prenom'].' '.$offre['nom'].'</span></p>
                <p><i class="fa-solid fa-user-tie"></i> <span>'.$offre['idoffre'].'</span></p>
                <a href="postuler.php?idoffre='.$offre['idoffre'].'" class="btn btn-success mt-3 mb-3" type="submit" name="postuler">Postuler</a>

            </div>
        </div>
 
        ';

    }
    ?>
    
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
