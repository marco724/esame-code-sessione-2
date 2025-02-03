<?php

class SiteManager {
    // Percorso del file JSON che contiene i dati del sito
    private $jsonFile = '../json/data.json';
    
    // Array per memorizzare i dati caricati dal file JSON
    private $data = [];

    // Costruttore della classe: carica i dati dal file JSON all'istanziazione
    public function __construct() {
        $this->loadData();
    }

    // Metodo privato per caricare i dati dal file JSON
    private function loadData() {
        // Verifica se il file JSON esiste
        if (file_exists($this->jsonFile)) {
            // Legge il contenuto del file JSON
            $jsonData = file_get_contents($this->jsonFile);
            // Decodifica il JSON in un array associativo
            $this->data = json_decode($jsonData, true);
        } else {
            // Se il file non esiste, termina l'esecuzione con un messaggio di errore
            die("Errore: File JSON non trovato!");
        }
    }

    // Metodo per ottenere il nome della pagina (utilizzato nel titolo della pagina)
    public function getPageName($index = 0) {
        // Restituisce il nome della pagina all'indice specificato, con escape HTML per sicurezza
        return htmlspecialchars($this->data['siteInfo']['pagename'][$index] ?? '');
    }

    // Metodo per ottenere il nome del sito
    public function getSiteName() {
        // Restituisce il nome del sito, con escape HTML per sicurezza
        return htmlspecialchars($this->data['siteInfo']['siteName'] ?? '');
    }

    // Metodo per ottenere gli elementi del menu
    public function getMenuItemsPortfolio($menuKey = 'progetto') {
        // Restituisce gli elementi del menu specificati dalla chiave $menuKey (default: 'progetto')
        return $this->data[$menuKey] ?? [];
    }

    // Metodo per ottenere gli elementi del menu
    public function getMenuItemsContattami($menuKey = 'contatti') {
        // Restituisce gli elementi del menu specificati dalla chiave $menuKey (default: 'contatti')
        return $this->data[$menuKey] ?? [];
    }

    // Metodo per ottenere gli elementi del menu
    public function getMenuItems($menuKey = 'menu') {
        // Restituisce gli elementi del menu specificati dalla chiave $menuKey (default: 'menu')
        return $this->data['siteInfo'][$menuKey] ?? [];
    }
    // Metodo per ottenere le informazioni del banner
    public function getBannerInfo() {
        // Restituisce le informazioni del banner
        return $this->data['siteInfo']['banner'] ?? [];
    }

    // Metodo per ottenere le informazioni di contatto
    public function getContactInfo() {
        // Restituisce le informazioni di contatto
        return $this->data['siteInfo']['contact'] ?? [];
    }

    // Metodo per ottenere le informazioni della sezione "About"
    public function getAboutInfo() {
        // Restituisce le informazioni della sezione "About"
        return $this->data['siteInfo']['about'] ?? [];
    }

    // Metodo per ottenere i progetti (limita il numero di progetti restituiti)
    public function getProjects($numProgetti = 12) {
        // Restituisce un sottoinsieme di progetti (default: primi 12 progetti)
        $projects = $this->data['siteInfo']['projects'] ?? [];
        return array_slice($projects, 0, $numProgetti);
    }

    // Metodo per ottenere le informazioni del progetto principale
    public function getProjectInfo() {
        // Restituisce le informazioni del progetto principale
        return $this->data['siteInfo']['project'] ?? [];
    }

    // Metodo per validare i dati del form di contatto
    public function validateForm($postData) {
        $errors = [];

        // Verifica se il campo "nome" è vuoto
        if (empty($postData['nome'])) {
            $errors['nome'] = 'Il nome è obbligatorio.';
        }

        // Verifica se il campo "cognome" è vuoto
        if (empty($postData['cognome'])) {
            $errors['cognome'] = 'Il cognome è obbligatorio.';
        }

        // Verifica se il campo "email" è vuoto o non valido
        if (empty($postData['email']) || !filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Inserisci un indirizzo email valido.';
        }

        // Verifica se il campo "phone" è vuoto o non valido
        if (empty($postData['phone']) || !preg_match('/^\+?[0-9]{7,15}$/', $postData['phone'])) {
            $errors['phone'] = 'Inserisci un numero di telefono valido.';
        }

        // Verifica se il campo "message" è vuoto
        if (empty($postData['message'])) {
            $errors['message'] = 'Il messaggio è obbligatorio.';
        }

        // Restituisce un array di errori (vuoto se non ci sono errori)
        return $errors;
    }

    // Metodo per salvare i dati del form in un file JSON
    public function saveFormData($formData) {
        // Percorso del file .txt in cui salvare i dati
        $file = __DIR__ . '/../data/form_submissions.txt';
    
        // Creazione della cartella "data" se non esiste
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    
        // Formattazione dei dati in una stringa leggibile
        $data = sprintf(
            "Nome: %s | Cognome: %s | Email: %s | Telefono: %s | Messaggio: %s | Timestamp: %s\n",
            $formData['nome'],
            $formData['cognome'],
            $formData['email'],
            $formData['phone'],
            $formData['message'],
            date('Y-m-d H:i:s')
        );
    
        // Salva i dati nel file .txt
        if (@file_put_contents($file, $data, FILE_APPEND | LOCK_EX)) {
            return ['success' => true, 'message' => 'Dati salvati correttamente nel file di testo.'];
        } else {
            return ['success' => false, 'message' => 'Errore durante il salvataggio dei dati. Controlla i permessi del file.'];
        }
    }

    // Metodo per generare il footer del sito
    public function generateFooter() {
        // Informazioni per il footer
        $annoCorrente = date("Y");
        $nomeAutore = "Marco Belli";
        $piva = "000000000";
        $socialLinks = [
            "instagram" => [
                "url" => "https://www.instagram.com/",
                "icon" => "../media/instagram.png",
                "alt" => "Logo Instagram"
            ],
            "linkedin" => [
                "url" => "https://www.linkedin.com/in/marco-belli-b0626b30b",
                "icon" => "../media/linkedin.png",
                "alt" => "Logo LinkedIn"
            ]
        ];

        // Inizia a catturare l'output per generare il footer
        ob_start();
        ?>
        <footer>
            <div class="conteiner-footer">
                <div class="conteiner-privacy">
                    <p>
                        <?php echo $nomeAutore; ?> © <?php echo $annoCorrente; ?> · All rights reserved · P.IVA <?php echo $piva; ?>
                        <a href="https://www.iubenda.com/privacy-policy/40502086"
                            class="iubenda-white iubenda-noiframe iubenda-embed"
                            title="Privacy Policy">Privacy Policy</a> & 
                        <a href="https://www.iubenda.com/privacy-policy/40502086/cookie-policy"
                            class="iubenda-white iubenda-noiframe iubenda-embed"
                            title="Cookie Policy">Cookie Policy</a>
                    </p>
                </div>

                <div class="conteiner-btn-footer">
                    <?php foreach ($socialLinks as $social) : ?>
                        <a href="<?php echo $social['url']; ?>" target="_blank" title="Go to <?php echo ucfirst($social['alt']); ?>">
                            <img class="icon" src="<?php echo $social['icon']; ?>" alt="<?php echo $social['alt']; ?>">
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

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
        </footer>
        <?php
        // Restituisce il contenuto generato
        return ob_get_clean();
    }
}
?>