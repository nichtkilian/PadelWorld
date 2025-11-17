<?php
// Session & Login-Check
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user'])) {
    header("Location: ../pages/login.php");
    exit;
}

$user = $_SESSION['user'];

// Gleiche Turnier-Liste wie in tournaments.php
$tournaments = [
    [
        'id' => 1,
        'title' => 'Nikolo Masters',
        'date' => '6. Dezember',
        'location' => 'PadelWorld Center',
        'description' => 'Offenes Turnier für Spieler:innen mit ... Spielstärke – ideal, um Erfahrung im Turniermodus zu sammeln.',
        'image' => 'nikolo.png',
    ],
    [
        'id' => 2,
        'title' => 'Weihnachts Doppel',
        'date' => '20. Dezember',
        'location' => 'PadelWorld Center',
        'description' => 'Offenes Turnier für alle Spielstärken – FUN garantiert!',
        'image' => 'doppel.png',
    ],
];

// Turnier-Anmeldungen aus der Session
$registrations = $_SESSION['tournament_registrations'] ?? [];

// Nur die Turniere herausfiltern, für die der User angemeldet ist
$registeredTournaments = array_filter($tournaments, function ($tournament) use ($registrations) {
    return in_array($tournament['id'], $registrations, true);
});

include '../includes/header.php';
?>

<h1 class="h4 mb-3">Dein Dashboard</h1>
<p class="text-muted mb-4">
    Übersicht über deine Profil-Daten, Turnieranmeldungen und (bald) Reservierungen &amp; Ranking.
</p>

<div class="row g-3">

    <!-- Profil-Übersicht -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                Dein Profil
            </div>
            <div class="card-body">
                <p class="mb-1">
                    <strong>Name:</strong>
                    <?= htmlspecialchars($user['name'] ?? '') ?>
                </p>
                <p class="mb-1">
                    <strong>E-Mail:</strong>
                    <?= htmlspecialchars($user['email'] ?? '') ?>
                </p>
                <p class="mb-1">
                    <strong>Telefon:</strong>
                    <?= htmlspecialchars($user['phone'] ?? '–') ?>
                </p>
                <p class="mb-1">
                    <strong>Spielstärke:</strong>
                    <?= htmlspecialchars($user['level'] ?? '–') ?>
                </p>
                <p class="mb-0">
                    <strong>Mitglied seit:</strong>
                    <?= htmlspecialchars($user['member_since'] ?? '–') ?>
                </p>

                <a href="profil.php" class="btn btn-outline-primary btn-sm mt-3">
                    Profil anzeigen / bearbeiten
                </a>
            </div>
        </div>
    </div>

    <!-- Rechte Seite: Turniere + Reservierungen + Ranking -->
    <div class="col-lg-8">

        <!-- Turnieranmeldungen -->
        <div class="card mb-3">
            <div class="card-header">
                Deine Turniere
            </div>
            <div class="card-body">
                <?php if (empty($registeredTournaments)): ?>
                    <p class="mb-0 text-muted">
                        Du bist aktuell für kein Turnier angemeldet.
                        <a href="tournaments.php">Jetzt Turnier auswählen</a>.
                    </p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($registeredTournaments as $tournament): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-semibold">
                                        <?= htmlspecialchars($tournament['title']) ?>
                                    </div>
                                    <small class="text-muted">
                                        <?= htmlspecialchars($tournament['date']) ?>
                                        ·
                                        <?= htmlspecialchars($tournament['location']) ?>
                                    </small>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <!-- Reservierungen + Ranking nebeneinander -->
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        Reservierungen
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-0">
                            Das Reservierungssystem wird im nächsten Milestone umgesetzt.
                            Aktuell sind noch keine Platz-Reservierungen gespeichert.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        Ranking
                    </div>
                    <div class="card-body">
                        <p class="mb-1">
                            <strong>Aktuelle Spielstärke:</strong>
                            <?= htmlspecialchars($user['level'] ?? '–') ?>
                        </p>
                        <p class="text-muted mb-0">
                            Die detaillierte Ranking-Berechnung (Punkte pro Spiel/Turnier)
                            folgt in einem späteren Projekt-Schritt. Momentan dient dein Level
                            als grobe Einstufung.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include '../includes/footer.php'; ?>
