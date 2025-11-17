<?php
// Session nur starten, wenn noch nicht aktiv
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fallback: statische Logins (z.B. Admin)
$staticUsers = [
    "admin" => [
        "password" => "admin123",
        "role" => "admin",
        "name" => "Admin"
    ]
];

$error = "";
$filePath = "../data/users.txt";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $loginInput = trim($_POST["email"] ?? "");   // Feld heißt noch "email"
    $password   = $_POST["password"] ?? "";

    if ($loginInput === "" || $password === "") {
        $error = "Bitte E-Mail/Benutzername und Passwort eingeben.";
    } else {

        $loggedIn = false;

      // 1) Zuerst: statische User (z.B. admin) prüfen
if (isset($staticUsers[$loginInput]) && $staticUsers[$loginInput]["password"] === $password) {

    $_SESSION["user"] = [
        "username" => $loginInput,
        "role"     => $staticUsers[$loginInput]["role"],
        "name"     => $staticUsers[$loginInput]["name"]
    ];
    $loggedIn = true;

} else {

            // 2) Sonst: registrierte User aus users.txt prüfen (Login per E-Mail)
            if (file_exists($filePath)) {
                $handle = fopen($filePath, "r");
                if ($handle) {
                    while (($line = fgets($handle)) !== false) {
                        $line = trim($line);
                        if ($line === "") {
                            continue;
                        }

                        // name;email;phone;level;member_since;password
                        $parts = explode(";", $line);

                        $name         = $parts[0] ?? "";
                        $email        = $parts[1] ?? "";
                        $phone        = $parts[2] ?? "";
                        $level        = $parts[3] ?? "";
                        $memberSince  = $parts[4] ?? "";
                        $filePassword = $parts[5] ?? "";

                        // Vergleich E-Mail (case-insensitive) + Passwort
                        if (strcasecmp($email, $loginInput) === 0 && $filePassword === $password) {

                         $_SESSION["user"] = [
                         "username"     => $email,
                          "role"         => "user",
                         "name"         => $name,
                         "email"        => $email,
                            "phone"        => $phone,
                         "level"        => $level,
                        "member_since" => $memberSince
    ];

    // WICHTIG: auch hier user_id setzen (z.B. E-Mail als ID)
    $_SESSION["user_id"] = $email;

    $loggedIn = true;
    break;
}

                    }
                    fclose($handle);
                }
            }
        }

        if ($loggedIn) {
            // Nach erfolgreichem Login weiterleiten (z.B. Startseite)
            header("Location: ../pages/index.php");
            exit;
        } else {
            $error = "Benutzer nicht gefunden oder Passwort falsch.";
        }
    }
}

include '../includes/header.php';
?>

<h1 class="h4 mb-3 text-center">Login</h1>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="login.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-Mail oder Benutzername</label>
                        <input
                            type="text"
                            id="email"
                            name="email"
                            class="form-control"
                            required
                        >
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
                    <button type="submit" class="btn btn-primary w-100">
                        Einloggen
                    </button>
                </form>

                <p class="mt-3 mb-0 text-center small">
                    Noch kein Konto? <a href="register.php">Jetzt registrieren</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
