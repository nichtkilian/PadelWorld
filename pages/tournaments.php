<?php
session_start();

// Ist jemand eingeloggt? (wir verwenden überall $_SESSION['user'])
$logged_in = !empty($_SESSION['user']);

// Turniere definieren (statisch)
$tournaments = [
    [
        'id' => 1,
        'title' => 'Nikolo Masters',
        'date' => '6. Dezember',
        'location' => 'PadelWorld Center',
        'description' => 'Offenes Turnier für Spieler:innen mit fortgeschrittener Spielstärke – ideal, um Erfahrung im Turniermodus zu sammeln.',
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

// Anmeldungen in der Session speichern (kein DB nötig)
if (!isset($_SESSION['tournament_registrations'])) {
    $_SESSION['tournament_registrations'] = [];
}

$success_tournament = '';
$error_tournament   = '';

// Formular abgeschickt?
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tournament_id'])) {

    $tournament_id = (int)$_POST['tournament_id'];

    // Prüfen, ob eingeloggt
    if (empty($_SESSION['user'])) {
        $error_tournament = 'Du musst eingeloggt sein, um dich für ein Turnier anzumelden.';
    } else {
        // Schon angemeldet?
        if (in_array($tournament_id, $_SESSION['tournament_registrations'], true)) {
            $error_tournament = 'Du bist für dieses Turnier bereits angemeldet.';
        } else {
            $_SESSION['tournament_registrations'][] = $tournament_id;
            $success_tournament = 'Du hast dich erfolgreich für das Turnier angemeldet.';
        }
    }
}

include '../includes/header.php';
?>

<h1 class="h4 mb-3">Turniere</h1>
<p class="text-muted mb-4">
    Wähle ein Turnier aus und melde dich an. Eine Anmeldung ist nur möglich, wenn du eingeloggt bist.
</p>

<?php if ($success_tournament): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($success_tournament) ?>
    </div>
<?php endif; ?>

<?php if ($error_tournament): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($error_tournament) ?>
    </div>
<?php endif; ?>

<div class="row g-3">
    <?php foreach ($tournaments as $tournament): ?>
        <?php
        $already_registered = in_array($tournament['id'], $_SESSION['tournament_registrations'], true);
        $logged_in = !empty($_SESSION['user']); // zur Sicherheit pro Request
        ?>
        <div class="col-md-4">
            <div class="card h-100">
                <?php if (!empty($tournament['image'])): ?>
                    <img src="../img/<?= htmlspecialchars($tournament['image']) ?>"
                         class="card-img-top"
                         alt="<?= htmlspecialchars($tournament['title']) ?>">
                <?php endif; ?>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($tournament['title']) ?></h5>
                    <p class="text-muted small mb-2">
                        <?= htmlspecialchars($tournament['date']) ?> ·
                        <?= htmlspecialchars($tournament['location']) ?>
                    </p>
                    <p class="card-text flex-grow-1">
                        <?= htmlspecialchars($tournament['description']) ?>
                    </p>

                    <form method="post" class="mt-2">
                        <input type="hidden" name="tournament_id"
                               value="<?= (int)$tournament['id'] ?>">

                        <?php if ($already_registered): ?>
                            <button type="submit" class="btn btn-success w-100" disabled>
                                Bereits angemeldet
                            </button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-primary w-100">
                                Jetzt anmelden
                            </button>
                        <?php endif; ?>
                    </form>

                    <?php if (!$logged_in): ?>
                        <p class="text-muted small mt-2 mb-0">
                            Du bist aktuell nicht eingeloggt.
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include '../includes/footer.php'; ?>
