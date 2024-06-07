<?php

$conn = new mysqli("localhost", "root", "", "civicsense");

if ($conn->connect_error) {
    die("Connessione non riuscita: " . $conn->connect_error);
}


$id = isset($_POST['id']) ? $_POST['id'] : null;
$stato = isset($_POST['stato']) ? $_POST['stato'] : null;

if (isset($_POST['submit'])) {  
    if ($id !== null && $stato !== null) {

        $stmt = $conn->prepare("UPDATE segnalazioni SET stato = ? WHERE id = ?");
        $stmt->bind_param("si", $stato, $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "<br><b><br><p> <center> <font color='black' face='Courier'> Aggiornamento avvenuto correttamente. Ricarica la pagina per aggiornare la tabella.</font></center></p><br><br>";
            } else {
                echo "<p> <center> <font color='black' face='Courier'> Inserisci un ID esistente.</font></center></p>";
            }
        } else {
            echo "<p> <center> <font color='black' face='Courier'> Errore durante l'aggiornamento.</font></center></p>";
        }

        $stmt->close();
    } else {
        echo "<p> <center> <font color='black' face='Courier'> Inserisci tutti i campi.</font></center></p>";
    }
}

$conn->close();
?>
