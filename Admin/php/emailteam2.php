<?php

$conn = mysqli_connect("localhost", "root", "", "civicsense") or die("Connessione non riuscita"); 

$id = isset($_POST['id']) ? $_POST['id'] : null;
$team = isset($_POST['team']) ? $_POST['team'] : null;

if ($id && $team !== null) {
    // Utilizza prepared statements per proteggere da SQL injection
    $stmt = mysqli_prepare($conn, "SELECT email_t FROM team WHERE codice = ?");
    mysqli_stmt_bind_param($stmt, 's', $team);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $email_t);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($email_t) {
        echo('<a href="mailto: ' . $email_t . '"><center> Clicca qui per mandare un avviso al team. </center></a>');
    }
}

?>
