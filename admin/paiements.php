<?php
session_start();
session_regenerate_id(true);
include("../config/db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT paiements.id, clients.nom, paiements.montant,
               paiements.mode_paiement, paiements.statut
        FROM paiements
        JOIN reservations ON paiements.reservation_id = reservations.id
        JOIN clients      ON reservations.client_id = clients.id
        ORDER BY paiements.id DESC";

$res       = $conn->query($sql);
$pageTitle = "Paiements - Admin";
include("includes/admin_header.php");
?>

<div class="container py-5">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-bold text-primary mb-0">
            <i class="bi bi-credit-card"></i> Paiements
        </h2>
        <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <!-- MESSAGE SUCCÈS -->
    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle-fill"></i> Paiement validé avec succès.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle shadow-sm">
            <thead class="table-primary">
                <tr>
                    <th>Client</th>
                    <th>Montant</th>
                    <th>Mode</th>
                    <th>Statut</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($res && $res->num_rows > 0): ?>
                <?php while ($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nom']) ?></td>
                    <td><?= htmlspecialchars($row['montant']) ?> FCFA</td>
                    <td><?= htmlspecialchars($row['mode_paiement']) ?></td>
                    <td>
                        <?php if ($row['statut'] === 'payé'): ?>
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle"></i> Payé
                            </span>
                        <?php else: ?>
                            <span class="badge bg-danger">
                                <i class="bi bi-clock"></i> En attente
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">

                            <?php if ($row['statut'] !== 'payé'): ?>
                            <!-- FIXED: href avec onclick confirm, pas de <button> dans <a> -->
                            <a href="valider.php?id=<?= $row['id'] ?>"
                               class="btn btn-sm btn-success"
                               onclick="return confirm('Valider ce paiement ?')">
                                <i class="bi bi-check-lg"></i> Valider
                            </a>
                            <?php else: ?>
                            <button class="btn btn-sm btn-secondary" disabled>
                                <i class="bi bi-check-lg"></i> Payé
                            </button>
                            <?php endif; ?>

                            <!-- FIXED: lien direct, pas de <button> dans <a> -->
                            <a href="facture.php?id=<?= $row['id'] ?>"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-receipt"></i> Facture
                            </a>

                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        Aucun paiement trouvé.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include("includes/admin_footer.php"); ?>
