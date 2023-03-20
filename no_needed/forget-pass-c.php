<?php


// Connexion à la base de données
$host = 'localhost';
$dbname = 'apprecrutement';
$username = 'root';
$password = '';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$err_forget = '';
$success_message = '' ; // initialisation de la variable à une chaîne vide
if (isset($_POST['submit'])) {
    // Récupération de l'email
    $email = $_POST['email'];

    // Requête SQL pour récupérer l'utilisateur correspondant à l'email
    $query = "SELECT * FROM inscrire_candidat WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification de la présence de l'utilisateur dans la base de données
    if ($user_data) {
		  // Génération d'un nouveau mot de passe
		  $new_password = bin2hex(random_bytes(8)); // génère un mot de passe aléatoire de 16 caractères

		  // Enregistrement du nouveau mot de passe dans la base de données
		  $update_query = "UPDATE inscrire_candidat SET passwordd = ? WHERE email = ?";
		  $update_stmt = $pdo->prepare($update_query);
		  $update_stmt->execute([password_hash($new_password, PASSWORD_DEFAULT), $email]);
  
		  // Envoi d'un e-mail à l'utilisateur avec le nouveau mot de passe
		  $to = $email;
		  $subject = "Réinitialisation de votre mot de passe";
		  $message = "Bonjour,\n\nVotre mot de passe a été réinitialisé. Votre nouveau mot de passe est : $new_password\n\nCordialement,\nL'équipe de votre site web.";
		  $headers = "From: webmaster@example.com\r\n";
		  mail($to, $subject, $message, $headers);
  
		  // Affichage d'un message de succès
		  $success_message = "Un nouveau mot de passe a été envoyé à l'adresse e-mail associée à votre compte.";

			// L'utilisateur existe dans la base de données, on peut continuer le processus de récupération de mot de passe
	}
		else {
			// Affichage d'un message d'erreur si l'email n'existe pas
			$err_forget = "L'adresse e-mail fournie ne correspond à aucun compte.";
			
		}
    } 

?>



<!DOCTYPE html>
<html>
<head>
	<title>Récupération de mot de passe</title>
	<!-- Inclure les fichiers CSS et JS de Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<style>
		/* Ajouter du style personnalisé */
		body {
			background-color: #f8f9fa;
		}
		.form-container {
        
			margin-top: 50px;
			max-width: 500px;
			padding: 24px;
			background-color: #fff;
			box-shadow: 0px 0px 10px #ccc;
			border-radius: 5px;
            margin-top : 140px ;
		}
		.form-group label {
			font-weight: bold;
			margin-bottom: 10px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<div class="form-container">
					<h2 class="text-center">Recuperation de mot de passe</h2>
					<p class="text-muted">Entrez l'adresse e-mail associee a votre compte pour reinitialiser votre mot de passe.</p>
					<form method="POST">
						<div class="form-group">
							<label for="email">Adresse e-mail</label>
							<input type="email" class="form-control" id="email" name="email" required>
						</div>
					
       <div style="width:100% ; height : 6px  ; font-size : 12px ; color : red ; font-weight : 500 ;"> <?php echo $err_forget ; 
	   echo  $success_message ; ?> 
	  </div> 
                                                      
						<div class="form-group text-center">
							<button type="submit" class="btn btn-primary mt-5 w-25" name="submit" >Envoyer</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
