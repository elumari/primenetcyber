<?php
session_start();
session_regenerate_id(true);
include("../config/db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Mettre à jour les sessions expirées
$conn->query("UPDATE sessions SET statut='terminée' WHERE heure_fin <= NOW()");

$sql = "SELECT sessions.*, clients.nom
        FROM sessions
        JOIN clients ON sessions.client_id = clients.id
        ORDER BY sessions.id DESC";

$res       = $conn->query($sql);
$pageTitle = "Sessions - Admin";
include("includes/admin_header.php");
?>

<div class="container py-5">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-bold text-primary mb-0">
            <i class="bi bi-clock-history"></i> Sessions
        </h2>
        <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle shadow-sm">
            <thead class="table-primary">
                <tr>
                    <th>Client</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th class="text-center">Temps restant</th>
                    <th class="text-center">Statut</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($res && $res->num_rows > 0): ?>
                <?php while ($row = $res->fetch_assoc()):
                    $now   = time();
                    $end   = strtotime($row['heure_fin']);
                    $reste = $end - $now;
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['nom']) ?></td>
                    <td><?= htmlspecialchars($row['heure_debut']) ?></td>
                    <td><?= htmlspecialchars($row['heure_fin']) ?></td>
                    <td class="text-center fw-semibold">
                        <?= ($reste > 0) ? gmdate("H:i:s", $reste) : '00:00:00' ?>
                    </td>
                    <td class="text-center">
                        <?php if ($row['statut'] === 'en cours'): ?>
                            <span class="badge bg-success">
                                <i class="bi bi-circle-fill"></i> En cours
                            </span>
                        <?php else: ?>
                            <span class="badge bg-secondary">
                                <i class="bi bi-stop-circle"></i> Terminée
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        Aucune session enregistrée.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include("includes/admin_footer.php"); ?>
