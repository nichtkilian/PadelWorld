<?php
// Session nur starten, wenn noch nicht aktiv
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$errors = [];
$success = false;

$name = "";
$email = "";
$phone = "";
$level = "";
$password = "";
$password_repeat = "";

$filePath = "../data/users.txt";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Formulardaten auslesen
    $name            = trim($_POST["name"] ?? "");
    $email           = trim($_POST["email"] ?? "");
    $phone           = trim($_POST["phone"] ?? "");
    $level           = trim($_POST["level"] ?? "");
    $password        = $_POST["password"] ?? "";
    $password_repeat = $_POST["password_repeat"] ?? "";

    // Einfache Validierung
    if ($name === "") {
        $errors[] = "Bitte einen Namen eingeben.";
    }
    if ($email === "") {
        $errors[] = "Bitte eine E-Mail eingeben.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Bitte eine gültige E-Mail eingeben.";
    }
    if ($level === "") {
        $errors[] = "Bitte ein Level auswählen.";
    }
    if ($password === "") {
        $errors[] = "Bitte ein Passwort eingeben.";
    } elseif ($password !== $password_repeat) {
        $errors[] = "Die Passwörter stimmen nicht überein.";
    }

    // Prüfen, ob E-Mail schon existiert
    if (empty($errors) && file_exists($filePath)) {
        $handle = fopen($filePath, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $line = trim($line);
                if ($line === "") {
                    continue;
                }

                $parts = explode(";", $line);
                $existingEmail = $parts[1] ?? "";

                if (strcasecmp($existingEmail, $email) === 0) {
                    $errors[] = "Diese E-Mail ist bereits registriert.";
                    break;
                }
            }
            fclose($handle);
        }
    }

    // Wenn alles OK → neuen User speichern
    if (empty($errors)) {
        $memberSince = date("Y-m-d");

        // Zeile vorbereiten: name;email;phone;level;member_since;password
        $line = $name . ";" .
                $email . ";" .
                $phone . ";" .
                $level . ";" .
                $memberSince . ";" .
                $password . PHP_EOL;

        // Datei anhängen
        $handle = fopen($filePath, "a");
        if ($handle) {
            fwrite($handle, $line);
            fclose($handle);
            $success = true;

            // Felder leeren, damit das Formular zurückgesetzt wirkt
            $name = $email = $phone = $level = "";
        } else {
            $errors[] = "Die Registrierung konnte nicht gespeichert werden.";
        }
    }
}

include '../includes/header.php';
?>

<h1 class="h4 mb-3 text-center">Registrieren</h1>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card">
            <div class="card-body">

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        Registrierung erfolgreich! Du kannst dich jetzt einloggen.
                    </div>
                <?php endif; ?>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $e): ?>
                                <li><?php echo htmlspecialchars($e); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post" action="register.php" novalidate>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control"
                            required
                            value="<?php echo htmlspecialchars($name); ?>"
                        >
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-Mail</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            required
                            value="<?php echo htmlspecialchars($email); ?>"
                        >
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefon (optional)</label>
                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            class="form-control"
                            value="<?php echo htmlspecialchars($phone); ?>"
                        >
                    </div>

                    <div class="mb-3">
                        <label for="level" class="form-label">Level</label>
                        <select id="level" name="level" class="form-select" required>
                            <option value="">Bitte auswählen</option>
                            <option value="Anfänger" <?php if ($level === "Anfänger") echo "selected"; ?>>Anfänger</option>
                            <option value="Fortgeschritten" <?php if ($level === "Fortgeschritten") echo "selected"; ?>>Fortgeschritten</option>
                            <option value="Profi" <?php if ($level === "Profi") echo "selected"; ?>>Profi</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Passwort</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="password_repeat" class="form-label">Passwort wiederholen</label>
                        <input
                            type="password"
                            id="password_repeat"
                            name="password_repeat"
                            class="form-control"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Registrieren
                    </button>
                </form>

                <p class="mt-3 mb-0 text-center small">
                    Bereits ein Konto? <a href="login.php">Jetzt einloggen</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
