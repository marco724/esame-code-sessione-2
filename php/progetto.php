<?php
// Includo il file della classe SiteManager
require_once 'SiteManager.php';

// Creo un alias per la classe SiteManager come SM
use SiteManager as SM;

// Istanzio l'oggetto SM
$sm = new SM();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.min.css">
    <!-- Titolo della pagina ottenuto dal metodo getPageName() -->
    <title><?php echo $sm->getPageName(1); ?></title>
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
                    <?php foreach ($sm->getMenuItemsPortfolio() as $menuItem): ?>
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

    <main class="contenier-page">
        <!-- Sezione principale del progetto -->
        <section id="project">
            <!-- Titolo, immagine e descrizione ottenuti dal metodo getProjectInfo() -->
            <h2 class="title-project" id="title-project"><?php echo htmlspecialchars($sm->getProjectInfo()['title']); ?></h2>
            <div class="conteiner-project" id="conteiner-project">
                <img class="img-project" id="img-project" src="<?php echo htmlspecialchars($sm->getProjectInfo()['image']); ?>" alt="immagine sito BLOG" width="600">
                <div class="desk" id="desk">
                    <p><?php echo htmlspecialchars($sm->getProjectInfo()['description']); ?></p>

                    <div class="conteiner-botton">
                        <a href="contattami.php" class="botton" title="contattami">Contattami 
                            <img src="../media/send.png" alt="simbolo send" style="width: 24px;">
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sezione altri progetti -->
        <?php include 'portfolio.php'; ?>

    <!-- Footer generato dal metodo generateFooter() -->
    <?php echo $sm->generateFooter(); ?>
</body>
</html>