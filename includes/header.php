<?php
// wegen vermeidung doppelter sessions (header)
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>PadelWorld</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body  class="bg-dark text-light d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-black border-bottom border-secondary shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="../pages/index.php">
            <img src="../img/padel-logo.png"
                 alt="PadelWorld Logo"
                 class="navbar-logo me-2">
            <span class="fw-bold">PadelWorld</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNavbar" aria-controls="mainNavbar"
                aria-expanded="false" aria-label="Navigation umschalten">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="../pages/index.php">Startseite</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/about.php">Über uns</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/tournaments.php">Turniere</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/clubverzeichnis.php">Club-Verzeichnis</a>
                </li>

            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
<?php
// Prüfen ob User eingeloggt ist
if (isset($_SESSION["user"])) {

    // Wenn Admin → Admin Panel anzeigen
    if ($_SESSION["user"]["role"] === "admin") {
        echo '<li class="nav-item"><a class="nav-link" href="../pages/admin.php">Admin Panel</a></li>';
    }

    // Wenn normaler User → User Dashboard anzeigen
    if ($_SESSION["user"]["role"] === "user") {
        echo '<li class="nav-item"><a class="nav-link" href="../pages/userdashboard.php">Dashboard</a></li>';
    }

    // Profil (sieht jeder eingeloggte User)
    echo '<li class="nav-item"><a class="nav-link" href="../pages/profil.php">Profil</a></li>';

    // Logout
    echo '<li class="nav-item"><a class="nav-link" href="../pages/logout.php">Logout</a></li>';

} else {

    // Nicht eingeloggt → Login + Registrieren anzeigen
    echo '<li class="nav-item"><a class="nav-link" href="../pages/login.php">Login</a></li>';
    echo '<li class="nav-item"><a class="btn btn-outline-light btn-sm ms-lg-2" href="../pages/register.php">Registrieren</a></li>';

}
?>
</ul>

        </div>
    </div>
</nav>

<!-- Hauptbereich -->
 <main class ="flex-grow-1">
<div class="container py-4">
