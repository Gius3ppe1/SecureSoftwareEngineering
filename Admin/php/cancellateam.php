<?php

$conn = mysqli_connect("localhost", "root", "", "civicsense") or die("Connessione non riuscita");

$cod = (isset($_POST['cod'])) ? $_POST['cod'] : null;

if (isset($_POST['submit2'])) {

    if ($cod == null) {
        echo ("<p> <center> <font color=black font face='Courier'> Compila tutti i campi.</center></p>");
    } elseif ($cod !== null) {
        // Utilizza un prepared statement per la query
        $query = "SELECT * FROM team WHERE codice = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $cod);
        mysqli_stmt_execute($stmt);
        $resultC = mysqli_stmt_get_result($stmt);

        if ($resultC) {
            $row = mysqli_fetch_assoc($resultC);
            if ($row) {
                // Utilizza un prepared statement per eliminare il record
                $query = "DELETE FROM team WHERE codice = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, 's', $cod);
                $result = mysqli_stmt_execute($stmt);

                if ($result) {
                    echo ("<br><b><br><p> <center> <font color=black font face='Courier'> Aggiornamento avvenuto correttamente. Ricarica la pagina per aggiornare la tabella.</b></center></p><br><br> ");
                } else {
                    echo ("<p> <center> <font color=black font face='Courier'> Errore nell'aggiornamento del record.</center></p>");
                }
            } else {
                echo ("<p> <center> <font color=black font face='Courier'> Inserisci un ID esistente.</center></p>");
            }
        }
    }
}

?>
