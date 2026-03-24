<?php
include("config/db.php");
$pageTitle = "Tarifs - PrimeNet Cyber";
$rootPath  = "";
include("includes/header.php");
?>

<div class="container py-5">
    <h2 class="text-center fw-bold mb-4 text-primary">
        <i class="bi bi-cash-coin"></i> Nos Tarifs
    </h2>

    <div class="row g-4 justify-content-center">
        <?php
        $sql = "SELECT services.nom_service, tarifs.prix, tarifs.unite
                FROM tarifs
                JOIN services ON tarifs.service_id = services.id";
        $res = $conn->query($sql);

        if ($res && $res->num_rows > 0):
            while ($row = $res->fetch_assoc()):
        ?>
        <div class="col-6 col-md-3">
            <div class="card text-center h-100 shadow-sm border-0">
                <div class="card-body py-4">
                    <h5 class="card-title fw-semibold">
                        <?= htmlspecialchars($row['nom_service']) ?>
                    </h5>
                    <p class="display-6 fw-bold text-primary my-2">
                        <?= htmlspecialchars($row['prix']) ?>
                        <small class="fs-6">FCFA</small>
                    </p>
                    <span class="badge bg-secondary">
                        / <?= htmlspecialchars($row['unite']) ?>
                    </span>
                </div>
            </div>
        </div>
        <?php
            endwhile;
        else:
        ?>
        <div class="col-12">
            <p class="text-center text-muted">Aucun tarif disponible pour le moment.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include("includes/footer.php"); ?>
