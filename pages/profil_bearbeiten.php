<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// nur eingeloggte User
if (!isset($_SESSION["user"])) {
    header("Location: ../pages/login.php");
    exit;
}

$user = $_SESSION["user"];

$name  = $user["name"];
$email = $user["email"];
$phone = $user["phone"];
$level = $user["level"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // neue Werte aus Formular
    $name  = $_POST["name"]  ?? "";
    $email = $_POST["email"] ?? "";
    $phone = $_POST["phone"] ?? "";
    $level = $_POST["level"] ?? "";

    // users.txt einlesen
    $filePath = "../data/users.txt";
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // passende Zeile suchen und ersetzen
    foreach ($lines as $i => $line) {
        $parts = explode(";", $line);
        // name;email;phone;level;member_since;password
        $fileEmail = $parts[1] ?? "";

        if ($fileEmail === $user["email"]) {
            // member_since und password unverändert lassen
            $memberSince = $parts[4] ?? "";
            $password    = $parts[5] ?? "";

            $newLine = $name . ";" .
                       $email . ";" .
                       $phone . ";" .
                       $level . ";" .
                       $memberSince . ";" .
                       $password;

            $lines[$i] = $newLine;
            break;
        }
    }

    // Datei neu schreiben
    file_put_contents($filePath, implode(PHP_EOL, $lines) . PHP_EOL);

    // Session updaten
    $_SESSION["user"]["name"]  = $name;
    $_SESSION["user"]["email"] = $email;
    $_SESSION["user"]["phone"] = $phone;
    $_SESSION["user"]["level"] = $level;

    // zurück zum Profil
    header("Location: profil.php");
    exit;
}

include "../includes/header.php";
?>

<div class="container mt-4">
    <h1>Profil bearbeiten</h1>

    <div class="card">
        <div class="card-body">
            <form method="post" action="profil_bearbeiten.php">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="<?php echo htmlspecialchars($name); ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-Mail</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        value="<?php echo htmlspecialchars($email); ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Telefon</label>
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
                    <select id="level" name="level" class="form-select">
                        <option value="">Bitte auswählen</option>
                        <option value="Anfänger"        <?php if ($level === "Anfänger") echo "selected"; ?>>Anfänger</option>
                        <option value="Fortgeschritten" <?php if ($level === "Fortgeschritten") echo "selected"; ?>>Fortgeschritten</option>
                        <option value="Profi"           <?php if ($level === "Profi") echo "selected"; ?>>Profi</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Speichern</button>
                <a href="profil.php" class="btn btn-secondary ms-2">Abbrechen</a>
            </form>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
