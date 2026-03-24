<?php
session_start();
session_regenerate_id(true);
include("../config/db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("ID invalide.");
}

// Vérifier existence et statut
$stmt = $conn->prepare("SELECT id, statut FROM paiements WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Paiement introuvable.");
}

$data = $result->fetch_assoc();

// Si déjà payé, rediriger sans action
if ($data['statut'] === 'payé') {
    header("Location: paiements.php");
    exit();
}

// Mise à jour du statut
$stmt = $conn->prepare("UPDATE paiements SET statut = 'payé' WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: paiements.php?success=1");
exit();
?>
