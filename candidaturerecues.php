<?php
session_start() ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Liste des candidatures</title>
  <!-- Liens vers les fichiers CSS de Bootstrap et Font Awesome -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  
  <style>
    /* Style personnalisé pour les icônes */
    .fa-fw {
      width: 1.5em;
    }

  </style>
</head>
<body>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card mt-5">
          <div class="card-header bg-primary text-white">
            <i class="fas fa-users fa-fw mr-2"></i>Liste des candidatures
          </div>
          <div class="card-body">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Nom</th>
                  <th>Prénom</th>
                  <th>Email</th>
                  <th>Titre de l'offre</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $id_recruteur = $_SESSION['id_recruteur']; 
                $host = 'localhost';
                $dbname = 'apprecrutement';
                $username = 'root';
                $password = '';
                $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

             
                $sql = "SELECT c.nom, c.prenom, c.email , o.titre
                        FROM candidature c 
                        JOIN poste_offre o ON c.idoffre = o.idoffre 
                        WHERE o.id_recruteur = :id_recruteur";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id_recruteur', $id_recruteur);
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($rows as $row) {
                  echo "<tr>";
                  echo "<td>" . $row['nom'] . "</td>";
                  echo "<td>" . $row['prenom'] . "</td>";
                  echo "<td>" . $row['email'] . "</td>";
                  echo "<td>" . $row['titre'] . "</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Liens vers les fichiers JS de Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
