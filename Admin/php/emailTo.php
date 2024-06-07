<?php
session_start();

// Include le classi per l'invio dell'email (PHPMailer 5.2)
require('phpmailer/class.phpmailer.php');
include('phpmailer/class.smtp.php');

// Connessione al database
$conn = new mysqli("localhost", "root", "", "civicsense");
if ($conn->connect_error) {
    die("Connessione non riuscita: " . $conn->connect_error);
}

if (isset($_POST['id']) && isset($_POST['stato'])) {
    $idS = $_POST['id'];
    $stato = $_POST['stato'];

    // Query preparata per evitare SQL injection
    $query = $conn->prepare("SELECT * FROM segnalazioni WHERE id = ?");
    $query->bind_param("i", $idS);
    $query->execute();
    $result = $query->get_result();

    if ($result) {
        $row = $result->fetch_assoc();
        if ($row['stato'] == "In attesa" && $stato == "In risoluzione") { // Confronta stato attuale e quello da modificare
            $update = $conn->prepare("UPDATE segnalazioni SET stato = ? WHERE id = ?");
            $update->bind_param("si", $stato, $idS);
            if ($update->execute()) {
                echo("<br><b><br><p> <center> <font color=black font face='Courier'> Aggiornamento avvenuto correttamente. Ricarica la pagina per aggiornare la tabella.</b></center></p><br><br> ");
                $mail = new PHPMailer(true);

                try {
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = "ssl";
                    $mail->Host = "smtp.gmail.com";
                    $mail->Port = 465;
                    $mail->SMTPKeepAlive = true;
                    $mail->Mailer = "smtp";
                    $mail->Username = "civicsense18@gmail.com";
                    $mail->Password = "c1v1csense2019";
                    $mail->AddAddress($_SESSION['email']);
                    $mail->SetFrom("civicsense18@gmail.com");
                    $mail->Subject = 'Nuova Segnalazione';
                    $mail->Body = "Salve team " . $row['team'] . ", ci è arrivata una nuova segnalazione e vi affido il compito di risolverla"; // Messaggio da inviare
                    $mail->Send();
                    echo "Message Sent OK";
                } catch (phpmailerException $e) {
                    echo $e->errorMessage(); // Errori da PHPMailer
                } catch (Exception $e) {
                    echo $e->getMessage(); // Errori da altrove
                }
            }
        } elseif ($row['stato'] == "In risoluzione" && $stato == "Risolto") {
            $update = $conn->prepare("UPDATE segnalazioni SET stato = ? WHERE id = ?");
            $update->bind_param("si", $stato, $idS);
            if ($update->execute()) {
                echo("<br><b><br><p> <center> <font color=black font face='Courier'> Aggiornamento avvenuto correttamente. Ricarica la pagina per aggiornare la tabella.</b></center></p><br><br> ");
                $mail = new PHPMailer(true);

                try {
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = "ssl";
                    $mail->Host = "smtp.gmail.com";
                    $mail->Port = 465;
                    $mail->SMTPKeepAlive = true;
                    $mail->Mailer = "smtp";
                    $mail->Username = $_SESSION['email'];
                    $mail->Password = $_SESSION['pass'];
                    $mail->AddAddress('civicsense18@gmail.com'); // ente
                    $mail->AddAddress($row['email']); // utente
                    $mail->SetFrom($_SESSION['email']);
                    $mail->Subject = "Segnalazione risolta";
                    $mail->Body = "Il problema presente in " . $row['via'] . " è stato risolto"; // Messaggio da inviare
                    $mail->Send();
                    echo "Message Sent OK";
                } catch (phpmailerException $e) {
                    echo $e->errorMessage(); // Errori da PHPMailer
                } catch (Exception $e) {
                    echo $e->getMessage(); // Errori da altrove
                }
            }
        } else {
            echo "Operazione non disponibile";
        }
    }
    $query->close();
    $conn->close();
}
?>
