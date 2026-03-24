<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $pageTitle ?? 'PrimeNet Cyber Ngaoundéré' ?></title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

<!-- HEADER -->
<header class="bg-primary text-white py-3 position-relative">
    <div class="container d-flex align-items-center justify-content-center">
        <div class="position-absolute start-0 ms-3">
            <img src="<?= $rootPath ?? '' ?>assets/images/log.png"
                 alt="Logo PrimeNet"
                 class="rounded-circle border border-2 border-white"
                 width="70" height="70">
        </div>
        <div class="text-center">
            <h1 class="h4 mb-0 fw-bold">PrimeNet Cyber Ngaoundéré</h1>
            <small>Connexion rapide, services fiables</small>
        </div>
    </div>
</header>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="mainNav">
            <ul class="navbar-nav gap-md-2">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $rootPath ?? '' ?>index.php">
                        <i class="bi bi-house-door"></i> Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $rootPath ?? '' ?>services.php">
                        <i class="bi bi-grid"></i> Services
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $rootPath ?? '' ?>tarifs.php">
                        <i class="bi bi-tag"></i> Tarifs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $rootPath ?? '' ?>reservation.php">
                        <i class="bi bi-calendar-check"></i> Réservation
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $rootPath ?? '' ?>contact.php">
                        <i class="bi bi-envelope"></i> Contact
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
