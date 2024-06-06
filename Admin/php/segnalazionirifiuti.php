<?php
$conn = mysqli_connect("localhost", "root", "", "civicsense") or die("Connessione non riuscita");




$upload_path = 'img/';
$quer = mysqli_query($conn, "SELECT * FROM segnalazioni WHERE tipo = '2' ");




while ($row = mysqli_fetch_assoc($quer)) {
  echo "
    <tr>
     
    <td>" . htmlspecialchars($row['id']) . "<br></td>
    <td>" . htmlspecialchars($row['datainv']) . "<br></td>
    <td>" . htmlspecialchars($row['orainv']) . "<br></td>
    <td>" . htmlspecialchars($row['via']) . "<br></td>
    <td>" . htmlspecialchars($row['descrizione']) . "<br></td>
    <td><img width='200px' height='200px' src='" . htmlspecialchars($upload_path . $row['foto']) . "'><br></td>
    <td>" . htmlspecialchars($row['tipo']) . "<br></td>
    <td>" . htmlspecialchars($row['stato']) . "<br></td>
    <td>" . htmlspecialchars($row['gravita']) . "<br></td>
               
          </tr> ";
}
