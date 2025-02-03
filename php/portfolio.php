<?php
// Includo il file della classe SiteManager
require_once 'SiteManager.php';

// Creo un alias per la classe SiteManager come SM
use SiteManager as SM;

// Istanzio l'oggetto SM
$sm = new SM();

// Ottengo i progetti utilizzando il metodo getProjects()
$projects = $sm->getProjects();
?>

<section class="portfolio" id="portfolio">
    <h2 class="title-port" id="title-port">Portfolio</h2>
    <div class="conteiner-portfolio" id="conteiner-portfolio">
        <!-- ripeto i progetti e li visualizzo -->
        <?php foreach ($projects as $project) : ?>
            <div class="card">
                <div class="card-inner">
                    <div class="card-front">
                        <img class="img-work" src="<?php echo htmlspecialchars($project['image']); ?>" 
                             alt="<?php echo htmlspecialchars($project['title']); ?>">
                    </div>
                    <div class="card-back">
                        <a class="div-spam" href="<?php echo htmlspecialchars($project['link']); ?>" 
                           title="Vai a <?php echo htmlspecialchars($project['title']); ?>" role="button">
                            <h4><?php echo htmlspecialchars($project['title']); ?></h4>
                            <p>View More...</p>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="conteiner-botton">
            <a href="contattami.php" class="botton" title="Contattami">
                Contattami <img src="../media/send.png" alt="Simbolo Send" style="width: 24px;">
            </a>
        </div>
    </div>
</section>