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
    <!-- Titolo della pagina ottenuto dal metodo getSiteName() -->
    <title><?php echo $sm->getSiteName(); ?></title>
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
                    <?php foreach ($sm->getMenuItems() as $menuItem): ?>
                        <li>
                            <a href="#<?php echo htmlspecialchars($menuItem['id']); ?>" title="Go to <?php echo htmlspecialchars($menuItem['label']); ?>">
                                <label for="menuCheckbox" onclick="this.parentNode.click();"><?php echo htmlspecialchars($menuItem['label']); ?></label>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <!-- Sezione di presentazione -->
        <div class="top" id="home">
            <div class="conteiner-pre" id="conteiner-pre">
                <!-- Sottotitolo, titolo e secondo sottotitolo ottenuti dal metodo getBannerInfo() -->
                <h3 class="subtitle-banner"><?php echo htmlspecialchars($sm->getBannerInfo()['subtitle']); ?></h3>
                <h2 class="title-banner" id="title-banner"><?php echo htmlspecialchars($sm->getBannerInfo()['title']); ?></h2>
                <h3 class="subtitle-banner"><?php echo htmlspecialchars($sm->getBannerInfo()['subtitle2']); ?></h3>
            </div>
            <div class="conteiner-botton">
                <a href="#portfolio" title="Go to Portfolio" class="botton">View Portfolio</a>
            </div>
        </div>

        <!-- Sezione Portfolio -->
        <?php include 'portfolio.php'; ?>

        <!-- Sezione About Me -->
        <section class="about" id="Chi sono">
            <!-- Titolo, immagine e descrizione ottenuti dal metodo getAboutInfo() -->
            <h2 class="title-about" id="title-about"><?php echo htmlspecialchars($sm->getAboutInfo()['title']); ?></h2>
            <div class="conteiner-about">
                <img src="<?php echo htmlspecialchars($sm->getAboutInfo()['image']); ?>" alt="Marco Belli" class="myfoto" id="myfoto">
                <p class="MyDescription" id="mydesk"><?php echo htmlspecialchars($sm->getAboutInfo()['description']); ?></p>
            </div>
            <div class="conteiner-botton">
                <!-- Link per scaricare il curriculum -->
                <a href="<?php echo htmlspecialchars($sm->getAboutInfo()['resume']); ?>" download class="botton" title="Download Resume">Download Resume<img src="../media/download.png" alt="Download Symbol" style="width: 24px;"></a>
            </div>
        </section>
    </main>

    <!-- Footer generato dal metodo generateFooter() -->
    <?php echo $sm->generateFooter(); ?>
</body>
</html>