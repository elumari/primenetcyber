<?php
session_start();
session_regenerate_id(true);
include("../config/db.php");

$error = "";

if (isset($_POST['login'])) {

    $user = htmlspecialchars(trim($_POST['username']));
    $pass = $_POST['password'];

    if (!empty($user) && !empty($pass)) {

        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();

            if (password_verify($pass, $admin['password'])) {
                $_SESSION['admin'] = $admin['username'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Mot de passe incorrect.";
            }
        } else {
            $error = "Utilisateur introuvable.";
        }

    } else {
        $error = "Tous les champs sont obligatoires.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion Admin - PrimeNet</title>
    <!-- FIXED: was "../css/style.css" (chemin incorrect) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">

<div class="card shadow border-0" style="width: 100%; max-width: 420px;">
    <div class="card-body p-4">

        <div class="text-center mb-4">
            <i class="bi bi-shield-lock text-primary" style="font-size: 3rem;"></i>
            <h2 class="fw-bold mt-2">Admin Login</h2>
        </div>

        <?php if ($error): ?>
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle-fill"></i> <?= $error ?>
        </div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Nom d'utilisateur</label>
                <input type="text" name="username" class="form-control"
                       placeholder="admin" required autofocus>
            </div>

            <div class="mb-4">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control"
                       placeholder="••••••••" required>
            </div>

            <button type="submit" name="login" class="btn btn-primary w-100">
                <i class="bi bi-box-arrow-in-right"></i> Se connecter
            </button>

        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
