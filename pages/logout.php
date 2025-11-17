<?php
// Session nur starten, wenn noch nicht aktiv
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Alle Session-Daten löschen
$_SESSION = [];
session_destroy();

// Zur Startseite weiterleiten
header("Location: ../pages/index.php");
exit;
