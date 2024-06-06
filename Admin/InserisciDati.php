<?php
$conn = new MySQLi("localhost", "root", "", "civicsense");

$upload_path = 'jpeg/';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file_name = basename($_FILES['image']['name']);
    $file_path = $upload_path . $file_name;
    $img_name = $file_name;
    $email = $_POST['email'];
    $tipo = $_POST['tipo'];
    
    // Mappare i tipi di segnalazione
    $tipo_map = [
        "Segnalazione di area verde" => 1,
        "Rifiuti e pulizia stradale" => 2,
        "Strade e marciapiedi" => 3,
        "Segnaletica e semafori" => 4,
        "Illuminazione pubblica" => 5
    ];
    $tipo = isset($tipo_map[$tipo]) ? $tipo_map[$tipo] : null;

    $via = $_POST['via'];
    $descrizione = $_POST['descrizione'];
    $lat = floatval($_POST['latitudine']);
    $lng = floatval($_POST['longitudine']);

    // Verifica del tipo MIME del file
    $allowed_mimes = ['image/jpeg', 'image/pjpeg'];
    $file_mime = mime_content_type($_FILES['image']['tmp_name']);

    if (!in_array($file_mime, $allowed_mimes)) {
        echo "Tipo di file non consentito.";
        exit;
    }

    // Genera un nome univoco per il file
    $unique_name = uniqid('', true) . '-' . $file_name;
    $file_path = $upload_path . $unique_name;

    try {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {
            $stmt = $conn->prepare("INSERT INTO `segnalazioni`(`datainv`, `orainv`, `via`, `descrizione`, `foto`, `email`, `tipo`, `latitudine`, `longitudine`) VALUES (CURRENT_DATE, CURRENT_TIME, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssiidd", $via, $descrizione, $unique_name, $email, $tipo, $lat, $lng);

            if ($stmt->execute()) {
                echo "Inserimento dei dati completato";
            } else {
                echo "Errore nell'inserimento dei dati";
            }

            $stmt->close();
        } else {
            echo "Errore nel caricamento del file.";
        }
    } catch (Exception $e) {
        echo "Eccezione catturata: " . $e->getMessage();
    }

    $conn->close();
}
?>
