<?php
include("../config/db.php");
session_start();
session_regenerate_id(true);

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

function getSingleValue($conn, $query) {
    $result = $conn->query($query);
    return ($result && $row = $result->fetch_assoc()) ? ($row['total'] ?? 0) : 0;
}

$clients      = getSingleValue($conn, "SELECT COUNT(*) as total FROM clients");
$reservations = getSingleValue($conn, "SELECT COUNT(*) as total FROM reservations");
$revenus      = getSingleValue($conn, "SELECT SUM(montant) as total FROM paiements WHERE statut='payé'");
$attente      = getSingleValue($conn, "SELECT COUNT(*) as total FROM paiements WHERE statut='en attente'");

$today = date('Y-m-d');
$stmt  = $conn->prepare("SELECT COUNT(*) as total FROM reservations WHERE date_reservation = ?");
$stmt->bind_param("s", $today);
$stmt->execute();
$res_today = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

$pageTitle = "Dashboard Admin";
include("includes/admin_header.php");
?>

<div class="container py-5">

    <h1 class="fw-bold mb-4 text-primary">
        <i class="bi bi-speedometer2"></i> Dashboard
    </h1>

    <!-- STAT CARDS -->
    <div class="row g-4 mb-5">

        <div class="col-6 col-md-4 col-lg">
            <div class="card text-center border-0 shadow-sm h-100">
                <div class="card-body py-4">
                    <i class="bi bi-people text-primary fs-2"></i>
                    <h6 class="mt-2 text-muted">Clients</h6>
                    <p class="display-6 fw-bold text-primary mb-0"><?= $clients ?></p>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg">
            <div class="card text-center border-0 shadow-sm h-100">
                <div class="card-body py-4">
                    <i class="bi bi-calendar-check text-success fs-2"></i>
                    <h6 class="mt-2 text-muted">Réservations</h6>
                    <p class="display-6 fw-bold text-success mb-0"><?= $reservations ?></p>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg">
            <div class="card text-center border-0 shadow-sm h-100">
                <div class="card-body py-4">
                    <i class="bi bi-cash-stack text-warning fs-2"></i>
                    <h6 class="mt-2 text-muted">Revenus</h6>
                    <p class="fs-4 fw-bold text-warning mb-0"><?= number_format($revenus, 0) ?> FCFA</p>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg">
            <div class="card text-center border-0 shadow-sm h-100">
                <div class="card-body py-4">
                    <i class="bi bi-hourglass-split text-danger fs-2"></i>
                    <h6 class="mt-2 text-muted">En attente</h6>
                    <p class="display-6 fw-bold text-danger mb-0"><?= $attente ?></p>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg">
            <div class="card text-center border-0 shadow-sm h-100">
                <div class="card-body py-4">
                    <i class="bi bi-calendar-day text-info fs-2"></i>
                    <h6 class="mt-2 text-muted">Aujourd'hui</h6>
                    <p class="display-6 fw-bold text-info mb-0"><?= $res_today ?></p>
                </div>
            </div>
        </div>

    </div>

    <!-- QUICK ACTIONS -->
    <div class="d-flex flex-wrap gap-3 justify-content-center">
        <a href="reservations.php" class="btn btn-primary btn-lg">
            <i class="bi bi-calendar-check"></i> Réservations
        </a>
        <a href="paiements.php" class="btn btn-success btn-lg">
            <i class="bi bi-credit-card"></i> Paiements
        </a>
        <a href="sessions.php" class="btn btn-info btn-lg text-white">
            <i class="bi bi-clock-history"></i> Sessions
        </a>
        <a href="logout.php" class="btn btn-danger btn-lg">
            <i class="bi bi-box-arrow-right"></i> Déconnexion
        </a>
    </div>

</div>

<?php include("includes/admin_footer.php"); ?>
