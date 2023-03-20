
<?php
session_start();


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


//------------------------------------------------------------------------------------------------------------------------------------------------|
$errorsinfo=['nom'=>'','prenom'=>'','address'=>'','email'=>'','phonenumber'=>'','sex'=>'','datenaissance'=>'','lieunaissance'=>''];
$nom=$prenom=$address=$email=$phonenumber=$sex=$datenaissance=$lieunaissance='';

$errorsexperience=['posteoccupe'=>'','nomsociete'=>'','datedebut'=>'','datefin'=>''];
$posteoccupe=$nomsociete =$datedebut=$datefin = '';

$errorsformation = ['etablissement'=>'','diplomeobtenu'=>'','datedebut_formation'=>'','datefin_formation'=>'','description'=>''];
$etablissement = $diplomeobtenu = $datedebut_formation = $datefin_formation = $description = '';

$errorcompetence=['competence'=>'','niveau'=>''];
$competence=$niveau='';

$errorlangue=['langue'=>'','niveaulangue'=>''];
$langue=$niveaulangue='';

$errorloisir = ['loisir' => ''] ;
$loisir = '' ;


if(isset($_POST['submit'])) {
    
$nom = $_POST['nom'] ;
$prenom = $_POST['prenom'] ;
$address = $_POST['address'] ;
$email = $_POST['email'] ;
$phonenumber = $_POST['phonenumber'] ;
$sex = $_POST['sex'] ;
$datenaissance = $_POST['datenaissance'] ;
$lieunaissance = $_POST['lieunaissance'] ;

$datedebut = $_POST['datedebut'];
$posteoccupe = $_POST['posteoccupe'];
$nomsociete = $_POST['nomsociete'];
$datefin = $_POST['datefin'];

$etablissement = $_POST['etablissement'];
$diplomeobtenu = $_POST['diplomeobtenu'];
$datedebut_formation = $_POST['datedebut_formation'];
$datefin_formation = $_POST['datefin_formation'];
$description = $_POST['description'];

$loisir=$_POST['loisir'];

$competence=$_POST['competence'];
$niveau=$_POST['niveau'];

$langue=$_POST['langue'];
$niveaulangue=$_POST['niveaulangue'];


// check if required fields are empty
/////////
if (empty($nom)) {
    $errorsinfo['nom'] = "Le champ Nom est obligatoire.";
}
if (empty($prenom)) {
    $errorsinfo['prenom'] = "Le champ Prénom est obligatoire.";
}
if (empty($address)) {
    $errorsinfo['address'] = "Le champ Address est obligatoire.";
}
if (empty($email)) {
    $errorsinfo['email'] = "Le champ Email est obligatoire.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorsinfo['email'] = "Le format de l'adresse email est invalide.";
}
if (empty($phonenumber)) {
    $errorsinfo['phonenumber'] = "Le champ Numéro de téléphone est obligatoire.";
}
if (empty($sex)) {
    $errorsinfo['sex'] = "Le champ Sex est obligatoire.";
} elseif ($sex !== 'Home' && $sex !== 'Femme') {
    $errorsinfo['sex'] = "La valeur du champ Sex est invalide.";
}
if (empty($datenaissance)) {
    $errorsinfo['datenaissance'] = "Le champ Date de naissance est obligatoire.";
} elseif (!strtotime($datenaissance)) {
    $errorsinfo['datenaissance'] = "Le format de la date de naissance est invalide.";
}
if (empty($lieunaissance)) {
    $errorsinfo['lieunaissance'] = "Le champ Lieu de naissance est obligatoire.";
}
////////////////
if(empty($posteoccupe)) {
    $errorsexperience['posteoccupe'] = "Le champ Poste occupé est obligatoire.";
}
if(empty($nomsociete)) {
    $errorsexperience['nomsociete'] = "Le champ Nom de la société est obligatoire.";
}
if(empty($datedebut)) {
    $errorsexperience['datedebut'] = "Le champ Date debut est obligatoire.";
}
if(empty($datefin)) {
    $errorsexperience['datefin'] = "Le champ Date fin est obligatoire.";
} elseif($datefin < $datedebut) { // check if datefin is earlier than datedebut
    $errorsexperience['datefin'] = "La date de fin ne peut pas être antérieure à la date de début.";
}
//////////////
if(empty($etablissement)) {
    $errorsformation['etablissement'] = "Le champ Etablissement est obligatoire.";
}
if(empty($diplomeobtenu)) {
    $errorsformation['diplomeobtenu'] = "Le champ Diplôme obtenu est obligatoire.";
}
if(empty($datedebut_formation)) {
    $errorsformation['datedebut_formation'] = "Le champ Date début est obligatoire.";
} elseif (!strtotime($datedebut_formation)) {
    $errorsformation['datedebut_formation'] = "Le format de la date de début est invalide.";
}
if(empty($datefin_formation)) {
    $errorsformation['datefin_formation'] = "Le champ Date fin est obligatoire.";
} elseif (!strtotime($datefin)) {
    $errorsformation['datefin_formation'] = "Le format de la date de fin est invalide.";
} elseif (strtotime($datedebut_formation) > strtotime($datefin_formation)) {
    $errorsformation['datefin_formation'] = "La date de fin doit être supérieure à la date de début.";
}
if(empty($description)) {
    $errorsformation['description'] = "Le champ Description est obligatoire.";
}
//////////
if(empty($competence)) {
    $errorcompetence['competence'] = "Le champ compétence est requis";
}
if(empty($niveau)) {
    $errorcompetence['niveau'] = "Le champ niveau est requis";
} 

/////////
if(empty($langue)) {
    $errorlangue['langue'] = "Le champ langue est requis";
}
if(empty($niveaulangue)) {
    $errorlangue['niveaulangue'] = "Le champ niveau est requis";
} 



$sql2 = "SELECT id_candidat FROM inscrire_candidat WHERE email = ?";
$id_candidat_stmt = $pdo->prepare($sql2);
$id_candidat_stmt->execute([$email]);
$id_candidat_row = $id_candidat_stmt->fetch();
$id_candidat = $id_candidat_row['id_candidat'];

$_SESSION['id_candidat'] = $id_candidat; 

//if we have any errur :
if(!array_filter($errorsinfo)){
    $sql = "insert into info_personelle (nom, prenom, address, email, phonenumber, sex,datenaissance,lieunaissance , id_candidat)
    values (:nom, :prenom, :address , :email, :phonenumber, :sex , :datenaissance , :lieunaissance , :id_candidat)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nom' => $nom,'prenom' => $prenom, 'address' => $address, 'email' => $email, 'phonenumber' => $phonenumber,
    'sex' => $sex,'datenaissance' => $datenaissance,'lieunaissance' => $lieunaissance , 'id_candidat' => $id_candidat ]) ;
}



