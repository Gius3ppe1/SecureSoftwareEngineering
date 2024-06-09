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
            <div class="card-header">Registra Team</div>
            <div class="card-body">
                <form action="registrazione.php" method="POST">

                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="email" name="email" id="inputEmail" class="form-control" required="required">
                            <label for="inputEmail">Email </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="text" name="nomi" id="inputNomi" class="form-control" required="required">
                                    <label for="inputNomi">Nomi Componenti</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="text" name="numero" id="numeroComponenti" class="form-control" required="required">
                                    <label for="numeroComponenti">Numero Componenti</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="password" name="password" id="inputPassword" class="form-control" required="required">
                                    <label for="inputPassword">Password</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group">
                                    <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" required="required">
                                    <label for="confirmPassword">Conferma la password</label>
                                </div>
                            </div>
                        </div><br>
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
                                <input type="text" name="answer" id="inputAnswer" class="form-control" required="required">
                                <label for="inputEmail">Risposta </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block"> Registrati </button>
                </form>
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
    $publicIP = getPublicIP();

    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $nomi = isset($_POST['nomi']) ? $_POST['nomi'] : null;
    $numeri = isset($_POST['numero']) ? $_POST['numero'] : null;
    $pass = isset($_POST['password']) ? $_POST['password'] : null;
    $passC = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : null;
    $answer = isset($_POST['answer']) ? $_POST['answer'] : null;

    if ($pass == $passC && ($pass && $email != null)) {
        if ($email !== null && $nomi !== null && $numeri !== null && $pass !== null) {
            $passs = hash('sha256', $pass);
            $stmt = $conn->prepare("INSERT INTO team (email_t, npersone, nomi, password, ip, risposta) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $email, $numeri, $nomi, $passs, $publicIP, $answer);

            if ($stmt->execute()) {
                echo "<b><br><p><center><font color='green' face='Courier'> Inserimento avvenuto correttamente! Ricarica la pagina per vedere la tabella aggiornata!</font></center></p></b>";
            } else {
                echo "<p><center><font color='red' face='Courier'>Errore durante l'inserimento.</font></center></p>";
            }

            $stmt->close();
        } else {
            echo "<p><center><font color='red' face='Courier'>Compila tutti i campi.</font></center></p>";
        }
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