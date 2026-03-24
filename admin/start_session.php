<?php
session_start();
session_regenerate_id(true);
include("../config/db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$client_id = isset($_GET['client']) ? intval($_GET['client']) : 0;
$duree     = isset($_GET['duree'])  ? intval($_GET['duree'])  : 1;

// Validation
if ($duree <= 0 || $duree > 10) {
    die("Durée invalide (1–10 heures).");
}

// Vérifier que le client existe
$stmt = $conn->prepare("SELECT id FROM clients WHERE id = ?");
$stmt->bind_param("i", $client_id);
$stmt->execute();
if ($stmt->get_result()->num_rows === 0) {
    die("Client invalide.");
}

// Calcul des horaires
$heure_debut = date('Y-m-d H:i:s');
$heure_fin   = date('Y-m-d H:i:s', strtotime("+{$duree} hour"));

// Insertion sécurisée
$stmt = $conn->prepare("
    INSERT INTO sessions (client_id, heure_debut, heure_fin, duree, statut)
    VALUES (?, ?, ?, ?, 'en cours')
");
$stmt->bind_param("issi", $client_id, $heure_debut, $heure_fin, $duree);
$stmt->execute();

header("Location: sessions.php");
exit();
?>
