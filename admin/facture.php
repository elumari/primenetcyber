<?php
require __DIR__ . '/../vendor/autoload.php';
include("../config/db.php");

use Dompdf\Dompdf;

// Vérification ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("ID de facture invalide.");
}

// Requête sécurisée
$stmt = $conn->prepare("
    SELECT clients.nom, clients.telephone, paiements.montant,
           paiements.mode_paiement, paiements.date_paiement
    FROM paiements
    JOIN reservations ON paiements.reservation_id = reservations.id
    JOIN clients      ON reservations.client_id = clients.id
    WHERE paiements.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    die("Facture introuvable.");
}

// Sécurisation des variables
$nom     = htmlspecialchars($data['nom']);
$tel     = htmlspecialchars($data['telephone']);
$montant = htmlspecialchars($data['montant']);
$mode    = htmlspecialchars($data['mode_paiement']);
$date    = htmlspecialchars($data['date_paiement'] ?? date('Y-m-d'));

// Numéro de facture unique
$numero = "FAC-" . date('Ymd-His') . "-" . $id;

// FIXED: <style> est maintenant EN PREMIER dans le HTML (avant tout <div>)
// L'original avait un <div class='company'> AVANT le bloc <style> — HTML invalide
$html = "
<!DOCTYPE html>
<html lang='fr'>
<head>
<meta charset='UTF-8'>
<style>
    body        { font-family: DejaVu Sans, sans-serif; font-size: 14px; color: #333; }
    .header     { display: flex; justify-content: space-between;
                  border-bottom: 3px solid #007BFF; padding-bottom: 12px; margin-bottom: 20px; }
    .company    { color: #007BFF; font-weight: bold; font-size: 16px; }
    .company span { font-size: 12px; color: #555; display: block; margin-top: 4px; }
    .invoice    { text-align: right; }
    .invoice h2 { color: #007BFF; margin: 0 0 6px; }
    .invoice p  { margin: 2px 0; font-size: 13px; }
    table       { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th          { background: #007BFF; color: white; padding: 10px; text-align: left; }
    td          { border: 1px solid #ddd; padding: 10px; }
    .total      { margin-top: 20px; text-align: right;
                  font-size: 18px; color: #007BFF; font-weight: bold; }
    .footer     { margin-top: 40px; text-align: center; font-size: 12px; color: #777; }
    .badge      { background: #28a745; color: white;
                  padding: 5px 12px; border-radius: 4px; font-size: 13px; }
    .client-info p { margin: 4px 0; }
</style>
</head>
<body>

<div class='header'>
    <div class='company'>
        PrimeNet Cyber Ngaoundéré
        <span>Internet &bull; Impression &bull; Services</span>
    </div>
    <div class='invoice'>
        <h2>FACTURE</h2>
        <p>N° : <strong>$numero</strong></p>
        <p>Date : $date</p>
    </div>
</div>

<div class='client-info'>
    <p><strong>Client :</strong> $nom</p>
    <p><strong>Téléphone :</strong> $tel</p>
</div>

<table>
    <thead>
        <tr>
            <th>Service</th>
            <th>Mode de paiement</th>
            <th>Montant</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Service PrimeNet Cyber</td>
            <td>$mode</td>
            <td>$montant FCFA</td>
        </tr>
    </tbody>
</table>

<div class='total'>TOTAL : $montant FCFA</div>

<div class='footer'>
    Merci pour votre confiance 🙏<br><br>
    <span class='badge'>Paiement confirmé ✔</span>
</div>

</body>
</html>
";

// Génération PDF via Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("facture_$numero.pdf", ["Attachment" => true]);
?>
