<?php
// Includo il file della classe SiteManager
require_once 'SiteManager.php';

// Creo un alias per la classe SiteManager come SM
use SiteManager as SM;

// Istanzio l'oggetto SM
$sm = new SM();

    // Gestione del form in caso di richiesta POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Valido i dati del form utilizzando il metodo validateForm()
    $errors = $sm->validateForm($_POST);

    // Se ci sono errori, mostro un messaggio all'utente e interrompo l'esecuzione
    if (!empty($errors)) {
        echo "<p>Errore nella compilazione del form:</p><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
        exit;
    }

    // Se non ci sono errori, salvo i dati del form utilizzando il metodo saveFormData()
    $success = $sm->saveFormData($_POST);

    // Mostro un messaggio di conferma
    if ($success) {
        echo "<p>Dati salvati correttamente!</p>";
    } else {
        echo "<p>Errore durante il salvataggio dei dati. Controlla i permessi del file.</p>";
    }
    exit;
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.min.css">
    <!-- Titolo della pagina ottenuto dal metodo getPageName() -->
    <title><?php echo $sm->getPageName(); ?></title>
</head>
<body>
    <header class="header">
        <a href="#top" title="To Top" class="logo">MB</a>
        <nav role="navigation">
            <div id="menuToggle">
                <input type="checkbox" id="menuCheckbox" />
                <span></span>
                <span></span>
                <span></span>
                <ul id="menu">
                    <!-- Genero il menu dinamicamente utilizzando il metodo getMenuItems() -->
                    <?php foreach ($sm->getMenuItemsContattami() as $menuItem): ?>
                        <li>
                            <a href="<?php echo htmlspecialchars($menuItem['href']); ?>" title="Go to <?php echo htmlspecialchars($menuItem['label']); ?>">
                                <label for="menuCheckbox" onclick="this.parentNode.click();"><?php echo htmlspecialchars($menuItem['label']); ?></label>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>
    </header>

    <section class="contact" id="contatti">
        <!-- Titolo della sezione contatti ottenuto dal metodo getBannerInfo() -->
        <h2 class="title-contact" id="title-contact"><?php echo htmlspecialchars($sm->getContactInfo()['title']); ?></h2>
        <div class="conteiner-contact">
            <!-- Form di contatto -->
            <form action="contattami.php" method="post" class="form" novalidate>
                <div class="form__group field">
                    <input class="form__field" type="text" name="nome" id="nome" maxlength="50" required>
                    <span class="bar"></span>
                    <label for="nome" class="form__label">Nome:</label>
                </div>
                <div class="form__group field">
                    <input class="form__field" type="text" name="cognome" id="cognome" maxlength="50" required>
                    <span class="bar"></span>
                    <label for="cognome" class="form__label">Cognome:</label>
                </div>
                <div class="form__group field">
                    <input class="form__field" type="email" name="email" id="email" maxlength="30" required>
                    <span class="bar"></span>
                    <label for="email" class="form__label">Email:</label>
                </div>
                <div class="form__group field">
                    <input class="form__field" type="tel" name="phone" id="phone" pattern="[0-9]{10}" required>
                    <span class="bar"></span>
                    <label for="phone" class="form__label">Numero di telefono:</label>
                </div>
                <div class="form__group field">
                    <textarea class="form__field" name="message" id="message" rows="4" cols="40"></textarea>
                    <span class="bar"></span>
                    <label for="message" class="form__label">Messaggio:</label>
                </div>
                <div class="conteiner-botton">
                    <button type="submit" class="botton">Invia richiesta
                        <img src="../media/send.png" alt="simbolo send" style="width: 24px;">
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Footer generato dal metodo generateFooter() -->
    <?php echo $sm->generateFooter(); ?>
</body>
</html>