<?php
// Nur Admins dürfen hier rein
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    header("Location: ../pages/login.php");
    exit;
}

// ---------- Benutzer aus users.txt laden ----------
$users = [];
$userFile = "../data/users.txt";

if (file_exists($userFile)) {
    $handle = fopen($userFile, "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if ($line === "") {
                continue;
            }

            // name;email;phone;level;member_since;password(?)
            $parts = explode(";", $line);

            $users[] = [
                'name'         => $parts[0] ?? '',
                'email'        => $parts[1] ?? '',
                'phone'        => $parts[2] ?? '',
                'level'        => $parts[3] ?? '',
                'member_since' => $parts[4] ?? '',
            ];
        }
        fclose($handle);
    }
}

// ---------- Turnier-Daten wie in tournaments.php ----------
$tournaments = [
    [
        'id' => 1,
        'title' => 'Nikolo Masters',
        'date' => '6. Dezember',
        'location' => 'PadelWorld Center',
    ],
    [
        'id' => 2,
        'title' => 'Weihnachts Doppel',
        'date' => '20. Dezember',
        'location' => 'PadelWorld Center',
    ],
];

// Anmeldungen aus der Session (Prototyp)
$registrations = $_SESSION['tournament_registrations'] ?? [];
$registrationCounts = array_count_values($registrations);

// ---------- Admin-Upload für Inhalts-Bilder ----------
$contentUploadMessage = "";
$contentUploadError   = "";

$uploadDir = "../uploads/content/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['content_image'])) {
    if ($_FILES['content_image']['error'] === UPLOAD_ERR_OK) {
        $maxSize = 2 * 1024 * 1024; // 2 MB

        if ($_FILES['content_image']['size'] > $maxSize) {
            $contentUploadError = "Die Datei ist größer als 2 MB.";
        } else {
            // Dateityp prüfen
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime  = finfo_file($finfo, $_FILES['content_image']['tmp_name']);
            finfo_close($finfo);

            $allowedMimes = ['image/jpeg', 'image/png'];
            if (!in_array($mime, $allowedMimes, true)) {
                $contentUploadError = "Es sind nur JPEG- oder PNG-Dateien erlaubt.";
            } else {
                $ext = strtolower(pathinfo($_FILES['content_image']['name'], PATHINFO_EXTENSION));
                $newFileName = "content_" . time() . "_" . bin2hex(random_bytes(4)) . "." . $ext;
                $targetPath  = $uploadDir . $newFileName;

                if (move_uploaded_file($_FILES['content_image']['tmp_name'], $targetPath)) {
                    $contentUploadMessage = "Bild wurde erfolgreich hochgeladen.";
                } else {
                    $contentUploadError = "Beim Speichern der Datei ist ein Fehler aufgetreten.";
                }
            }
        }
    } else {
        $contentUploadError = "Fehler beim Upload (Code " . $_FILES['content_image']['error'] . ").";
    }
}

// Vorhandene Galerie-Bilder auflisten
$galleryImages = [];
if (is_dir($uploadDir)) {
    foreach (glob($uploadDir . "*.{jpg,jpeg,png,JPG,JPEG,PNG}", GLOB_BRACE) as $file) {
        $galleryImages[] = basename($file);
    }
}

include '../includes/header.php';
?>

<h1 class="h4 mb-3">Admin Panel</h1>
<p class="text-muted mb-4">
    Verwaltung von Benutzer:innen, Turnieren, Reservierungen und Inhalten – wie in der Projekt-Spezifikation beschrieben.
</p>

<div class="row g-3">

    <!-- Benutzerverwaltung -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Benutzerverwaltung
            </div>
            <div class="card-body">
                <?php if (empty($users)): ?>
                    <p class="mb-0 text-muted">Es sind derzeit keine registrierten Benutzer vorhanden.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>E-Mail</th>
                                <th>Telefon</th>
                                <th>Spielstärke</th>
                                <th>Mitglied seit</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($users as $u): ?>
                                <tr>
                                    <td><?= htmlspecialchars($u['name']) ?></td>
                                    <td><?= htmlspecialchars($u['email']) ?></td>
                                    <td><?= htmlspecialchars($u['phone']) ?></td>
                                    <td><?= htmlspecialchars($u['level']) ?></td>
                                    <td><?= htmlspecialchars($u['member_since']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-muted small mt-2 mb-0">
                        Im aktuellen Milestone können Admins die registrierten Benutzer einsehen.
                        Bearbeiten/Löschen folgt in einem späteren Schritt.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Turniere + Reservierungen + Inhalte -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                Turnierverwaltung
            </div>
            <div class="card-body">
                <?php if (empty($tournaments)): ?>
                    <p class="mb-0 text-muted">Es sind aktuell keine Turniere angelegt.</p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($tournaments as $t): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-semibold">
                                        <?= htmlspecialchars($t['title']) ?>
                                    </div>
                                    <small class="text-muted">
                                        <?= htmlspecialchars($t['date']) ?>
                                        ·
                                        <?= htmlspecialchars($t['location']) ?>
                                    </small>
                                </div>
                                <span class="badge bg-secondary rounded-pill">
                                    <?= $registrationCounts[$t['id']] ?? 0 ?> Anmeldungen
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <p class="text-muted small mt-2 mb-0">
                        In dieser Prototyp-Version werden Anmeldungen noch in der aktuellen Session
                        gespeichert. Eine echte Turnierverwaltung mit Datenbank folgt später.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card h-100">
            <div class="card-header">
                Reservierungen
            </div>
            <div class="card-body">
                <p class="text-muted mb-0">
                    Hier wird im nächsten Milestone die Verwaltung von Platz-Reservierungen
                    umgesetzt (Erstellen, Bearbeiten, Löschen).
                    Aktuell dient der Bereich als Platzhalter laut Projektplan.
                </p>
            </div>
        </div>
    </div>

    <!-- Inhalte + Bild-Upload -->
    <div class="col-lg-3">
        <div class="card h-100">
            <div class="card-header">
                Inhalte (Bilder-Upload)
            </div>
            <div class="card-body">
                <p class="small">
                    Als Admin kannst du hier Bilder (JPEG/PNG, max. 2&nbsp;MB) für Events,
                    News oder die Club-Galerie hochladen.
                </p>

                <?php if ($contentUploadMessage): ?>
                    <div class="alert alert-success py-1 small">
                        <?= htmlspecialchars($contentUploadMessage) ?>
                    </div>
                <?php endif; ?>

                <?php if ($contentUploadError): ?>
                    <div class="alert alert-danger py-1 small">
                        <?= htmlspecialchars($contentUploadError) ?>
                    </div>
                <?php endif; ?>

                <form method="post" enctype="multipart/form-data" class="mb-3">
                    <div class="mb-2">
                        <input type="file"
                               name="content_image"
                               class="form-control form-control-sm"
                               accept="image/jpeg,image/png"
                               required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        Bild hochladen
                    </button>
                </form>

                <?php if (!empty($galleryImages)): ?>
                    <p class="small mb-1">Bereits hochgeladene Bilder:</p>
                    <div class="row g-1">
                        <?php foreach ($galleryImages as $img): ?>
                            <div class="col-4">
                                <div class="border rounded overflow-hidden bg-dark">
                                    <img src="../uploads/content/<?= htmlspecialchars($img) ?>"
                                         alt="Galeriebild"
                                         class="img-fluid">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted small mb-0">
                        Noch keine Bilder hochgeladen.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<?php include '../includes/footer.php'; ?>
