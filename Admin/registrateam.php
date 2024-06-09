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
        <div class="card-header">Registra la password del team</div>
        <div class="card-body">
          <form action="registrateam.php" method="POST">
           
            <div class="form-group">
              <div class="form-label-group">
                <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email " required="required">
                <label for="inputEmail">Email </label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" name="VecchiaPassword" id="inputVecchiaPassword" class="form-control" placeholder="Vecchia Password" required="required">
                <label for="inputVecchiaPassword">Vecchia Password</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required="required">
                    <label for="inputPassword">Password</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm password" required="required">
                    <label for="confirmPassword">Conferma la password</label>
                  </div>
                </div>
              </div>
            </div>
             <button type="submit" class="btn btn-primary btn-block" > Registrati </button> 
          </form>
        </div>
      </div>
    </div>
	
    <?php
$conn = new mysqli("localhost", "root", "", "civicsense");

if ($conn->connect_error) {
    die("Connessione non riuscita: " . $conn->connect_error);
}

$email = isset($_POST['email']) ? $_POST['email'] : null;
$Vpass = isset($_POST['VecchiaPassword']) ? $_POST['VecchiaPassword'] : null;
$pass = isset($_POST['password']) ? $_POST['password'] : null;

if ($email && $Vpass && $pass !== null) {
    $stmt = $conn->prepare("UPDATE team SET password = ? WHERE email_t = ? AND password = ?");
    if ($stmt) {
        $Vpasss= hash('sha256', $Vpass);
        $passs= hash('sha256', $pass);
        $stmt->bind_param("sss", $passs, $email, $Vpasss);
        $result = $stmt->execute();

        if (mysqli_affected_rows($conn)) {
            echo "<br><b><br><p><center><font color=white font face='Courier'> Password registrata! Clicca su <a href='login.php'>Login</a> per accedere. </b></center></p><br><br>";
        } else {
            echo "<br><b><br><p><center><font color=red font face='Courier'>Errore durante la registrazione della password. </b></center></p><br><br>";
        }

        $stmt->close();
    } else {
        echo "<br><b><br><p><center><font color=red font face='Courier'>Errore nella preparazione della query. </b></center></p><br><br>";
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
