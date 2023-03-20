<?php
session_start();

$id_candidat = $_SESSION['id_candidat'];

require_once('fpdf.php');
require_once('src/autoload.php');

// Connexion à la base de données
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

// Récupération des données personnelles
$query = "SELECT nom, prenom, address, email, phonenumber, sex, datenaissance, lieunaissance
          FROM info_personelle
          WHERE id_candidat = :id_candidat";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id_candidat', $id_candidat);
$stmt->execute();
$info_personnelle = $stmt->fetch(PDO::FETCH_ASSOC);


// Récupération des expériences professionnelles
$query = "SELECT posteoccupe, nomsociete, datedebut, datefin
          FROM experience
          WHERE id_candidat = :id_candidat";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id_candidat', $id_candidat);
$stmt->execute();
$experiences_professionnelles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des formations
$query = "SELECT etablissement, diplomeobtenu, datedebut_formation, datefin_formation, description
          FROM formation
          WHERE id_candidat = :id_candidat";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id_candidat', $id_candidat);
$stmt->execute();
$formations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des compétences
$query = "SELECT competence, niveau
          FROM competence_table
          WHERE id_candidat = :id_candidat";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id_candidat', $id_candidat);
$stmt->execute();
$competences = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des langues
$query = "SELECT langue, niveaulangue
          FROM langue_table
          WHERE id_candidat = :id_candidat";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id_candidat', $id_candidat);
$stmt->execute();
$langues = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des loisirs
$query = "SELECT loisir
          FROM loisir
          WHERE id_candidat = :id_candidat";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id_candidat', $id_candidat);
$stmt->execute();
$loisirs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Création du document PDF
$pdf = new \setasign\Fpdi\Fpdi();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(184,204,229);
$pdf->SetFillColor(184,204,229);
$pdf->SetTextColor(0,0,0);


// Affichage des nom bro.

$pdf->SetTitle(' '.$info_personnelle['nom'].' '.$info_personnelle['prenom'].' ');
$pdf->SetFont('Arial','B',25);
$pdf->SetDrawColor(80,129,188);
$pdf->SetFillColor(79,129,188);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(0,9,''.$info_personnelle['nom'].' '.$info_personnelle['prenom'].'',1,1,'C',true);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,9,''.$mytitle.'',1,1,'C',true);

$pdf->Ln(4);

//email:

$pdf->SetFont('Arial','B',8);
$pdf->SetDrawColor(79,129,188);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0,9,''.$info_personnelle['email'],1,1,'C',true);

$pdf->Ln(4);




$pdf->SetFont('Arial','',11);
$pdf->SetFont('Arial','B',14);
$pdf->SetDrawColor(184,204,229);
$pdf->SetFillColor(184,204,229);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(80,9,' Profil',1,1,'L',true);
$pdf->SetFont('Arial','',11);


$lieu=  'Lieu: ';

// Affichage des données personnelles

$pdf->Cell(0, 10, utf8_decode($lieu.$info_personnelle['address']), 0, 1);

$pdf->Cell(0, 10, utf8_decode('Email: '.$info_personnelle['email']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Telephone: '.$info_personnelle['phonenumber']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Sex: '.$info_personnelle['sex']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Date de naissance: '.$info_personnelle['datenaissance']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Lieu de naissance: '.$info_personnelle['lieunaissance']), 0, 1);




// Affichage des expériences professionnelles
$pdf->SetFont('Arial','',11);
$pdf->SetFont('Arial','B',14);
$pdf->SetDrawColor(184,204,229);
$pdf->SetFillColor(184,204,229);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0, 10, 'Experiences professionnelles', 0, 1,'L',true);
$pdf->SetFont('Arial','',11);

foreach ($experiences_professionnelles as $experience) {
$pdf->Cell(0, 10, utf8_decode('Poste occupe: '.$experience['posteoccupe']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Nom de  societe: '.$experience['nomsociete']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Duree: '.$experience['datedebut']) . ' - ' . utf8_decode($experience['datefin']), 0, 1);
}



// Affichage des formations
$pdf->SetFont('Arial','',11);
$pdf->SetFont('Arial','B',14);
$pdf->SetDrawColor(184,204,229);
$pdf->SetFillColor(184,204,229);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0, 10, 'Formations', 0, 1,'L',true);
$pdf->SetFont('Arial','',11);
foreach ($formations as $formation) {
$pdf->Cell(0, 10, utf8_decode('Etablissement: '.$formation['etablissement']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Deplome obtenu: '.$formation['diplomeobtenu']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Duree: '.$formation['datedebut_formation']) . ' - ' . utf8_decode($formation['datefin_formation']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Description: '.$formation['description']), 0, 1);
}

// Affichage des compétences
$pdf->SetFont('Arial','',11);
$pdf->SetFont('Arial','B',14);
$pdf->SetDrawColor(184,204,229);
$pdf->SetFillColor(184,204,229);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0, 10, 'Competences', 0, 1,'L',true);
$pdf->SetFont('Arial','',11);
foreach ($competences as $competence) {
$pdf->Cell(0, 10, utf8_decode($competence['competence']) . ' : ' . utf8_decode($competence['niveau']), 0, 1);
}

// Affichage des langues
$pdf->SetFont('Arial','',11);
$pdf->SetFont('Arial','B',14);
$pdf->SetDrawColor(184,204,229);
$pdf->SetFillColor(184,204,229);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0, 10, 'Langues', 0, 1,'L',true);
$pdf->SetFont('Arial','',11);
foreach ($langues as $langue) {
$pdf->Cell(0, 10, utf8_decode($langue['langue']) . ' : ' . utf8_decode($langue['niveaulangue']), 0, 1);
}

// Affichage des loisirs
$pdf->SetFont('Arial','',11);
$pdf->SetFont('Arial','B',14);
$pdf->SetDrawColor(184,204,229);
$pdf->SetFillColor(184,204,229);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0, 10, 'Loisirs', 0, 1,'L',true);
$pdf->SetFont('Arial','',11);
foreach ($loisirs as $loisir) {
$pdf->Cell(0, 10, utf8_decode($loisir['loisir']), 0, 1);
}



// Envoi du document PDF au navigateur
ob_clean(); // vider le tampon de sortie
$pdf->Output('I', 'CV.pdf'); // envoyer le PDF


?>




