<?php
session_start();
session_regenerate_id(true);
include("config/db.php");

$message_success = "";

if (isset($_POST['submit'])) {

    $nom     = htmlspecialchars(trim($_POST['nom']));
    $tel     = preg_replace('/[^0-9]/', '', $_POST['telephone']);
    $service = intval($_POST['service']);
    $date    = $_POST['date'];
    $heure   = $_POST['heure'];
    $duree   = intval($_POST['duree']);
    $mode    = htmlspecialchars($_POST['mode_paiement']);

    if ($nom && $tel && $service && $date && $heure && $duree > 0) {

        // Ajouter client
        $stmt = $conn->prepare("INSERT INTO clients (nom, telephone) VALUES (?, ?)");
        $stmt->bind_param("ss", $nom, $tel);
        $stmt->execute();
        $client_id = $stmt->insert_id;

        // Récupérer prix
        $stmt = $conn->prepare("SELECT prix FROM tarifs WHERE service_id = ?");
        $stmt->bind_param("i", $service);
        $stmt->execute();
        $prix_data = $stmt->get_result()->fetch_assoc();
        $montant   = $prix_data['prix'] * $duree;

        // Ajouter réservation
        $stmt = $conn->prepare("
            INSERT INTO reservations (client_id, service_id, date_reservation, heure_debut, duree)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("iissi", $client_id, $service, $date, $heure, $duree);
        $stmt->execute();
        $reservation_id = $stmt->insert_id;

        // Ajouter paiement
        $stmt = $conn->prepare("
            INSERT INTO paiements (reservation_id, montant, mode_paiement, statut)
            VALUES (?, ?, ?, 'en attente')
        ");
        $stmt->bind_param("ids", $reservation_id, $montant, $mode);
        $stmt->execute();

        $message_success = "Réservation enregistrée avec succès !";

        // WhatsApp
        $msg = urlencode("Bonjour $nom 👋\nVotre réservation est confirmée ✅\n\n📅 Date: $date\n⏰ Heure: $heure\n💻 Durée: $duree heure(s)\n\nMerci 🙏");
        echo "<script>window.open('https://wa.me/237$tel?text=$msg', '_blank');</script>";
    }
}

$pageTitle = "Réservation - PrimeNet Cyber";
$rootPath  = "";
include("includes/header.php");
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-body p-4">

                    <h2 class="card-title text-primary fw-bold mb-4">
                        <i class="bi bi-calendar-plus"></i> Réserver un poste
                    </h2>

                    <?php if ($message_success): ?>
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill"></i> <?= $message_success ?>
                    </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Nom complet</label>
                            <input type="text" name="nom" class="form-control"
                                   placeholder="Votre nom" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="telephone" class="form-control"
                                   placeholder="6XXXXXXXX" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Service</label>
                            <select name="service" class="form-select" required>
                                <?php
                                $res = $conn->query("SELECT * FROM services");
                                while ($s = $res->fetch_assoc()) {
                                    echo "<option value='" . $s['id'] . "'>"
                                       . htmlspecialchars($s['nom_service'])
                                       . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Heure de début</label>
                            <input type="time" name="heure" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Durée (heures)</label>
                            <input type="number" name="duree" class="form-control"
                                   min="1" placeholder="ex: 2" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Mode de paiement</label>
                            <select name="mode_paiement" class="form-select">
                                <option value="cash">Cash</option>
                                <option value="MTN Mobile Money">MTN Mobile Money</option>
                                <option value="Orange Money">Orange Money</option>
                            </select>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary w-100">
                            <i class="bi bi-rocket-takeoff"></i> Valider la réservation
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
