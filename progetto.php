<?php
// Includo il file della classe SiteManager
require_once 'SiteManager.php';

// Creo un alias per la classe SiteManager come SM
use SiteManager as SM;

// Istanzio l'oggetto SM
$sm = new SM();
$projectId = isset($_GET['id']) ? $_GET['id'] : null;
$project = $sm->getProjectInfo($projectId);
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.min.css">
    <script>
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
    <!-- Titolo della pagina ottenuto dai dati json tramite url -->
    <title><?php echo htmlspecialchars($project['title'] ?? 'Progetto non trovato'); ?></title>
</head>

<body>
    <header class="header">
        <a href="#top" title="To Top" class="logo">MB</a>
        <nav>
            <div id="menuToggle">
                <input type="checkbox" id="menuCheckbox">
                <span></span>
                <span></span>
                <span></span>
                <ul id="menu">
                    <!-- Genero il menu dinamicamente utilizzando il metodo getMenuItems() -->
                    <?php foreach ($sm->getMenuItemsPortfolio() as $menuItem): ?>
                        <li>
                            <a href="<?php echo htmlspecialchars($menuItem['href']); ?>"
                                title="Go to <?php echo htmlspecialchars($menuItem['label']); ?>"
                                onclick="document.getElementById('menuCheckbox').checked = false;">
                                <?php echo htmlspecialchars($menuItem['label']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>
    </header>

    <main class="contenier-page">
        <!-- Sezione principale del progetto -->
        <section id="project">
            <?php if ($project): ?>
                <!-- Titolo, immagine e descrizione ottenuti dal metodo getProjectInfo() -->
                <h2 class="title-project" id="title-project"> <?php echo htmlspecialchars($project['title']); ?> </h2>
                <div class="conteiner-project" id="conteiner-project">
                    <img class="img-project" id="img-project" src="<?php echo htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" width="600">
                    <div class="desk" id="desk">
                        <p><?php echo htmlspecialchars($project['description']); ?></p>

                        <div class="conteiner-botton">
                            <a href="contattami.php" class="botton" title="contattami">Contattami
                                <img src="./media/send.png" alt="simbolo send" style="width: 24px;">
                            </a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <p>Progetto non trovato.</p>
            <?php endif; ?>
        </section>

        <!-- Sezione altri progetti -->
        <?php include './portfolio.php'; ?>
    </main>

    <!-- Footer generato dal metodo generateFooter() -->
    <?php echo $sm->generateFooter(); ?>
</body>

</html>