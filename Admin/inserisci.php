<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Tables</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Grafico -->
    <link rel="stylesheet" href="css/graficostyle.css">

</head>

<body id="page-top">

<div class="card-header">
    <i class="fas fa-table"></i>
    inserisci segnalazione
</div>

<form method="post" action="inserisci.php" style="margin-top:5%; margin-left:5%;" enctype="multipart/form-data">
    <b>DATA INVIO: <input type="date" name="data"><br><br></b>
    <b>ORA INVIO: <input type="time" name="ora"><br><br></b>
    <b>VIA (VIA NOMEVIA, N CIVICO, CAP, PROVINCIA (ES: PULSANO O TARANTO), TA, ITALIA): <input type="text" name="via"><br><br></b>
    <b>DESCRIZIONE: <input type="text" name="descr"><br><br></b>
    <b>FOTO: <input type="file" name="foto"><br><br></b>
    <b>EMAIL (LA VOSTRA): <input type="email" name="email"><br><br></b>
    <b>LATITUDINE: <input type="text" name="lat"><br><br></b>
    <b>LONGITUDINE: <input type="text" name="long"><br><br></b>
    <b>TIPOLOGIA: </b> <select class="text" name="tipo">
        <option value="1">SEGNALAZIONI AREE VERDI</option>
        <option value="2">RIFIUTI E PULIZIA STRADALE</option>
        <option value="3">STRADE E MARCIAPIEDI</option>
        <option value="4">SEGNALETICA E SEMAFORI</option>
        <option value="5">ILLUMINAZIONE PUBBLICA</option>
    </select>

    <input type="submit" name="submit" class="btn btn-primary btn-block" style="width:15%; margin-top:5%;">
</form>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "civicsense");

    if ($conn->connect_error) {
        die("Connessione non riuscita: " . $conn->connect_error);
    }

    $data = isset($_POST['data']) ? $_POST['data'] : null;
    $ora = isset($_POST['ora']) ? $_POST['ora'] : null;
    $via = isset($_POST['via']) ? $_POST['via'] : null;
    $descr = isset($_POST['descr']) ? $_POST['descr'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $lat = isset($_POST['lat']) ? $_POST['lat'] : null;
    $long = isset($_POST['long']) ? $_POST['long'] : null;
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;

    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto = $_FILES['foto']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
    }

    $sql = $conn->prepare("INSERT INTO segnalazioni (datainv, orainv, via, descrizione, foto, email, tipo, latitudine, longitudine) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("ssssbsidd", $data, $ora, $via, $descr, $foto, $email, $tipo, $lat, $long);

    if ($sql->execute()) {
        echo "<center>Inserimento avvenuto.</center>";
    } else {
        echo "<center>Errore nell'inserimento: " . $sql->error . "</center>";
    }

    $sql->close();
    $conn->close();
}

?>
</body>
</html>
