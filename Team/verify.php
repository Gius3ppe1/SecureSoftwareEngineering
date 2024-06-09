<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Register</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

    <div class="container">
        <div class="card card-register mx-auto mt-5">
            <center>
                <div class="card-header"><b>Sembra tu stia accedendo da un altro dispositivo!</b></div>
            </center>
            <div class="card-body">
                <form action="verify.php" method="POST">
                    <div>
                        <label for="request">Domanda di Sicurezza</label>
                        <select name="requestValue" id="requestinput" class="form-control">
                            <option value="1">Nome del tuo animale domestico?</option>
                            <option value="2">La tua squadra del cuore?</option>
                            <option value="3">Quale scuola superiore hai frequentato?</option>
                            <option value="4">Qual era il nome della scuola elementare?</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="text" name="risposta" id="inputRisposta" class="form-control" required="required">
                            <label for="inputEmail">Risposta </label>
                        </div>
                        </br>
                        <button type="submit" class="btn btn-primary btn-block"> Verificati </button>
                </form>
            </div>
        </div>
    </div>
    </div>


    <?php
    $conn = new mysqli("localhost", "root", "", "civicsense");

    if ($conn->connect_error) {
        die("Connessione non riuscita: " . $conn->connect_error);
    }

    function getPublicIP()
    {
        $url = 'https://api.ipify.org';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ip = curl_exec($ch);
        curl_close($ch);
        return $ip;
    }
    $ip = getPublicIP();

    $risposta = isset($_POST['risposta']) ? $_POST['risposta'] : null;

    $codice = $_SESSION['idT'];
    if ($risposta != null) {
        $selezione = mysqli_prepare($conn, "SELECT * FROM team WHERE risposta = ? AND codice= ?");
        mysqli_stmt_bind_param($selezione, "si", $risposta, $codice);
        mysqli_stmt_execute($selezione);
        $result = mysqli_stmt_get_result($selezione);

        if ($result && mysqli_num_rows($result) > 0) {
            $stmt = $conn->prepare("UPDATE team SET ip = ? WHERE codice = ?");
            if ($stmt) {
                $stmt->bind_param("si", $ip, $codice);
                $result = $stmt->execute();

                if (mysqli_affected_rows($conn)) {
                    header("location: http://localhost//Ingegneria/Team/index.php");
                } else {
                    echo "<p><center><font color='red' face='Courier'>Errore di variabili.</font></center></p>";
                }

                $stmt->close();
            }
        }
    } else {
        echo "<p><center><font color='red' face='Courier'>Inserisci La Risposta</font></center></p>";
    }

    $conn->close();
    ?>




    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>