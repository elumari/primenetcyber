<?php
session_start();
session_regenerate_id(true);
include("../config/db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT reservations.id, clients.id AS client_id, clients.nom,
               services.nom_service, reservations.date_reservation
        FROM reservations
        JOIN clients  ON reservations.client_id = clients.id
        JOIN services ON reservations.service_id = services.id";

$res       = $conn->query($sql);
$pageTitle = "Réservations - Admin";
include("includes/admin_header.php");
?>

<div class="container py-5">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-bold text-primary mb-0">
            <i class="bi bi-calendar-check"></i> Réservations
        </h2>
        <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle shadow-sm rounded">
            <thead class="table-primary">
                <tr>
                    <th>Client</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($res && $res->num_rows > 0): ?>
                <?php while ($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nom']) ?></td>
                    <td><?= htmlspecialchars($row['nom_service']) ?></td>
                    <td><?= htmlspecialchars($row['date_reservation']) ?></td>
                    <td class="text-center">
                        <!-- FIXED: form uses GET, button is directly in the form (pas dans <a>) -->
                        <form action="start_session.php" method="GET"
                              onsubmit="return confirm('Démarrer la session pour ce client ?')"
                              class="d-flex align-items-center justify-content-center gap-2">
                            <input type="hidden" name="client" value="<?= $row['client_id'] ?>">
                            <input type="number" name="duree" min="1" max="10" value="1"
                                   class="form-control form-control-sm" style="width:70px;" required>
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="bi bi-play-fill"></i> Démarrer
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        Aucune réservation enregistrée.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include("includes/admin_footer.php"); ?>