if(!array_filter($errorsexperience)) {
    $sql = "insert into experience (posteoccupe, nomsociete, datedebut, datefin , id_candidat)
    values (:posteoccupe, :nomsociete, :datedebut, :datefin ,:id_candidat)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['posteoccupe' => $posteoccupe, 'nomsociete' => $nomsociete, 'datedebut' => $datedebut, 'datefin' => $datefin, 'id_candidat' => $id_candidat]) ;
}
  


if(!array_filter($errorsformation)) {
  $sql = "insert into formation (etablissement, diplomeobtenu, datedebut_formation, datefin_formation ,description , id_candidat)
  values (:etablissement, :diplomeobtenu, :datedebut_formation, :datefin_formation ,:description , :id_candidat)";
 $stmt = $pdo->prepare($sql);
 $stmt->execute(['etablissement' => $etablissement, 'diplomeobtenu' => $diplomeobtenu, 'datedebut_formation' => $datedebut_formation,
  'datefin_formation' => $datefin_formation,'description' => $description , 'id_candidat' => $id_candidat]) ;
}



if(!array_filter($errorcompetence)) {

  $sql = "insert into competence_table (competence, niveau , id_candidat)
  values (:competence, :niveau , :id_candidat)";
   $stmt = $pdo->prepare($sql);
   $stmt->execute(['competence' => $competence , 'niveau' => $niveau , 'id_candidat' => $id_candidat]) ;

}



 if(!array_filter($errorlangue)) {
   $sql = "insert into langue_table (langue, niveaulangue, id_candidat)
    values (:langue, :niveaulangue , :id_candidat)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['langue' => $langue, 'niveaulangue' => $niveaulangue , 'id_candidat' => $id_candidat]) ;
    } 



