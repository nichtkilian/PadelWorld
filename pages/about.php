<?php include '../includes/header.php'; ?>


<h1 class="h4 mb-3">Über uns</h1>

<p>
    PadelWorld ist ein fiktiver Padel-Club für unser Webprojekt.
    Kommt vorbei uns spielt Padel!
</p>

<div class="row g-4 mt-2">
    <div class="col-md-6">
        <h2 class="h5">Adresse & Öffnungszeiten</h2>
        <p>
            ViscaBarcaStraße 10<br>
            1010 Wien
        </p>
        <p>
            <strong>Öffnungszeiten:</strong><br>
            Mo–Fr: 08:00–22:00<br>
            Sa–So: 09:00–21:00
        </p>
    </div>

    <div class="col-md-6">
        <h2 class="h5">Kontaktformular</h2>

        <div class="card">
            <div class="card-body">
                <form method="post" action="about.php">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name"
                               class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-Mail</label>
                        <input type="email" id="email" name="email"
                               class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Nachricht</label>
                        <textarea id="message" name="message"
                                  class="form-control" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Nachricht senden
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

