<?php
include("config/db.php");
$pageTitle = "Services - PrimeNet Cyber";
$rootPath  = "";
include("includes/header.php");
?>

<div class="container py-5">
    <h2 class="text-center fw-bold mb-4 text-primary">
        <i class="bi bi-grid-1x2"></i> Nos Services
    </h2>

    <div class="row g-4">
        <?php
        $res = $conn->query("SELECT * FROM services");
        if ($res && $res->num_rows > 0):
            while ($s = $res->fetch_assoc()):
        ?>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-primary">
                        <?= htmlspecialchars($s['nom_service']) ?>
                    </h5>
                    <p class="card-text text-muted">
                        <?= htmlspecialchars($s['description']) ?>
                    </p>
                </div>
            </div>
        </div>
        <?php
            endwhile;
        else:
        ?>
        <div class="col-12">
            <p class="text-center text-muted">Aucun service disponible pour le moment.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include("includes/footer.php"); ?>