if(!array_filter($errorloisir)) { 
   $sql = "insert into loisir (loisir , id_candidat)
   values (:loisir , :id_candidat)";
   $stmt = $pdo->prepare($sql);
   $stmt->execute(['loisir' => $loisir , 'id_candidat' => $id_candidat]) ;
   header("Location: CVTOPDF.php");
}

}

?>





<style>
     .btn{
    
     }
</style>

<!DOCTYPE html>
<html lang="en" >
<head>
<meta charset="UTF-8">
<title>CodePen - Login Form - Modal</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons'>
<link rel="stylesheet" href="./style.css">

<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
<link rel="stylesheet" href="css/formulaire.css">
<link rel="stylesheet" href="css/formCv.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
<style>
    .ajouter {
        width : % ;
    }
</style>

</head>
<body>
    
    <!--Informations personnelles-->
    <div class="wrapper">
        <div class="form">
            <div class="headform"><h1 class="title"><i class="fa-solid fa-address-card"></i>Informations personnelles</h1></div>
            
   
            <form action="#" class="myform" method="POST">
                <div class="control-from">
                    <label for="nom">Nom *</label>
                    <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($nom); ?>" >
                    <div class="err">
                        <?php echo $errorsinfo['nom'] ; ?>
                    </div>
                </div>
   
                <div class="control-from">
                    <label for="prenom">Prenom *</label>
                    <input type="text" id="prenom"  name="prenom" value="<?php echo htmlspecialchars($prenom); ?>" >
                    <div class="err">
                        <?php echo $errorsinfo['prenom'] ; ?>
                    </div>
                </div>
   
                <div class="control-from">
                    <label for="address"><i class="fa-solid fa-location-dot"></i><span>Address *</span> </label>
                    <input type="text" id="address" name="address"  placeholder="numéro, rue, ville, pays, code postal" value="<?php echo htmlspecialchars($address); ?>">
                    <div class="err">
                        <?php echo $errorsinfo['address'] ; ?>
                    </div>
                </div>
   
                <div class="control-from">
                    <label for="email"> <i class="fa-solid fa-envelope"></i> <span>Email *</span> </label>
                    <input type="email" id="email" name="email"  placeholder="Ex : prenom.nom@domaine.com" value="<?php echo htmlspecialchars($email); ?>" >
                    <div class="err">
                        <?php echo $errorsinfo['email'] ; ?>
                    </div>
                </div>
                <div class="control-from">
                    <label for="phonenumber"><i class="fa-solid fa-phone"></i><span>Numéro de téléphone</span>  </label>
                    <input type="phone" id="phonenumber" name="phonenumber" value="<?php echo htmlspecialchars($phonenumber); ?>" >
                    <div class="err">
                        <?php echo $errorsinfo['phonenumber'] ; ?>
                    </div>
                </div>
   
                <div class="control-from">
                    <label for="sex"><i class="fa-solid fa-venus-mars"></i><span>Sexe </span> </label>
                    <select id="sex" name="sex" class="form-control select" value="<?php echo htmlspecialchars($sex); ?>">
                      <option  value="Home">Home</option>
                      <option value="Femme">Femme</option>
                    </select>
                    <div class="err">
                        <?php echo $errorsinfo['sex'] ; ?>
                    </div>
                </div>

                <div class="control-from">
                    <label for="datenaissance"><i class="fa-solid fa-calendar-days"></i><span>Date de naissance</span>  </label>
                    <input type="date" id="datenaissance" name="datenaissance"  value="<?php echo htmlspecialchars($datenaissance); ?>" >
                    <div class="err">
                        <?php echo $errorsinfo['datenaissance'] ; ?>
                    </div>
                </div>
   
                <div class="control-from">
                    <label for="lieunaissance"><i class="fa-regular fa-earth-asia"></i><span>Lieu de naissance</span>  </label>
                    <input type="text" id="lieunaissance" name="lieunaissance" value="<?php echo htmlspecialchars($lieunaissance); ?>">
                    <div class="err">
                        <?php echo $errorsinfo['lieunaissance'] ; ?>
                    </div>
                </div>
                
                   
