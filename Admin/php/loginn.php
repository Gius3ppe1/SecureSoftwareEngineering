<?php
// Recupero dati
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email == "civicsense18@gmail.com") {
        if ($password == "admin") {
            echo 'Accesso consentito alla sezione riservata';
        } else {
            echo 'Accesso negato alla sezione riservata. La password è errata!';
        }
    } else {
        // Connessione al database
        $conn = mysqli_connect("localhost", "root", "", "civicsense") or die("Connessione non riuscita");

        // Prepara la query SQL utilizzando un prepared statement
        $sql = 'SELECT * FROM team WHERE email_t = ?';
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($password != $row["password"] || $email != $row["email_t"]) {
                    echo 'ATTENZIONE: La password o l\'email inserita non è corretta!';
                } else {
                    echo 'Accesso consentito area riservata (TEAM)';
                }
            }
        } else {
            echo 'ATTENZIONE: Utente non trovato';
        }

        // Chiudi la connessione al database
        mysqli_close($conn);
    }
} else {
    echo 'Non esistono;';
}
?>
