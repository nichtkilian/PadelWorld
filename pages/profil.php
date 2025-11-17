<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user"])) {
    header("Location: ../pages/login.php");
    exit;
}

$user = $_SESSION["user"];

// Profilbild-Pfad setzen (Standardbild, falls keines vorhanden)
$avatarPath = "../uploads/avatars/" . ($user["avatar"] ?? "default.png");

// Wenn ein Upload passiert ist
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["avatar"])) {

    $file = $_FILES["avatar"];
    $targetDir = "../uploads/avatars/";
    $fileName = time() . "_" . basename($file["name"]);
    $targetPath = $targetDir . $fileName;

    // Datei verschieben
    if (move_uploaded_file($file["tmp_name"], $targetPath)) {

        // In der Session speichern
        $_SESSION["user"]["avatar"] = $fileName;

        // Pfad aktualisieren
        $avatarPath = $targetPath;

        $message = "Profilbild erfolgreich hochgeladen!";
    } else {
        $error = "Fehler beim Upload.";
    }
}

include '../includes/header.php';
?>

<div class="container mt-4">
    <h1>Mein Profil</h1>
    <p class="text-muted">Hier kannst du deine gespeicherten Daten ansehen.</p>

    <div class="card">
        <div class="card-body">

            <a href="profil_bearbeiten.php" class="btn btn-primary mt-3">
            Profil bearbeiten
            </a>


            <!-- Profilbild -->
            <div class="text-center mb-4">
                <img src="<?php echo $avatarPath; ?>"
                     class="rounded-circle"
                     alt="Profilbild"
                     style="width: 150px; height: 150px; object-fit: cover;">

                <form method="post" enctype="multipart/form-data" class="mt-3">
                    <input type="file" name="avatar" class="form-control" required>
                    <button type="submit" class="btn btn-secondary btn-sm mt-2">Bild hochladen</button>
                </form>

                <?php if (!empty($message)) : ?>
                    <div class="alert alert-success mt-3"><?php echo $message; ?></div>
                <?php endif; ?>

                <?php if (!empty($error)) : ?>
                    <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
                <?php endif; ?>
            </div>

            <!-- Daten -->
            <form>

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">E-Mail</label>
                    <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Telefon</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Level</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['level']); ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mitglied seit</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['member_since']); ?>" readonly>
                </div>

            </form>

        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
