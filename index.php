<?php
$pageTitle = "PrimeNet Cyber Ngaoundéré";
$rootPath  = "";
include("includes/header.php");
?>

<div class="container py-5">

    <!-- HERO -->
    <div class="text-center py-5 bg-white rounded-3 shadow-sm mb-5">
        <h2 class="fw-bold text-primary mb-3">Bienvenue au PrimeNet</h2>
        <p class="text-muted fs-5 mx-auto" style="max-width:600px;">
            Profitez d'un cyber café moderne avec une connexion rapide et des services professionnels fiables.
        </p>
        <a href="reservation.php" class="btn btn-primary btn-lg mt-3">
            <i class="bi bi-rocket-takeoff"></i> Réserver maintenant
        </a>
    </div>

    <!-- SERVICES PREVIEW -->
    <h3 class="text-center fw-semibold mb-4">Nos services</h3>
    <div class="row g-4 justify-content-center">

        <div class="col-6 col-md-3">
            <div class="card text-center h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="fs-1">💻</div>
                    <h5 class="card-title mt-2">Internet</h5>
                    <p class="card-text text-muted small">Connexion rapide et stable</p>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card text-center h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="fs-1">🖨️</div>
                    <h5 class="card-title mt-2">Impression</h5>
                    <p class="card-text text-muted small">Noir &amp; couleur</p>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card text-center h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="fs-1">📄</div>
                    <h5 class="card-title mt-2">Scan</h5>
                    <p class="card-text text-muted small">Numérisation rapide</p>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card text-center h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="fs-1">🎮</div>
                    <h5 class="card-title mt-2">Jeux</h5>
                    <p class="card-text text-muted small">Divertissement PC</p>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include("includes/footer.php"); ?>
