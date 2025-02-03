<?php
// Includo il file della classe SiteManager
require_once 'SiteManager.php';

// Creo un alias per la classe SiteManager come SM
use SiteManager as SM;

// Istanzio l'oggetto SM
$sm = new SM();

// Recupero i dati inviati dal form
$input = file_get_contents('php://input');
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';

// Decodifico i dati in base al tipo di contenuto
if (stripos($contentType, 'application/x-www-form-urlencoded') !== false) {
    parse_str($input, $response);
} else {
    $response = [];
}

// Verifica errori nei dati ricevuti
$errors = [];
foreach ($response as $key => $value) {
    if (empty($value)) {
        $errors[$key] = "Il campo " . ucfirst($key) . " è obbligatorio.";
    }
}

// Se ci sono errori, mostrarli e interrompere l'elaborazione
if (!empty($errors)) {
    echo '<p style="color: red; font-size: 1.2rem;">Si sono verificati degli errori:</p>';
    echo '<ul style="color: red; font-size: 1rem;">';
    foreach ($errors as $field => $error) {
        echo '<li><strong>' . htmlspecialchars($field) . ':</strong> ' . htmlspecialchars($error) . '</li>';
    }
    echo '</ul>';
    exit;
}

// Verifica se la directory esiste, altrimenti la crea
$directory = 'data';
if (!is_dir($directory)) {
    mkdir($directory, 0777, true);
}

// Salvataggio dei dati in un file .txt
$file = fopen($directory . '/form_data.txt', 'a');
if ($file) {
    fwrite($file, "Nuovo invio:\n");
    foreach ($response as $key => $value) {
        fwrite($file, ucfirst($key) . ": " . $value . "\n");
    }
    fwrite($file, "------------------------\n");
    fclose($file);
}

// Messaggio di conferma
echo '<p style="color: green; font-size: 1.2rem;">L\'invio è stato eseguito correttamente. Grazie per averci contattato!</p>';
?>
