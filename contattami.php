<?php
// Includo il file della classe SiteManager
require_once './SiteManager.php';

// Creo un alias per la classe SiteManager come SM
use SiteManager as SM;

// Istanzio l'oggetto SM
$sm = new SM();

// Inizializzo variabili per memorizzare i dati inseriti dall'utente
$nome = $cognome = $email = $phone = $message = '';
$errors = [];
$successMessage = '';

// Gestione del form in caso di richiesta POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Valido i dati del form utilizzando il metodo validateForm()
    $errors = $sm->validateForm($_POST);

    // Memorizzo i dati inviati per ripopolarli nel form
    $nome = $_POST['nome'] ?? '';
    $cognome = $_POST['cognome'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $message = $_POST['message'] ?? '';

    // Se non ci sono errori, salvo i dati
    if (empty($errors)) {
        // Verifica se la directory esiste, altrimenti la crea
        $directory = 'data';
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        // Salvataggio dei dati in un file .txt
        $file = fopen($directory . '/form_data.txt', 'a');
        if ($file) {
            fwrite($file, "Nuovo invio:\n");
            foreach ($_POST as $key => $value) {
                fwrite($file, ucfirst($key) . ": " . $value . "\n");
            }
            fwrite($file, "------------------------\n");
            fclose($file);
        }

        $successMessage = "Dati salvati correttamente!";
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.min.css">
    <style>
        .error {
            color: red;
            font-size: 0.9rem;
        }
        .success { color: green; font-size: 1rem; margin: 10px auto; text-align: center; }
    </style>
    <script type="text/javascript">
                (function(w, d) {
                    var loader = function() {
                        var s = d.createElement("script"),
                            tag = d.getElementsByTagName("script")[0];
                        s.src = "https://cdn.iubenda.com/iubenda.js";
                        tag.parentNode.insertBefore(s, tag);
                    };
                    if (w.addEventListener) {
                        w.addEventListener("load", loader, false);
                    } else if (w.attachEvent) {
                        w.attachEvent("onload", loader);
                    } else {
                        w.onload = loader;
                    }
                })(window, document);
            </script>
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
        <h2 class="title-contact">Contattami</h2>
        <div class="conteiner-contact">
        <?php if ($successMessage): ?>
                <p class="success"><?php echo $successMessage; ?></p>
            <?php endif; ?>
            <form action="./contattami.php" method="post" class="form" novalidate>
                <div class="form__group field">
                    <input class="form__field <?php echo isset($errors['nome']) ? 'input-error' : ''; ?>" type="text" name="nome" id="nome" maxlength="50" required value="<?php echo htmlspecialchars($nome); ?>">
                    <label for="nome" class="form__label">Nome:</label>
                    <?php if (isset($errors['nome'])) echo "<p class='error'>{$errors['nome']}</p>"; ?>
                </div>
                <div class="form__group field">
                    <input class="form__field <?php echo isset($errors['cognome']) ? 'input-error' : ''; ?>" type="text" name="cognome" id="cognome" maxlength="50" required value="<?php echo htmlspecialchars($cognome); ?>">
                    <label for="cognome" class="form__label">Cognome:</label>
                    <?php if (isset($errors['cognome'])) echo "<p class='error'>{$errors['cognome']}</p>"; ?>
                </div>
                <div class="form__group field">
                    <input class="form__field <?php echo isset($errors['email']) ? 'input-error' : ''; ?>" type="email" name="email" id="email" maxlength="30" required value="<?php echo htmlspecialchars($email); ?>">
                    <label for="email" class="form__label">Email:</label>
                    <?php if (isset($errors['email'])) echo "<p class='error'>{$errors['email']}</p>"; ?>
                </div>
                <div class="form__group field">
                    <input class="form__field <?php echo isset($errors['phone']) ? 'input-error' : ''; ?>" type="tel" name="phone" id="phone" pattern="[0-9]{10}" required value="<?php echo htmlspecialchars($phone); ?>">
                    <label for="phone" class="form__label">Numero di telefono:</label>
                    <?php if (isset($errors['phone'])) echo "<p class='error'>{$errors['phone']}</p>"; ?>
                </div>
                <div class="form__group field">
                    <textarea class="form__field <?php echo isset($errors['message']) ? 'input-error' : ''; ?>" name="message" id="message" rows="4" cols="40"><?php echo htmlspecialchars($message); ?></textarea>
                    <label for="message" class="form__label">Messaggio:</label>
                    <?php if (isset($errors['message'])) echo "<p class='error'>{$errors['message']}</p>"; ?>
                </div>
                <div class="conteiner-botton">
                    <button type="submit" class="botton">Invia richiesta</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Footer generato dal metodo generateFooter() -->
    <?php echo $sm->generateFooter(); ?>
</body>

</html>