<?php
// Funzione per inserire i dati nel database e salvare le foto
function insertData($productName, $demoLink, $notes, $responsibleId, $available, $photos) {
    include 'dbCredentials.php';
    $dbCredentials = 'dbCredentials';
        
    // Creare connessione
    $conn = new mysqli($dbCredentials::SERVERNAME, $dbCredentials::USERNAME, $dbCredentials::PASSWORD, $dbCredentials::DBNAME);

    // Verifica della connessione
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    // Prepara e esegui la query per ottenere la stringa alfanumerica maggiore presente nel database
    $sql = "SELECT MAX(alphanumeric_string) AS max_string FROM nome_tabella";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $maxString = $row["max_string"];
    $newString = incrementAlphaNumeric($maxString);

    // Prepara e esegui la query per inserire i dati nella tabella del database
    $stmt = $conn->prepare("INSERT INTO nome_tabella (product_name, demo_link, notes, responsible_id, available, photo_path, alphanumeric_string) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiiss", $productName, $demoLink, $notes, $responsibleId, $available, $photoPath, $newString);

    // Ciclo attraverso l'array di foto e le salvo sul disco, ottenendo i percorsi delle foto
    $targetDir = "uploads/";
    $photoPaths = array();
    foreach ($photos['name'] as $key => $photoName) {
        $targetFilePath = $targetDir . basename($photos['name'][$key]);
        move_uploaded_file($photos['tmp_name'][$key], $targetFilePath);
        $photoPaths[] = $targetFilePath;
    }

    // Inserisci i percorsi delle foto nel database
    $photoPath = implode(",", $photoPaths);

    // Esegui la query per inserire i dati nel database
    if ($stmt->execute()) {
        // Restituisci l'ID del prodotto inserito e la nuova stringa alfanumerica
        $productId = $stmt->insert_id;
        return array("id" => $productId, "pCode" => $newString);
    } else {
        echo "Errore durante l'inserimento dei dati nel database: " . $conn->error;
        return null;
    }

    // Chiudi la connessione al database
    $stmt->close();
    $conn->close();
}

// Funzione per incrementare una stringa alfanumerica
function incrementAlphaNumeric($string) {
    // Se la stringa è vuota, restituisci 1
    if (empty($string)) {
        return "1";
    }

    // Se la stringa contiene solo numeri, incrementa il numero di 1
    if (ctype_digit($string)) {
        return (string)((int)$string + 1);
    }

    // Se la stringa contiene caratteri alfabetici e numerici, incrementa il numero e mantieni il resto della stringa
    preg_match_all('/\d+|\D+/', $string, $matches);
    $alphaPart = $matches[1][0];
    $numericPart = $matches[0][0];
    return $alphaPart . ((int)$numericPart + 1);
}

// Esempio di utilizzo della funzione
$productName = $_POST["product-name"];
$demoLink = $_POST["demo-link"];
$notes = $_POST["notes"];
$responsibleId = $_POST["responsible-id"];
$available = $_POST["available"];

// Se sono state inviate foto, passale alla funzione
if (!empty($_FILES["photos"]["name"][0])) {
    $photos = $_FILES["photos"];
} else {
    $photos = null;
}

// Chiamata alla funzione per inserire i dati nel database e ottenere l'ID e la stringa alfanumerica
$result = insertData($productName, $demoLink, $notes, $responsibleId, $available, $photos);

// Se l'operazione è andata a buon fine, visualizza l'ID del prodotto e la stringa alfanumerica
echo(json_encode($result));
?>
