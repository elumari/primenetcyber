<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host     = "sql311.infinityfree.com";
$user     = "if0_41468799";
$password = "4F756D6172";
$dbname   = "if0_41468799_cyber";

try {
    $conn = new mysqli($host, $user, $password, $dbname);
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    error_log("Erreur DB : " . $e->getMessage());
    die("Erreur serveur. Veuillez réessayer plus tard.");
}
?>