</div>
        </div>
    </div>

    <!--Experiences-->
    <div class="wrapper">
        <div class="form">
            <div class="headform"><h1 class="title"><i class="fa-solid fa-business-time"></i>Expérience professionnelle</h1></div>
            
   
            <div class="myform">
                <div class="control-from">
                    <label for="posteoccupe"><i class="fa-solid fa-briefcase"></i><span> Poste occupé *</span></label>
                    <input type="text" id="posteoccupe" name="posteoccupe" value="<?php echo htmlspecialchars($posteoccupe); ?>">
                    <div class="err">
                        <?php echo $errorsexperience['posteoccupe']; ?>
                    </div>
                </div>
   
                <div class="control-from">
                    <label for="nomsociete"><i class="fa-solid fa-building"></i><span>Nom de la société*</span> </label>
                    <input type="text" id="nomsociete" name="nomsociete" value="<?php echo htmlspecialchars($nomsociete); ?>">
                    <div class="err">
                        <?php echo $errorsexperience['nomsociete'] ; ?>
                    </div>
                </div>

                <div class="control-from">
                    <label for="datedebut"><i class="fa-solid fa-calendar-days"></i><span>Date debut *</span>  </label>
                    <input type="date" id="detadebut" name="datedebut" value="<?php echo htmlspecialchars($datedebut); ?>" >
                    <div class="err">
                        <?php echo $errorsexperience['datedebut'] ; ?>
                    </div>
                </div>
                <div class="control-from">
                    <label for="datefin"><i class="fa-solid fa-calendar-days"></i><span>Date fin *</span>  </label>
                    <input type="date" id="datefin" name="datefin" value="<?php echo htmlspecialchars($datefin); ?>" >
                    <div class="err">
                        <?php echo $errorsexperience['datefin'] ; ?>
                    </div>
                </div>
                             
                  
