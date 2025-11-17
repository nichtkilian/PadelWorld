<?php include '../includes/header.php'; ?>

<h1 class="h4 mb-3">Hilfe &amp; FAQ</h1>

<p class="mb-4">
    Hier findest du Antworten auf häufige Fragen rund um PadelWorld und unsere Web-Anwendung.
</p>

<div class="accordion" id="faqAccordion">

    <div class="accordion-item">
        <h2 class="accordion-header" id="faqOneHeading">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faqOne" aria-expanded="true" aria-controls="faqOne">
                Wie kann ich mich registrieren?
            </button>
        </h2>
        <div id="faqOne" class="accordion-collapse collapse show"
             aria-labelledby="faqOneHeading" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
                Klicke in der Navigation auf <strong>Registrieren</strong>, fülle alle Felder aus
                und bestätige das Formular. Deine Daten werden in unserem System gespeichert und
                du kannst dich danach direkt einloggen.
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header" id="faqTwoHeading">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faqTwo" aria-expanded="false" aria-controls="faqTwo">
                Ich kann mich nicht einloggen – was kann ich tun?
            </button>
        </h2>
        <div id="faqTwo" class="accordion-collapse collapse"
             aria-labelledby="faqTwoHeading" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
                Überprüfe zuerst, ob du dich vorher registriert hast und ob du deine
                E-Mail-Adresse und dein Passwort korrekt eingegeben hast. Falls es trotzdem
                nicht funktioniert, wende dich bitte an das PadelWorld-Team vor Ort
                (Kontaktdaten findest du auf der &bdquo;Über uns&ldquo;-Seite).
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header" id="faqThreeHeading">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faqThree" aria-expanded="false" aria-controls="faqThree">
                Wie melde ich mich zu einem Turnier an?
            </button>
        </h2>
        <div id="faqThree" class="accordion-collapse collapse"
             aria-labelledby="faqThreeHeading" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
                Nachdem du eingeloggt bist, kannst du über den Menüpunkt
                <strong>Turniere</strong> alle verfügbaren Turniere sehen.
                Klicke beim gewünschten Turnier auf <em>Anmelden</em>, um deine Teilnahme zu bestätigen.
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header" id="faqFourHeading">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faqFour" aria-expanded="false" aria-controls="faqFour">
                Wie kann ich mein Profil und mein Profilbild ändern?
            </button>
        </h2>
        <div id="faqFour" class="accordion-collapse collapse"
             aria-labelledby="faqFourHeading" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
                Gehe nach dem Login auf <strong>Profil</strong>. Dort kannst du deine Daten
                bearbeiten und ein Profilbild hochladen.
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header" id="faqFiveHeading">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faqFive" aria-expanded="false" aria-controls="faqFive">
                Wer sieht meine Daten?
            </button>
        </h2>
        <div id="faqFive" class="accordion-collapse collapse"
             aria-labelledby="faqFiveHeading" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
                Deine Stammdaten werden für die Verwaltung deines Accounts benötigt.
                Im <strong>Clubverzeichnis</strong> sehen andere Mitglieder ausgewählte
                Informationen (z.&nbsp;B. Name, Spielstärke), damit ihr euch zum Spielen verabreden könnt.
            </div>
        </div>
    </div>



    <div class="accordion-item">
        <h2 class="accordion-header" id="faqSixHeading">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faqSix" aria-expanded="false" aria-controls="faqSix">
                Was sind die Mitgliedschaftsbeiträge?
            </button>
        </h2>
        <div id="faqSix" class="accordion-collapse collapse"
             aria-labelledby="faqSixHeading" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
                Es gibt eine einmalige Einschreibegebühr von 50€. Danach wird man Mitglied und es kommen keine weiteren Mitgliedschaftsbeiträge auf einen zu.
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header" id="faqSevenHeading">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#faqSeven" aria-expanded="false" aria-controls="faqSeven">
                Gibt es eine Mindestvertragsdauer?
            </button>
        </h2>
        <div id="faqSeven" class="accordion-collapse collapse"
             aria-labelledby="faqSevenHeading" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
                Nein, eine Mindestvertragsdauer gibt es nicht. Kündige wann du willst, ganz ohne Mindestdauer!
            </div>
        </div>
    </div>

</div>

<?php include '../includes/footer.php'; ?>
