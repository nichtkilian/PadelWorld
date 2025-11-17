<?php
// Session sicherstellen
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nur eingeloggte Nutzer dürfen das Verzeichnis sehen
if (!isset($_SESSION["user"])) {
    header("Location: ../pages/login.php");
    exit;
}

// Benutzerliste aus Datei einlesen
$users = [];
$filePath = "../data/users.txt";

if (file_exists($filePath)) {
    $handle = fopen($filePath, "r");

    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $line = trim($line);

            if ($line === "") {
                continue;
            }

            // name;email;phone;level;member_since
            $parts = explode(";", $line);

            $users[] = [
                "name"         => $parts[0] ?? "",
                "email"        => $parts[1] ?? "",
                "phone"        => $parts[2] ?? "",
                "level"        => $parts[3] ?? "",
                "member_since" => $parts[4] ?? ""
            ];
        }
        fclose($handle);
    }
}

include "../includes/header.php";
?>

<div class="container mt-4">
    <h1>Club-Verzeichnis</h1>
    <p class="text-muted">
        Hier siehst du andere Mitglieder des Padel-Clubs und kannst Trainingspartner finden.
    </p>

    <?php if (empty($users)): ?>
        <p>Es sind noch keine Mitglieder eingetragen.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Mitglied seit</th>
                        <th>Level</th>
                        <th>E-Mail</th>
                        <th>Telefon</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($u["name"]); ?></td>
                        <td><?php echo htmlspecialchars($u["member_since"]); ?></td>
                        <td><?php echo htmlspecialchars($u["level"]); ?></td>
                        <td>
                            <?php if (!empty($u["email"])): ?>
                                <a href="mailto:<?php echo htmlspecialchars($u["email"]); ?>">
                                    <?php echo htmlspecialchars($u["email"]); ?>
                                </a>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($u["phone"]); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include "../includes/footer.php"; ?>