</div>
        </div>
    </div>


 

    <!--Formation-->
    <div class="wrapper">
        <div class="form">
            <div class="headform"><h1 class="title"><i class="fa-solid fa-graduation-cap"></i>Formation</h1></div>
            
   
            <div  class="myform" >
                <div class="control-from">
                    <label for="etablissement"><i class="fa-solid fa-briefcase"></i><span> Etablissement *</span></label>
                    <input type="text" id="etablissement" name="etablissement" value="<?php echo htmlspecialchars($etablissement); ?>"  placeholder="">
                
                    <div class="err">
                    <?php echo $errorsformation['etablissement'] ; ?>
                    </div>
                </div>
   
                <div class="control-from">
                    <label for="diplomeobtenu"><i class="fa-solid fa-building"></i><span>Diplôme obtenu*</span> </label>
                    <input type="text" id="diplomeobtenu" name="diplomeobtenu" value="<?php echo htmlspecialchars($diplomeobtenu); ?>" >
                   
                    <div class="err">
                    <?php echo $errorsformation['diplomeobtenu']; ?>
                  
                    </div>
                </div>

                <div class="control-from">
                    <label for="datedebut_formation"><i class="fa-solid fa-calendar-days"></i><span>Date debut *</span>  </label>
                    <input type="date" id="datedebut_formation" name="datedebut_formation" value="<?php echo htmlspecialchars($datedebut_formation); ?>">
                 
                    <div class="err">
                    <?php echo $errorsformation['datedebut_formation'] ; ?>
                    </div>
                </div>
                <div class="control-from">
                    <label for="datefin_formation"><i class="fa-solid fa-calendar-days"></i><span>Date fin *</span>  </label>
                    <input type="date" id="datefin_formation" name="datefin_formation"  value="<?php echo htmlspecialchars($datefin_formation); ?>">
                 
                    <div class="err">
                    <?php echo $errorsformation['datefin_formation'] ; ?>
                    </div>
                
                </div>
               <div class="full-width ">
                    <label for="description">Description </label>
                    <textarea type="text" id="description" name="description" class="description" value="" required></textarea>
                </div>
                
                    
</div>
        </div>
    </div>
    <!--Compétences-->
    <div class="wrapper">
        <div class="form">
            <div class="headform"><h1 class="title"><i class="fas fa-chart-bar"></i>Compétences</h1></div>
            
   
            <div class="myform" >
                <div class="control-from">
                    <label for="competence"><i class="fas fa-lightbulb"></i><span> Compétence *</span></label>
                    <input type="text" id="competence" name="competence" value="<?php echo htmlspecialchars($competence); ?>">

                    <div class="err">
                    <?php echo $errorcompetence['competence'] ; ?>
                    </div>
                </div>
   
                <div class="control-from">
                    <label for="niveau"><i class="fas fa-star"></i><span>Niveau *</span> </label>
                    <select id="niveau" class="form-control select" name="niveau">
                      <option  value="Débutant">Débutant</option>
                      <option value="Intermédiaire">Intermédiaire</option>
                      <option value="Expert">Expert</option>
                    </select>
                    <div class="err">
                    <?php echo $errorcompetence['niveau'] ; ?>
                    </div>
                </div>



                
</div>
        </div>
    </div>
    <!--Langues-->
    <div class="wrapper">
        <div class="form">
            <div class="headform"><h1 class="title"><i class="fas fa-language"></i>
                Langues</h1></div>
            
   
            <div class="myform" >
                <div class="control-from">
                    <label for="langue"><i class="fa-regular fa-language"></i><span> Langue *</span></label>
                    <input type="text" id="langue" name="langue" value="<?php echo htmlspecialchars($langue); ?>" >
                    <div class="err">
                     <?php echo     $errorlangue['langue'] ; ?>
                    </div>
                </div>
   
                <div class="control-from">
                    <label for="niveaulangue"><i class="fas fa-star"></i><span>Niveau *</span> </label>
                    <select id="niveaulangue" name="niveaulangue" class="form-control select">
                      <option value="Débutant">Débutant</option>
                      <option value="Intermédiaire">Intermédiaire</option>
                      <option value="Expert">Expert</option>
                    </select>
                    <div class="err">
                    <?php echo     $errorlangue['niveaulangue'] ; ?>
                    </div>
                </div>
   
                
                   
</div>
        </div>
    </div>
    <!--Loisirs-->
    <div class="wrapper">
        <div class="form">
            <div class="headform"><h1 class="title"><i class="fas fa-grin-beam"></i>
                Loisirs</h1></div>
            
   
            <div class="myform">
                <div class="control-from full-width">
                    <label for="loisir"><span> Loisir </span></label>
                    <input type="text" id="loisir" name="loisir"  value="<?php echo htmlspecialchars($loisir); ?>">
                </div>
                <button type="submit" name="submit" class="btn btn-success full-width">Valider</button>
</form>
        </div>
    </div>

   
</body>
</html>
