<?php

$conn = mysqli_connect("localhost", "root", "", "civicsense") or die("Connessione non riuscita"); 

$id = (isset($_POST['id'])) ? $_POST['id'] : null;
$stato = (isset($_POST['stato'])) ? $_POST['stato'] : null;

if ($id && $stato !== null) {
    // Utilizza prepared statements per proteggere da SQL injection
    $query = "UPDATE segnalazioni SET stato = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $stato, $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo("<br><b><br><p> <center> <font color=black font face='Courier'> Inserimento avvenuto correttamente! Ricarica la pagina per aggiornare la tabella.</b></center></p><br><br> ");
    } else {
        echo("<p> <center> <font color=black font face='Courier'> Errore nell'inserimento dei dati.</center></p>");
    }
}

?>
